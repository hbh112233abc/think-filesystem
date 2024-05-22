<?php
declare(strict_types=1);

namespace bingher\filesystem\driver;

use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use bingher\filesystem\Driver;

class Ftp extends Driver
{
    protected function createAdapter()
    {
        if (!isset($this->config['root'])) {
            $this->config['root'] = '';
        }

        return new FtpAdapter(FtpConnectionOptions::fromArray($this->config));
    }
}
