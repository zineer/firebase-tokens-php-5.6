<?php

namespace Firebase\Auth\Token;

use Fig\Http\Message\RequestMethodInterface as RequestMethod;
use Firebase\Auth\Token\Cache\InMemoryCache;
use Firebase\Auth\Token\Domain\KeyStore;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @see https://firebase.google.com/docs/auth/admin/verify-id-tokens#verify_id_tokens_using_a_third-party_jwt_library
 */
final class HttpKeyStore implements KeyStore
{
    const KEYS_URL = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @deprecated 1.9.0
     */
    public function __construct(ClientInterface $client = null, CacheInterface $cache = null)
    {
        $client = !is_null($client) ? $client : new Client();
        $cache = !is_null($cache) ? $cache : new InMemoryCache();

        $this->client = $client;
        $this->cache = $cache;
    }

    public function get($keyId)
    {
        if ($key = $this->cache->get($keyId)) {
            return $key;
        }

        $response = $this->client->request(RequestMethod::METHOD_GET, self::KEYS_URL);
        $keys = json_decode((string) $response->getBody(), true);
        
        if (!($key = $keys[$keyId])) {
            throw new \OutOfBoundsException(sprintf('Key with ID "%s" not found.', $keyId));
        }
        
        $reponseCacheControl = $response->getHeaderLine('Cache-Control');
        $reponseCacheControl = !is_null($reponseCacheControl) ? $reponseCacheControl : '';

        $ttl = preg_match('/max-age=(\d+)/i', $reponseCacheControl, $matches)
            ? (int) $matches[1]
            : null;

        $this->cache->set($keyId, $key, $ttl);

        return $key;
    }
}
