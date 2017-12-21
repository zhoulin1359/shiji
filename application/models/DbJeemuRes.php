<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 22:46
 */
class DbJeemuResModel extends Db_JeemuBase
{
    public function setByUrl(string $url): int
    {
        if ($id = $this->getIdByUrl($url)){
            return $id;
        }
        $data['original_name'] = '微信头像';
        $data['mime_type'] = 'image/png';
        $data['url'] = $url;
        $data['key'] = md5($url);
        $data['insert_time'] = time();
        $this->insert($data);
        if ($result = $this->dbObj->id()) {
            return $result;
        }
        return 0;
    }

    public function getUrlById(int $id): string
    {
        $result = '';
        $data = $this->get(['url'], ['id[=]' => $id]);
        if ($data) {
            $result = $data['url'];
        }
        return $result;
    }


    public function getIdByUrl(string $url): int
    {
        $data = $this->get(['id'], ['key[=]' => md5($url)]);
        if ($data) {
            return $data['id'];
        }
        return 0;
    }

    public function hasByUrl(string $url): bool
    {
        return $this->has(['key[=]' => md5($url)]);
    }
}