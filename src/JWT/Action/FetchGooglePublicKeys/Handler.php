<?php


namespace Kreait\Firebase\JWT\Action\FetchGooglePublicKeys;

use Kreait\Firebase\JWT\Action\FetchGooglePublicKeys;
use Kreait\Firebase\JWT\Contract\Keys;

interface Handler
{
    public function handle(FetchGooglePublicKeys $action);
}
