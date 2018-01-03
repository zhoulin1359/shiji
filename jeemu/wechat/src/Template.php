<?php
/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/3
 * Time: 12:16
 */

namespace Jeemu\Wechat;


class Template extends Wechat
{
    protected $url = '/cgi-bin/message/template/send?access_token=';

    public function __construct()
    {

    }

    public function sendTemplateMsg(string $templateId, string $accessToken, string $openid, array $data, string $url = ''): array
    {
        //$accessToken = (new AccessToken())
        $param = [
            'touser' => $openid,
            'template_id' => $templateId,
            'url' => $url,
            'data' => $data
        ];
        $result = curlHttpsPost($this->api . $this->url . $accessToken, json_encode($param));
        $result = json_decode($result, true);
        if (isset($result['msgid'])) {
            return $result;
        }
        $this->setError('sendTemplateMsg', '', $result);
        return [];
    }
}