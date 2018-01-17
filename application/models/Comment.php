<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/17
 * Time: 20:17
 */
class CommentModel extends \Jeemu\Db\Connect\Mysql
{
    public function getByOilId(int $oilId, int $pageNum = 0, int $pageSize = 0, string $order = 'praise'): array
    {
        if ($pageSize === 0) {
            $pageSize = conf('page_set.size');
        }
        $data = $this->select(['id', 'uid', 'content', 'praise', 'insert_time'], ['target_id[=]' => $oilId, 'type[=]' => 1, 'status[=]' => 1, 'ORDER' => [$order => 'DESC'], 'LIMIT' => [$pageNum, $pageSize]]);
        if ($data) {
            $uidArr = [];
            foreach ($data as $value) {
                $uidArr[] = $value['uid'];
            }
            $uidData = (new UserModel())->getNameAndHeadImgByUids($uidArr);
            foreach ($data as $key => $value) {
                $data[$key]['insert_time'] = date(conf('client_style.date'),$value['insert_time']);
                $data[$key]['nick'] = isset($uidData[$value['uid']]) ? $uidData[$value['uid']]['nick'] : '';
                $data[$key]['head_img'] = isset($uidData[$value['uid']]) ? $uidData[$value['uid']]['url'] : '';
            }
            return $data;
        }
        return [];
    }
}