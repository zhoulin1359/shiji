<?php
/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/5
 * Time: 19:28
 */

namespace Jeemu;


class Request
{
    private $quest;
    private $post;
    private $body;
    private $method;
    private $requsetHandle;

    public $host;
    public $url;
    public $userAgent;
    public $referer;

    public function __construct()
    {
        $this->requsetHandle = \Yaf\Dispatcher::getInstance()->getRequest();
        $this->method = $this->requsetHandle->method;
        $this->quest = \GUMP::xss_clean($this->requsetHandle->getQuery());
        if ($this->method == 'POST') {
            if($temp = $this->requsetHandle->getPost()){
                $this->post = \GUMP::xss_clean($temp);
            }
            if ($temp = json_decode(file_get_contents('php://input'), true)){
                $this->body = \GUMP::xss_clean($temp);
            }

        }
        $this->url = $this->requsetHandle->url;
        $this->host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->referer = $_SERVER['HTTP_ORIGIN'];
    }


    /**
     * @return string
     */
    public function getCookie(string $name, $default = null)
    {
        return $this->requsetHandle->getCookie($name, $default);
    }

    public function getPost(string $name, $default = null)
    {
        return isset($this->post[$name]) ? $this->post[$name] : $default;
    }

    public function getQuery(string $name, $default = null)
    {
        return isset($this->quest[$name]) ? $this->quest[$name] : $default;
    }

    public function getBody(string $name, $default = null)
    {
        return isset($this->body[$name]) ? $this->body[$name] : $default;
    }
}