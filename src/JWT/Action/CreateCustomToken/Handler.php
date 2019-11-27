<?php

namespace Kreait\Firebase\JWT\Action\CreateCustomToken;

use Kreait\Firebase\JWT\Action\CreateCustomToken;
use Kreait\Firebase\JWT\Contract\Token;
use Kreait\Firebase\JWT\Error\CustomTokenCreationFailed;

interface Handler
{
    /**
     * @throws CustomTokenCreationFailed
     */
    public function handle(CreateCustomToken $action);
}
