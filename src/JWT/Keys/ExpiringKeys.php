<?php

namespace Kreait\Firebase\JWT\Keys;

use DateTimeImmutable;
use Kreait\Firebase\JWT\Contract\Expirable;
use Kreait\Firebase\JWT\Contract\ExpirableTrait;
use Kreait\Firebase\JWT\Contract\Keys;
use Kreait\Firebase\JWT\Contract\KeysTrait;

final class ExpiringKeys implements Keys, Expirable
{
    use KeysTrait;
    use ExpirableTrait;

    private function __construct()
    {
        $this->expirationTime = new DateTimeImmutable('0001-01-01'); // Very distant past :)
    }

    public static function withValuesAndExpirationTime($values, DateTimeImmutable $expirationTime)
    {
        $keys = new self();
        $keys->values = $values;
        $keys->expirationTime = $expirationTime;

        return $keys;
    }
}
