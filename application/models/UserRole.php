<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/10
 * Time: 17:48
 */
class UserRoleModel extends Jeemu\Db\Connect\Mysql
{
    public function getIdByRole(string $role): int
    {
        $data = $this->get(['id'], ['role[=]' => $role]);
        if ($data) {
            return (int)$data['id'];
        }
        return 0;
    }
}