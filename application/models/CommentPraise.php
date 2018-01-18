<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/18
 * Time: 14:16
 */
class CommentPraiseModel extends \Jeemu\Db\Connect\Mysql
{
    public function getExistByCidAndUid(int $cid, int $uid): array
    {
        $data = $this->get(['id', 'status'], ['c_id[=]' => $cid, 'uid[=]' => $uid]);
        if ($data) {
            return $data;
        }
        return [];
    }

    public function set(int $cid, int $uid, int $id): array
    {
        if (!empty($id)) {
            $data = $this->getStatusAndUidById($id);
            if ($data && $data['uid'] == $uid) {
                if ($data['status']) {
                    return ['status' => true, 'id' => $id, 'add' => false];
                }
                if ($this->updateStatusById($id)) {
                    return ['status' => true, 'id' => $id, 'add' => true];
                }
                return ['status' => false, 'id' => $id, 'add' => false];
            }
        }
        $data = $this->getExistByCidAndUid($cid, $uid);
        if ($data) {
            if ($data['status']) {
                return ['status' => true, 'id' => $data['id'], 'add' => false];
            }
            if ($this->updateStatusById($data['id'])) {
                return ['status' => true, 'id' => $data['id'], 'add' => true];
            }
            return ['status' => false, 'id' => $data['id'], 'add' => false];
        }
        $insertData['c_id'] = $cid;
        $insertData['uid'] = $uid;
        $insertData['insert_time'] = time();
        $insertData['update_time'] = time();
        if ($this->insert($insertData)->rowCount()) {
            return ['status' => true, 'id' => $this->getInsertId(), 'add' => true];
        }
        return ['status' => false, 'id' => 0, 'add' => false];
    }


    public function cancel(int $id, int $uid): array
    {
        $data = $this->getStatusAndUidById($id);
        if ($data['uid'] == $uid) {
            if (empty($data['status'])) {
                return ['status' => true, 'dec' => false, 'c_id' => $data['c_id']];
            }
            if ($this->updateStatusById($id, 0)) {
                return ['status' => true, 'dec' => true, 'c_id' => $data['c_id']];
            }
            return ['status' => false, 'dec' => false, 'c_id' => $data['c_id']];
        }
        return ['status' => false, 'dec' => false, 'c_id' => 0];
    }

    public function getIdByCidsAndUid(array $cids, int $uid): array
    {
        $data = $this->select(['id','c_id'], ['c_id' => $cids, 'uid[=]' => $uid, 'status[=]' => 1]);
        if ($data) {
            return DataModel::handleArray($data, 'c_id', 'id');
        }
        return [];
    }


    public function getStatusAndUidById(int $id): array
    {
        $data = $this->get(['uid', 'status', 'c_id'], ['id[=]' => $id]);
        if ($data) {
            return $data;
        }
        return [];
    }

    public function hasByCidAndUid(int $cid, int $uid): bool
    {
        return $this->has(['c_id[=]' => $cid, 'uid[=]' => $uid]);
    }


    public function updateStatusById(int $id, int $status = 1): bool
    {
        if ($this->update(['status' => $status, 'update_time' => time()],['id[=]'=>$id])->rowCount()) {
            return true;
        }
        return false;
    }
}