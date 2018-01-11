<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/11
 * Time: 17:38
 */
class FocusTargetModel extends \Jeemu\Db\Connect\Mysql
{
    public function isFocusByTypeAndTargetId(int $targetId, string $type, int $uid): bool
    {
        $type = $this->getType($type);
        $data = $this->has(['target_id[=]' => $targetId, 'uid[=]' => $uid, 'type[=]' => $type, 'status[=]' => 1]);
        if ($data) {
            return true;
        }
        return false;
    }


    private function getType(string $type): int
    {
        switch ($type) {
            case 'oil':
                $result = 1;
                break;
            default:
                $result = 0;
        }
        return $result;
    }
}