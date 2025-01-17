<?php

namespace Kreait\Firebase\JWT\Cache;

use DateInterval;
use Kreait\Clock;
use Kreait\Clock\SystemClock;
use Psr\SimpleCache\CacheInterface;

final class InMemoryCache implements CacheInterface
{
    /** @var array */
    private $items = [];

    /** @var Clock */
    private $clock;

    private function __construct()
    {
        $this->clock = new SystemClock();
    }

    public static function createEmpty()
    {
        return new self();
    }

    public function withClock(Clock $clock)
    {
        $cache = new self();
        $cache->clock = $clock;

        return $cache;
    }

    public function get($key, $default = null)
    {
        $now = $this->clock->now();

        if ($item = $this->items[$key] ?? null) {
            list($expiresAt, $value) = $item;

            if (!$expiresAt || $expiresAt > $now) {
                return $value;
            }

            $this->delete($key);
        }

        return $default;
    }

    public function set($key, $value, $ttl = null)
    {
        $now = $this->clock->now();
        $expires = null;

        if ($ttl instanceof DateInterval) {
            $expires = $now->add($ttl);
        }

        if (is_int($ttl) && $ttl > 0) {
            $expires = $now->setTimestamp($now->getTimestamp() + $ttl);
        }

        $this->items[$key] = [$expires, $value];

        return true;
    }

    public function delete($key)
    {
        unset($this->items[$key]);

        return true;
    }

    public function clear()
    {
        $this->items = [];

        return true;
    }

    public function getMultiple($keys, $default = null)
    {
        $result = [];

        foreach ($keys as $key) {
            $result[$key] = $this->get($key, $default);
        }

        return $result;
    }

    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    public function has($key)
    {
        $now = $this->clock->now();

        if ($item = $this->items[$key] ?? null) {
            $expiresAt = $item[0];

            if (!$expiresAt || $now < $expiresAt) {
                return true;
            }
        }

        return false;
    }
}
