<?php
declare(strict_types=1);

namespace bingher\filesystem\driver;

putenv('AWS_SUPPRESS_PHP_DEPRECATION_WARNING=1');

use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Visibility;
use think\helper\Arr;
use bingher\filesystem\Driver;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\PortableVisibilityConverter as AwsS3PortableVisibilityConverter;

class S3 extends Driver
{

    protected function createAdapter()
    {
        $s3Config    = $this->formatS3Config($this->config);
        $root        = (string) ($s3Config['root'] ?? '');
        $visibility  = new AwsS3PortableVisibilityConverter(
            $this->config['visibility'] ?? Visibility::PUBLIC
        );
        $streamReads = $s3Config['stream_reads'] ?? false;
        $client      = new S3Client($s3Config);
        return new AwsS3V3Adapter($client, $s3Config['bucket'], $root, $visibility, null, $this->config['options'] ?? [], $streamReads);
    }

    protected function formatS3Config(array $config)
    {
        $config += ['version' => 'latest'];

        if (!empty($config['key']) && !empty($config['secret'])) {
            $config['credentials'] = Arr::only($config, ['key', 'secret', 'token']);
        }

        return Arr::except($config, ['token']);
    }

    protected function getUrl(string $path)
    {
        $expireAt = new \DateTime();
        $expireAt->add(\DateInterval::createFromDateString(($this->config['expire'] ?? 1800) . ' seconds'));
        $options = new \League\Flysystem\Config;
        return $this->adapter->temporaryUrl($path, $expireAt, $options);
    }
}
