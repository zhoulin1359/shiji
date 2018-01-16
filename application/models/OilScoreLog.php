<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/16
 * Time: 10:16
 */
class OilScoreLogModel extends \Jeemu\Db\Connect\Mysql
{
    public function set(int $oilId, int $uid, int $score): bool
    {
        $data['oil_id'] = $oilId;
        $data['uid'] = $uid;
        $data['score'] = $score;
        $data['insert_time'] = time();
        if ($this->insert($data)->rowCount()) {
            return true;
        }
        return false;
    }

    public function getScoreByOliIdAndUid(int $oilId, int $uid): array
    {
        $data = $this->get(['score'], ['oil_id[=]' => $oilId, 'uid[=]' => $uid]);
        if ($data) {
            return ['exist' => true, 'score' => (int)$data['score']];
        }
        return ['exist' => false, 'score' => 0];
    }


    public function hasByOilIdAndUid(int $oilId, int $uid): bool
    {
        return $this->has(['oil_id[=]' => $oilId, 'uid[=]' => $uid]);
    }
}