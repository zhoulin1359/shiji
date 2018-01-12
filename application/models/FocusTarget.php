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


    public function focus(int $targetId, string $type, int $focusId , int $uid): bool
    {
        if ($result = $this->getIdAndStatusByTargetIdAndType($targetId, $type, $uid)) {
            if ($result['status'] == 1) {
                return true;
            } else {
                if ($this->updateStatusById((int)$result['id'])) {
                    return true;
                }
                return false;
            }
        }
        if ($this->set($targetId, $type, $uid, $focusId)) {
            return true;
        }
        return false;
    }


    public function cancel(int $targetId, string $type, int $uid): bool
    {
        if ($result = $this->getIdAndStatusByTargetIdAndType($targetId, $type, $uid)) {
            if ($result['status'] == 0) {
                return true;
            }
            if ($this->updateStatusById((int)$result['id'], 0)) {
                return true;
            }
            var_dump($this->getLog());
            return false;
        }
        return true;
    }

    public function set(int $targetId, string $type, int $uid, int $focusId): bool
    {
        $data['target_id'] = $targetId;
        $data['type'] = $this->getType($type);
        $data['uid'] = $uid;
        $data['focus_id'] = $focusId;
        $data['insert_time'] = time();
        $data['update_time'] = $data['insert_time'];
        $this->insert($data);
        if ($this->dbObj->id()) {
            return true;
        }
        return false;
    }

    /**
     * 更新状态
     * @param int $id
     * @param int $status
     * @return bool
     */
    public function updateStatusById(int $id, int $status = 1): bool
    {
        if ($this->update(['status' => $status, 'update_time' => time()], ['id[=]' => $id])->rowCount()) {
            return true;
        }
        return false;
    }


    public function getIdAndStatusByTargetIdAndType(int $targetId, string $type, int $uid): array
    {
        $type = $this->getType($type);
        $data = $this->get(['id', 'status'], ['target_id[=]' => $targetId, 'uid[=]' => $uid, 'type[=]' => $type]);
        if ($data) {
            return $data;
        }
        return [];
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