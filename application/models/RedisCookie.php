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

    public function set(string $uuid, $uid, int $ttl = 0): bool
    {
        if (empty($ttl)) {
            $ttl = $this->ttl;
        }
        return $this->handle->set($uuid, $uid, $ttl) ? true : false;
    }

    public function get(string $uuid): array
    {
        $data = $this->handle->get($uuid);
        if ($data) {
            return (array)$data;
        }
        return [];
    }

    public function has(string $uuid): bool
    {
        return $this->handle->exists($uuid);
    }
}