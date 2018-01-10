<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/10
 * Time: 20:22
 */
class LoginModel
{
    static public function login(int $uid, int $groupId, string $nick, string $headImg, bool $isWechat = false): bool
    {
        $session = session();
        $session->set('uid', $uid);
        $session->set('groupId', $groupId);
        $session->set('nick', $nick);
        $session->set('headImg', $headImg);

        $uuid = randStr(16) . $uid;
        $encodeUuid = (new Aes_Xcrypt(conf('aes.key')))->encode($uuid);
        $response = response();
        $response->setCookie($response::COOKIE_UUID, base64_encode($encodeUuid), $isWechat ? $response::COOKIE_WECHAT_UUID_TTL : $response::COOKIE_UUID_TTL);
        $cookieRedis = new RedisCookieModel();
        $cookieRedis->set($uuid, ['uid' => $uid, 'user_agent' => md5(request()->userAgent)]);
        return true;
    }



    static public function loginOut(){

    }
}