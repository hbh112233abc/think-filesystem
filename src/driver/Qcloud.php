<?php

declare(strict_types=1);

namespace bingher\filesystem\driver;

use Overtrue\Flysystem\Cos\CosAdapter;
use bingher\filesystem\Driver;

class Qcloud extends Driver
{

    protected function createAdapter()
    {
        return new CosAdapter($this->config);
    }
}
