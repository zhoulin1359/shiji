<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/8
 * Time: 18:11
 */
class AuthorModel extends Jeemu\Db\Connect\Mysql
{
    public function getNameByIds(array $ids):array {
        $data = $this->select(['id','name'],['id'=>$ids]);
        if ($data){
            return $data;
        }
        return [];
    }
}