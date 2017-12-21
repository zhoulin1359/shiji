<?php
/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/20
 * Time: 16:47
 */

namespace Jeemu\Wechat;


class Wechat
{
    protected $api = 'https://sz.api.weixin.qq.com';
    protected $url;
    protected $appid;
    protected $appsecret;
    protected $cacheKey;
    protected $cacheTtl = 6500;

    public function __construct(string $appid, string $appsecret)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
    }
}