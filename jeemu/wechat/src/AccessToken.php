<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/20
 * Time: 15:23
 */
namespace Jeemu\Wechat;
use Jeemu\Dispatcher;

class AccessToken extends Wechat
{
    protected $url = '/cgi-bin/token?grant_type=client_credential&';
    protected $cacheKey = 'wechatAccessToken';

    public function __construct($appid, $appsecret)
    {
        parent::__construct($appid,$appsecret);
    }

    public function get():string
    {
        $cache = Dispatcher::getInstance()->getCache('redis');
        $cacheData = $cache->get($this->cacheKey);
        if ($cacheData){
            return $cacheData;
        }
        $this->url .= 'appid='.$this->appid.'&secret='.$this->appsecret;
        $result = curlHttpsGet($this->api.$this->url);
        $result = json_decode($result);
        if (isset($result->access_token)){
            $cache->set($this->cacheKey,$result->access_token,isset($result->expires_in)?$result->expires_in  - 600:$this->cacheTtl);
            return $result->access_token;
        }else{
            $this->setError('获取AccessToken',json_encode($result),isset($result->errmsg)?$result->errmsg:$this->defaultError);
            return '';
            //失败
        }
    }

    public function getForce(){
        $this->url .= 'appid='.$this->appid.'&secret='.$this->appsecret;
        $result = curlHttpsGet($this->url);
        $result = json_decode($result);
        if (isset($result->access_token)){
            $cache = Dispatcher::getInstance()->getCache('redis');
            $cache->set($this->cacheKey,$result->access_token,isset($result->expires_in)?$result->expires_in  - 600:$this->cacheTtl);
            return $result->access_token;
        }else{
            $this->setError('获取AccessToken',json_encode($result),isset($result->errmsg)?$result->errmsg:$this->defaultError);
            return '';
            //失败
        }
    }
}