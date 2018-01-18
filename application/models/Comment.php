<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/17
 * Time: 20:17
 */
class CommentModel extends \Jeemu\Db\Connect\Mysql
{
    public function getByOilId(int $oilId, int $order = 0, int $pageNum = 0, int $pageSize = 0): array
    {
        if ($pageSize === 0) {
            $pageSize = conf('page_set.size');
        }
        $order = $order == 0 ? 'praise' : 'insert_time';
        $data = $this->select(['id', 'uid', 'content', 'praise', 'insert_time'], ['target_id[=]' => $oilId, 'type[=]' => 1, 'status[=]' => 1, 'ORDER' => [$order => 'DESC'], 'LIMIT' => [$pageNum, $pageSize]]);
        if ($data) {
            $uidArr = [];
            foreach ($data as $value) {
                $uidArr[] = $value['uid'];
            }
            $uidData = (new UserModel())->getNameAndHeadImgByUids($uidArr);
            foreach ($data as $key => $value) {
                $data[$key]['insert_time'] = DataModel::handleTimeGetDate($value['insert_time']);
                $data[$key]['nick'] = isset($uidData[$value['uid']]) ? $uidData[$value['uid']]['nick'] : '';
                $data[$key]['head_img'] = isset($uidData[$value['uid']]) ? $uidData[$value['uid']]['url'] : '';
                $data[$key]['praise'] = (int)$value['praise'];
            }
            return $data;
        }
        return [];
    }


    public function addPraiseById(int $id): bool
    {
        if ($this->dbObj->query('UPDATE `his_comment` SET `praise` = `praise` + 1, `update_time` = ' . time() . ' WHERE `id` = ' . $id)->rowCount()) {
            return true;
        }
        return false;
    }

    public function decPraiseById(int $id): bool
    {
        if ($this->dbObj->query('UPDATE `his_comment` SET `praise` = `praise` - 1, `update_time` = ' . time() . ' WHERE `id` = ' . $id)->rowCount()) {
            return true;
        }
        return false;
    }
}