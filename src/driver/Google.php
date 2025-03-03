<?php
declare(strict_types=1);

namespace bingher\filesystem\driver;

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use bingher\filesystem\Driver;

class Google extends Driver
{
    protected function createAdapter()
    {
        $storageClient = new StorageClient([
            'projectId' => $this->config['project_id'],
        ]);
        $bucket        = $storageClient->bucket($this->config['bucket']);

        return new GoogleCloudStorageAdapter($bucket, $this->config['prefix'] ?? '');
    }
}
