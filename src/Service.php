<?php

declare(strict_types=1);

namespace bingher\filesystem;

class Service extends \think\Service
{
    public function register()
    {
        $this->app->bind('filesystem', Filesystem::class);
    }
}
