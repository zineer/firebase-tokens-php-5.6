<?php

namespace Kreait\Firebase\JWT\Contract;

interface Token
{
    public function headers();

    public function payload();

    public function toString();

    public function __toString();
}
