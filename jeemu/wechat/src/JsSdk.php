<?php
/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/20
 * Time: 16:45
 */

namespace Jeemu\Wechat;


use Jeemu\Dispatcher;

class JsSdk extends Wechat
{
    protected $url = '/cgi-bin/ticket/getticket?';
    protected $cacheKey = 'wechatJsapiTicket';
    public function __construct(string $appid,string $appsecret)
    {
        parent::__construct($appid,$appsecret);
    }

    public function get(string $url):array {
        $nonceStr = randStr(16);
        $timeStamp = time();
        $jsapiTicket = $this->getJsapiTicket();
        if (empty($jsapiTicket)){
            return [];
        }
        $str = 'jsapi_ticket='.$jsapiTicket.'&noncestr='.$nonceStr.'&timestamp='.$timeStamp.'&url='.$url;
        $signature = sha1($str);
        return [
            'appid'=>$this->appid,
            'nonceStr'=>$nonceStr,
            'timeStamp'=>$timeStamp,
            'url'=>$url,
            'signature'=>$signature
        ];
    }

    private function getJsapiTicket():string {
        $cache = Dispatcher::getInstance()->getCache('redis');
        $cacheData = $cache->get($this->cacheKey);
        if ($cacheData){
            return $cacheData;
        }
        $accessTokenObj = (new AccessToken($this->appid,$this->appsecret));
        $accessToken = $accessTokenObj->get();
        if (empty($accessToken)){
            $accessToken = $accessTokenObj->getForce();
            if (empty($accessToken)){
                return '';
            }
        }
        $this->url .= 'access_token='.$accessToken.'&type=jsapi';
        $result = curlHttpsGet($this->api.$this->url);
        $result = json_decode($result);
        if (isset($result->errcode) && $result->errcode == 0){
            $cache->set($this->cacheKey,$result->ticket,isset($result->expires_in)?$result->expires_in - 600:$this->cacheTtl);
            return $result->ticket;
        }else{
            $this->setError('获取JsSdk参数错误',json_encode($result),isset($result->errmsg)?$result->errmsg:$this->defaultError);
            return '';
        }
    }

}