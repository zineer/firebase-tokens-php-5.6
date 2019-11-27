<?php


namespace Kreait\Firebase\JWT;

use Kreait\Clock\SystemClock;
use Kreait\Firebase\JWT\Action\CreateCustomToken;
use Kreait\Firebase\JWT\Action\CreateCustomToken\Handler;
use Kreait\Firebase\JWT\Action\CreateCustomToken\WithHandlerDiscovery;
use Kreait\Firebase\JWT\Contract\Token;
use Kreait\Firebase\JWT\Error\CustomTokenCreationFailed;

final class CustomTokenGenerator
{
    /** @var Handler */
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public static function withClientEmailAndPrivateKey($clientEmail, $privateKey)
    {
        $handler = new WithHandlerDiscovery($clientEmail, $privateKey, new SystemClock());

        return new self($handler);
    }

    public function execute(CreateCustomToken $action)
    {
        return $this->handler->handle($action);
    }

    /**
     * @throws CustomTokenCreationFailed
     */
    public function createCustomToken($uid, $claims = null, $timeToLive = null)
    {
        $action = CreateCustomToken::forUid($uid);

        if ($claims !== null) {
            $action = $action->withCustomClaims($claims);
        }

        if ($timeToLive !== null) {
            $action = $action->withTimeToLive($timeToLive);
        }

        return $this->execute($action);
    }
}
