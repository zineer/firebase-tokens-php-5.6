<?php

namespace Kreait\Firebase\JWT\Contract;

trait KeysTrait
{
    /** @var array */
    private $values = [];

    public function all()
    {
        return $this->values;
    }
}
