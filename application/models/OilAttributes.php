<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/16
 * Time: 23:09
 */
class OilAttributesModel extends \Jeemu\Db\Connect\Mysql
{
    public function getByOilId(int $oilId): array
    {
        $data = $this->select(['key', 'value'], ['oil_id[=]' => $oilId, 'ORDER' => ['order' => 'DESC']]);
        if ($data) {
            return $data;
        }
        return [];
    }
}