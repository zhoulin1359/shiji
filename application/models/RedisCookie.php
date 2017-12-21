<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/21
 * Time: 22:33
 */
class RedisCookieModel extends Db_RedisCookie
{
    protected $ttl = 86400 * 30;

    public function set(string $uuid, int $uid, int $ttl = 0): bool
    {
        if (!empty($ttl)) {
            $ttl = $this->ttl;
        }
        return $this->handle->set($uuid, $uid, $ttl) ? true : false;
    }

    public function get(string $uuid): int
    {
        $data = $this->handle->get($uuid);
        if ($data) {
            return (int)$data;
        }
        return 0;
    }

    public function has(string $uuid): bool
    {
        return $this->handle->exists($uuid);
    }
}