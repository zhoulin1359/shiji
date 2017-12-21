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


    private function checkLogin(){
        if ($uid = $this->session->get('uid')){
            $this->uid = $uid;
        }
    }


    //private function
    protected function login(int $uid, int $groupId, string $nick, string $headImg): bool
    {
        $this->session->set('uid', $uid);
        $this->session->set('groupId', $groupId);
        $this->session->set('nick', $nick);
        $this->session->set('headImg', $headImg);

        $uuid = randStr(16).$uid;
        $uuid = (new Aes_Xcrypt(conf('aes.key')))->encode($uuid);
        $response = response();
        $response->setCookie($response::COOKIE_UUID,base64_encode($uuid),$response::COOKIE_UUID_TTL);
        $cookieRedis = new RedisCookieModel();
        $cookieRedis->set($uuid,$uid);
        return true;
    }
}