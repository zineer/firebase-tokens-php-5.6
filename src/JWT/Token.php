<?php

namespace Kreait\Firebase\JWT;

final class Token implements Contract\Token
{
    /** @var string */
    private $encodedString;

    /** @var array */
    private $headers;

    /** @var array */
    private $payload;

    private function __construct()
    {
    }

    public static function withValues($encodedString, $headers, $payload)
    {
        $token = new self();

        $token->encodedString = $encodedString;
        $token->headers = $headers;
        $token->payload = $payload;

        return $token;
    }

    public function headers()
    {
        return $this->headers;
    }

    public function payload()
    {
        return $this->payload;
    }

    public function toString()
    {
        return $this->encodedString;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
