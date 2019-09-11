<?php

namespace Firebase\Auth\Token;

use Firebase\Auth\Token\Domain\KeyStore;
use Lcobucci\JWT\Token;

/**
 * @deprecated 1.9.0
 * @see \Kreait\Firebase\JWT\IdTokenVerifier
 * @see \Kreait\Firebase\JWT\CustomTokenGenerator
 *
 * @codeCoverageIgnore
 */
final class Handler implements Domain\Generator, Domain\Verifier
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var Verifier
     */
    private $verifier;

    /**
     * @deprecated 1.7.0 Use the Generator and Verifier directly instead
     *
     * @param string $projectId
     * @param string $clientEmail
     * @param string $privateKey
     * @param KeyStore|null $keyStore
     */
    public function __construct($projectId, $clientEmail, $privateKey, $keyStore = null)
    {
        $this->generator = new Generator($clientEmail, $privateKey);
        $keyStore = is_null($keyStore) ? new HttpKeyStore() : $keyStore;
        $this->verifier = new Verifier($projectId, $keyStore);
    }

    public function createCustomToken($uid, array $claims = [], \DateTimeInterface $expiresAt = null)
    {
        return $this->generator->createCustomToken($uid, $claims, $expiresAt);
    }

    public function verifyIdToken($token)
    {
        return $this->verifier->verifyIdToken($token);
    }
}
