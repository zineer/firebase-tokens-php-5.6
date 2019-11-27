<?php

namespace Kreait\Firebase\JWT\Keys;

use Kreait\Firebase\JWT\Contract\Keys;
use Kreait\Firebase\JWT\Contract\KeysTrait;

final class StaticKeys implements Keys
{
    use KeysTrait;

    private function __construct()
    {
    }

    public static function empty()
    {
        return new self();
    }

    public static function withValues($values)
    {
        $keys = new self();
        $keys->values = $values;

        return $keys;
    }
}
