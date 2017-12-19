<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/19
 * Time: 17:55
 */
require_once APP_PATH . '/vendor/taobao-sdk-PHP-auto_1455552377940-20160607/Autoloader.php';

class DbJeemuSmsModel extends Db_JeemuBase
{
    private $timeOut = 3600;
    private $smsError = '';

    public function set(string $phone): bool
    {
        $appKey = conf('alidayu.app_key');
        $appSecret = conf('alidayu.app_secret');

        $c = new TopClient;
        $c->appkey = $appKey;
        $c->secretKey = $appSecret;
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("牛迷之家");
        $data['code'] = rand(100000, 999999);
        $req->setSmsParam(json_encode(['code'=>$data['code']]));
        $req->setRecNum($phone);
        $req->setSmsTemplateCode("SMS_13050283");
        $resp = $c->execute($req);
        $resp = json_decode($resp);
        if (isset($resp->error_response)){
            $this->smsError = $resp->error_response->sub_msg;
            return false;
        }
        $data['phone'] = $phone;
        $data['code'] = rand(100000, 999999);
        $data['expire_time'] = time() + $this->timeOut;
        $data['insert_time'] = time();
        $this->insert($data);
        if ($this->dbObj->id()) {
            return true;
        }
        return false;
    }

    public function get(string $phone): array
    {
        $result = [];
        $data = $this->select(['id', 'phone', 'code'], ['phone[=]' => $phone, 'status[=]' => 1, 'expire_time[<=]' => time(), 'ORDER' => ['id' => 'DESC'], 'LIMIT' => 1]);
        if ($data) {
            $result = $data;
        }
        return $result;
    }

    public function getSmsError()
    {
        return $this->smsError;
    }
}