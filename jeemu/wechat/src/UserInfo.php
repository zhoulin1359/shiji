<?php
/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/20
 * Time: 19:43
 */

namespace Jeemu\Wechat;


class UserInfo extends Wechat
{
    private $baseUrl = 'https://open.weixin.qq.com';

    public function __construct(string $appid, string $appsecret)
    {
        parent::__construct($appid, $appsecret);
    }

    public function getBaseUrl(string $redictUrl, string $scope = 'snsapi_userinfo'): string
    {
        return $this->baseUrl . '/connect/oauth2/authorize?appid=' . $this->appid . '&redirect_uri=' . $redictUrl . '&response_type=code&scope=' . $scope . '&state=STATE#wechat_redirect';
    }

    public function getAccessToken(string $code): array
    {
        $url = $this->api . '/sns/oauth2/access_token?appid=' . $this->appid . '&secret=' . $this->appsecret . '&code=' . $code . '&grant_type=authorization_code';
        $result = curlHttpsGet($url);
        $result = json_decode($result);
        if (isset($result->access_token)) {
            return ['access_token' => $result->access_token, 'openid' => $result->openid];
        } else {
            $this->setError('获取用户信息AccessToken', json_encode($result), isset($result->errmsg) ? $result->errmsg : $this->defaultError);
            return [];
        }
    }


    public function getUserInfo(string $accessToken, string $openid): array
    {
        $url = $this->api . '/sns/userinfo?access_token=' . $accessToken . '&openid=' . $openid . '&lang=zh_CN';
        $result = curlHttpsGet($url);
        $result = json_decode($result, true);
        if (isset($result['openid'])) {
            return $result;
        }else{
            $this->setError('获取用户信息Info', json_encode($result), isset($result->errmsg) ? $result->errmsg : $this->defaultError);
            return [];
        }
    }
}