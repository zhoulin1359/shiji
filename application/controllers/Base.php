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

    public function init()
    {
        $this->session = session();
        $this->session->start();
    }


    //private function
    protected function login(int $uid,int $groupId,string $nick,string $headImg){

    }
}