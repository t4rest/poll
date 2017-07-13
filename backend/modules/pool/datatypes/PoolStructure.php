<?php

namespace backend\modules\user\datatypes;

use common\datatypes\Structure;
use common\models\Pool;

class PoolStructure implements Structure
{
    /**
     * @var Pool
     */
    private $pool;

    public function __construct($pool)
    {
        $this->pool = $pool;
    }

    public function serialize(): array
    {
        $pool = [

        ];

        return $pool;
    }
}








