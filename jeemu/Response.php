<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/11/17
 * Time: 14:55
 */

namespace Jeemu;


class Response
{
    const COOKIE_UUID = 'SHIJI_UUID';
    const COOKIE_UUID_TTL = 86400 * 30;
    const COOKIE_WECHAT_UUID_TTL = 86400 * 1;
    const RESPONSE_INFO_100 = '服务器出现问题';
    const RESPONSE_INFO_1 = 'success';

    private $response;
    private $data = [];
    private $msg;
    private $status = 1;
    private $sendHtml = false;

    public function __construct(\Yaf\Response\Http $response)
    {
        $this->response = $response;
        $this->response->setHeader('Content-Type', 'application/json;charset=utf-8');
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Credentials', 'true'); //允许cookie
        $this->response->setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT');
    }


    public function setCookie(string $key, string $value, int $ttl = 86400, string $path = '/', string $domain = null, bool $seure = true, bool $httpOnly = true)
    {
        if (empty($ttl)) {
            setcookie($key, $value);
        } else {
            setcookie($key, $value, time() + $ttl, $path, $domain ? $domain : $_SERVER['HTTP_HOST'], $seure, $httpOnly);
        }

    }


    public function setData($data)
    {
        if (empty($this->data)) {
            $this->data = $data;
        } else {
            $this->data[] = $data;
        }
        //array_unshift($this->data, $data);
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function setMsg(string $msg)
    {
        $this->msg = $msg;
    }

    public function sendHtml(string $html):bool {
        $this->sendHtml = true;
        echo ($html);
        return true;
    }

    public function __destruct()
    {
        if ($this->sendHtml){
            return;
        }
        $this->response->clearBody();
        $callback = getRequestQuery('callback');
        if ($callback) {
            $this->response->setBody($callback . '(' . json_encode(array('status' => $this->status, 'msg' => $this->msg, 'data' => $this->data)) . ')');
        } else {
            $this->response->setBody(json_encode(array('status' => $this->status, 'msg' => $this->msg, 'data' => $this->data)));
        }
        $this->response->response();
        // TODO: Implement __destruct() method.
    }
}