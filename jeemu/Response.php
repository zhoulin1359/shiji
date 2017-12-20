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
    private $response;
    private $data = [];
    private $msg;
    private $status = 1;

    public function __construct(\Yaf\Response\Http $response)
    {
        $this->response = $response;
        $this->response->setHeader('Content-Type', 'application/json;charset=utf-8');
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Credentials', 'true'); //允许cookie
        $this->response->setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT');
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

    public function __destruct()
    {
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