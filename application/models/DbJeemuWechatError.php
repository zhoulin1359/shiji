<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/20
 * Time: 18:16
 */
class DbJeemuWechatErrorModel extends Db_JeemuBase
{
    public function set(string $api, string $content): bool
    {
        $data['api'] = $api;
        $data['content'] = $content;
        $data['insert_time'] = time();
        $data['update_time'] = time();
        if ($this->insert($data)->rowCount()) {
            return true;
        }
        return false;
    }
}