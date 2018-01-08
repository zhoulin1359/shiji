<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/8
 * Time: 17:59
 */
class ResModel extends Jeemu\Db\Connect\Mysql
{
    public function setByUrl(string $url): int
    {
        if ($id = $this->getIdByUrl($url)) {
            return $id;
        }
        $data['original_name'] = '微信头像';
        $data['mime_type'] = 'image/png';
        $data['url'] = $url;
        $data['key'] = md5($url);
        $data['insert_time'] = time();
        $data['update_time'] = time();
        $this->insert($data);
        if ($result = $this->dbObj->id()) {
            return $result;
        }
        return 0;
    }

    public function set(string $originalName, string $url, string $mimeType, int $size, string $key, int $uid): int
    {
        $data['original_name'] = $originalName;
        $data['mime_type'] = $mimeType;
        $data['url'] = $url;
        $data['size'] = $size;
        $data['key'] = $key;
        $data['uid'] = $uid;
        $data['insert_time'] = time();
        $data['update_time'] = time();
        $this->insert($data);
        if ($id = $this->dbObj->id()) {
            return $id;
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


    public function getIdAndUrlByKey(string $key): array
    {
        $result = [];
        $data = $this->get(['id', 'url'], ['key[=]' => $key]);
        if ($data) {
            $result = $data;
        }
        return $result;
    }


    /**
     * ids查询
     * @param string $ids
     * @return array
     */
    public function getIdAndUrlByIds(array $ids): array
    {
        $result = [];
        $data = $this->select(['id', 'url'], ['id' => $ids]);
        if ($data) {
            $result = $data;
        }
        return $result;
    }

    public function hasByUrl(string $url): bool
    {
        return $this->has(['key[=]' => md5($url)]);
    }


}