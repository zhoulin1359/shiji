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
    protected $wechatError;
    protected $defaultError = '未知的错误发生了';

    public function __construct(string $appid, string $appsecret)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
    }


    protected function setError(string $api, string $error, string $errorMsg): bool
    {
        (new \DbJeemuWechatErrorModel())->set($api, $error);
        $this->wechatError = $errorMsg;
        return true;
    }

    public function getError(): string
    {
        return $this->wechatError;
    }
}