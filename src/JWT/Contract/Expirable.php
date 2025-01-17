<?php

namespace Kreait\Firebase\JWT\Contract;

use DateTimeImmutable;
use DateTimeInterface;

interface Expirable
{
    public function withExpirationTime(DateTimeImmutable $time);

    public function isExpiredAt(DateTimeInterface $now);

    public function expiresAt();
}
