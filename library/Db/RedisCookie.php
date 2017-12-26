<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/21
 * Time: 22:29
 */
class Db_RedisCookie extends Db_RedisBase implements Db_Interface
{

    public function __construct()
    {
        parent::__construct();
        $this->handle->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
    }


    public function getType(): string
    {
        return 'redis_cookie';
        // TODO: Implement getType() method.
    }
}