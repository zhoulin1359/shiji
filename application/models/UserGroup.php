<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/10
 * Time: 17:51
 */
class UserGroupModel extends \Jeemu\Db\Connect\Mysql
{
    public function getRolesByGroup(int $groupId): array
    {
        $data = $this->get(['role'], ['id[=]' => $groupId]);
        if ($data) {
            return explode('|',$data['role']);
        }
        return [];
    }
}