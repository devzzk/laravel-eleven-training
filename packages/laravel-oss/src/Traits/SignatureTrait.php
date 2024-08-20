<?php

namespace Devzzk\LaravelOss\Traits;

trait SignatureTrait
{
    /**
     * gmt.
     *
     * @return string
     *
     * @throws \Exception
     */
    public function gmt_iso8601($time)
    {
        // fix bug https://connect.console.aliyun.com/connect/detail/162632
        return (new \DateTime('', new \DateTimeZone('UTC')))->setTimestamp($time)->format('Y-m-d\TH:i:s\Z');
    }
}
