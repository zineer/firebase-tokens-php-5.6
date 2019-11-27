<?php

namespace Kreait\Firebase\JWT\Action;

use DateInterval;
use Kreait\Firebase\JWT\Value\Duration;

final class FetchGooglePublicKeys
{
    const DEFAULT_URL = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';
    const DEFAULT_FALLBACK_CACHE_DURATION = 'PT1H';

    private $url = self::DEFAULT_URL;

    /** @var Duration */
    private $fallbackCacheDuration;

    private function __construct()
    {
        $this->fallbackCacheDuration = Duration::fromDateIntervalSpec(self::DEFAULT_FALLBACK_CACHE_DURATION);
    }

    public static function fromGoogle()
    {
        return new self();
    }

    /**
     * Use this method only if Google has changed the default URL and the library hasn't been updated yet.
     */
    public static function fromUrl($url)
    {
        $action = new self();
        $action->url = $url;

        return $action;
    }

    /**
     * A response from the Google APIs should have a cache control header that determines when the keys expire.
     * If it doesn't have one, fall back to this value.
     *
     * @param Duration|DateInterval|string| int $duration
     */
    public function ifKeysDoNotExpireCacheFor($duration)
    {
        $duration = Duration::make($duration);

        $action = new self();
        $action->fallbackCacheDuration = $duration;

        return $action;
    }

    public function url()
    {
        return $this->url;
    }

    public function getFallbackCacheDuration()
    {
        return $this->fallbackCacheDuration;
    }
}
