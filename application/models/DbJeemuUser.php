<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 0:02
 */
class DbJeemuUserModel extends Db_JeemuBase
{
    public function setByPhone(string $phone,string $password):bool {
        $data['phone'] = $phone;
        $data['salt'] = randStr(16);
        $data['password'] = md5($password.$data['salt']);
        $data['insert_time'] = time();
        $this->insert($data);
        if ($this->dbObj->id()){
            return true;
        }
        return false;
    }
}