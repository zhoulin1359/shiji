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
        $this->session->start();
        $this->checkLogin();
    }


    private function checkLogin()
    {
        if ($uid = $this->session->get('uid')) {
            $this->uid = $uid;
        } else {
            $uuid = request()->getCookie(response()::COOKIE_UUID);
            if ($uuid) {
                $uuid = (new Aes_Xcrypt(conf('aes.key')))->decode(base64_decode($uuid));
                if ($uuid !== false) {
                    $cookieRedis = new RedisCookieModel();
                    $uid = $cookieRedis->get($uuid);
                    if ($uid) {
                        $userData = (new DbJeemuUserModel())->getUserLoginInfoById($uid);
                        if (!empty($userData)) {
                            if (isWechat()) {
                                $this->loginByWechat($uid, $userData['group_d'], $userData['nick'], $userData['head_img']);
                            } else {
                                $this->loginByPhone($uid, $userData['group_d'], $userData['nick'], $userData['head_img']);
                            }
                        }
                    }else{
                        response()->setCookie(response()::COOKIE_UUID,0,-1);
                    }
                }else{
                    response()->setCookie(response()::COOKIE_UUID,0,-1);
                }
            }
        }
    }

    protected function getUserLoginInfo(string $key, $default = null)
    {
        return $this->session->get($key, $default);
    }


    //private function
    protected function loginByPhone(int $uid, int $groupId, string $nick, string $headImg): bool
    {
        $this->session->set('uid', $uid);
        $this->session->set('groupId', $groupId);
        $this->session->set('nick', $nick);
        $this->session->set('headImg', $headImg);

        $uuid = randStr(16) . $uid;
        $uuid = (new Aes_Xcrypt(conf('aes.key')))->encode($uuid);
        $response = response();
        $response->setCookie($response::COOKIE_UUID, base64_encode($uuid), $response::COOKIE_UUID_TTL);
        $cookieRedis = new RedisCookieModel();
        $cookieRedis->set($uuid, $uid);
        return true;
    }

    protected function loginByWechat(int $uid, int $groupId, string $nick, string $headImg): bool
    {
        $this->session->set('uid', $uid);
        $this->session->set('groupId', $groupId);
        $this->session->set('nick', $nick);
        $this->session->set('headImg', $headImg);

        $uuid = randStr(16) . $uid;
        $uuid = (new Aes_Xcrypt(conf('aes.key')))->encode($uuid);
        $response = response();
        $response->setCookie($response::COOKIE_UUID, base64_encode($uuid), $response::COOKIE_WECHAT_UUID_TTL);
        $cookieRedis = new RedisCookieModel();
        $cookieRedis->set($uuid, $uid);
        return true;
    }
}