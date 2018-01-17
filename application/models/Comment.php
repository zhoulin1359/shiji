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
        $data = $this->select(['id', 'uid', 'content', 'to_uid', 'praise', 'insert_time'], ['target_id[=]' => $oilId, 'type[=]' => 1, 'status[=]' => 1, 'ORDER' => [$order => 'DESC'], 'LIMIT' => [$pageNum, $pageSize]]);
        if ($data) {

        }
        return [];
    }
}