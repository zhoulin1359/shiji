<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/3
 * Time: 15:12
 */
class WechatTemplateModel extends Db_NewMysql
{
    public function set(int $msgId,string $templateId,string $openId,string $msg,int $uid): bool
    {

        $data['msg_id'] = $msgId;
        $data['template_id'] = $templateId;
        $data['openid'] = $openId;
        $data['msg'] = $msg;
        $data['uid'] = $uid;
        $data['result'] = '';
        $data['insert_time'] = time();
        $data['update_time'] = time();
        if ($this->insert($data)->rowCount()) {
            return true;
        }
        return false;
    }
}