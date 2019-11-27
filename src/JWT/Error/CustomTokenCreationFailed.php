<?php

namespace Kreait\Firebase\JWT\Error;

use RuntimeException;
use Throwable;

final class CustomTokenCreationFailed extends RuntimeException
{
    public static function because($reason, $code = null, Throwable $previous = null)
    {
        $code = $code ?: 0;

        return new self($reason, $code, $previous);
    }
}
