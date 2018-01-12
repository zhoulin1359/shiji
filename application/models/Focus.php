<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/12
 * Time: 14:43
 */
class FocusModel extends \Jeemu\Db\Connect\Mysql
{
    public function getListByUid(int $uid): array
    {
        $data = $this->select(['id', 'name'], ['uid[=]' => $uid]);
        if ($data) {
            return $data;
        }
        return [];
    }


    public function set(string $name, int $uid): int
    {
        if ($id = $this->getIdByNameAndUid($name, $uid)) {
            return $id;
        }
        $data['name'] = $name;
        $data['uid'] = $uid;
        $data['insert_time'] = time();
        $data['update_time'] = time();
        $this->insert($data);
        if ($id = $this->dbObj->id()) {
            return $id;
        }
        return 0;
    }


    public function getIdByNameAndUid(string $name, int $uid): int
    {
        $data = $this->get(['id'], ['name[=]' => $name, 'uid[=]' => $uid]);
        if ($data) {
            return (int)$data['id'];
        }
        return 0;
    }

    public function hasByNameAndUid(string $name, int $uid): bool
    {
        return $this->has(['name[=]' => $name, 'uid[=]' => $uid]);
    }
}