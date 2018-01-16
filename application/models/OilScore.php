<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/16
 * Time: 10:01
 */
class OilScoreModel extends \Jeemu\Db\Connect\Mysql
{


    public function set(int $oilId, int $score): bool
    {
        $data = $this->get(['id', 'total_score', 'total_user'], ['oil_id[=]' => $oilId]);
        if ($data) {
            $updateData['total_score'] = ($data['total_score'] + $score);
            $updateData['total_user'] = ($data['total_user'] + 1);
            $updateData['score'] = number_format($updateData['total_score'] / $updateData['total_user'], 2);
            $updateData['update_time'] = time();
            if ($this->update($updateData)->rowCount()) {
                return true;
            }
            return false;
        }
        $insertData['oil_id'] = $oilId;
        $insertData['total_score'] = $score;
        $insertData['total_user'] = 1;
        $insertData['score'] = $score;
        $insertData['insert_time'] = time();
        $insertData['update_time'] = time();
        if ($this->insert($insertData)->rowCount()) {
            return true;
        }
        return false;
    }

    /**
     * 获取分数
     * @param int $oilId
     * @return int
     */
    public function getScoreByOilId(int $oilId): float
    {
        $data = $this->get(['score'], ['oil_id[=]' => $oilId]);
        if ($data) {
            return $data['score'];
        }
        return conf('client_oil.default_score');
    }
}