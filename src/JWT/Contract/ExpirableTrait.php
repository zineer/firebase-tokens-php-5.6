<?php

namespace Kreait\Firebase\JWT\Contract;

use DateTimeImmutable;
use DateTimeInterface;
use LogicException;

trait ExpirableTrait
{
    /** @var DateTimeImmutable */
    private $expirationTime;

    /**
     * @return static
     */
    public function withExpirationTime(DateTimeImmutable $expirationTime)
    {
        $expirable = clone $this;
        $expirable->expirationTime = $expirationTime;

        return $expirable;
    }

    public function isExpiredAt(DateTimeInterface $now)
    {
        return $this->expirationTime < $now;
    }

    public function expiresAt()
    {
        // @codeCoverageIgnoreStart
        if (!$this->expirationTime) {
            throw new LogicException(static::class.' allows calling '.__METHOD__.' before setting it.');
        }
        // @codeCoverageIgnoreEnd

        return $this->expirationTime;
    }
}
