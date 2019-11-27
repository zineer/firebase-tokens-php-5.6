<?php

namespace Kreait\Firebase\JWT\Action;

use InvalidArgumentException;

final class VerifyIdToken
{
    /** @var string */
    private $token = '';

    /** @var int */
    private $leewayInSeconds = 0;

    private function __construct()
    {
    }

    public static function withToken($token)
    {
        $action = new self();
        $action->token = $token;

        return $action;
    }

    public function withLeewayInSeconds($seconds)
    {
        if ($seconds < 0) {
            throw new InvalidArgumentException('Leeway must not be negative');
        }

        $action = clone $this;
        $action->leewayInSeconds = $seconds;

        return $action;
    }

    public function token()
    {
        return $this->token;
    }

    public function leewayInSeconds()
    {
        return $this->leewayInSeconds;
    }
}
