<?php

namespace Devzzk\LaravelOss;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class OssServiceProvider extends ServiceProvider
{
    /**
     * @return void
     * @throws \OSS\Core\OssException
     */
    public function boot()
    {
        app('filesystem')->extend('oss', function ($app, $config) {
            $root = $config['root'] ?? '';
            $buckets = $config['buckets'] ?? [];

            $adapter = new OssAdapter(
                accessKeyId: $config['access_id'],
                accessKeySecret: $config['access_key'],
                endpoint: $config['endpoint'],
                bucket: $config['bucket'],
                isCName: $config['isCName'],
                prefix: $root ,
                buckets: $buckets
            );

            $adapter->setCdnUrl($config['url'] ?? null);

            return new FilesystemAdapter(new Filesystem($adapter), $adapter, $config);
        });
    }
}
