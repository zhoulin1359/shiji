<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/11/15
 * Time: 18:03
 */
class BaseController extends Yaf\Controller_Abstract
{
    protected $session;
    protected $uid = 0;

    public function init()
    {
        $this->session = session();
        $this->uid = $this->getUserInfo('uid');
    }

    protected function getUserLoginInfo(string $key, $default = null)
    {
        return $this->session->get($key, $default);
    }


   /* //private function
    protected function login(int $uid, int $groupId, string $nick, string $headImg, bool $isWechat = false): bool
    {
        $this->uid = $uid;

        $this->session->set('uid', $uid);
        $this->session->set('groupId', $groupId);
        $this->session->set('nick', $nick);
        $this->session->set('headImg', $headImg);

        $uuid = randStr(16) . $uid;
        $encodeUuid = (new Aes_Xcrypt(conf('aes.key')))->encode($uuid);
        $response = response();
        $response->setCookie($response::COOKIE_UUID, base64_encode($encodeUuid), $isWechat ? $response::COOKIE_WECHAT_UUID_TTL : $response::COOKIE_UUID_TTL);
        $cookieRedis = new RedisCookieModel();
        $cookieRedis->set($uuid, ['uid' => $uid, 'user_agent' => md5(request()->userAgent)]);
        return true;
    }*/


    protected function getUserInfo(string $key)
    {
        return $this->session->get($key);
    }
}