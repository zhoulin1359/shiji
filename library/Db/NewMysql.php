<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/3
 * Time: 15:14
 */
class Db_NewMysql extends Db_MysqlBase implements Db_Interface
{
    protected $replaceArr = ['Model'];

    public function getType():string
    {
        return 'db_jeemu';
        // TODO: Implement getType() method.
    }
}