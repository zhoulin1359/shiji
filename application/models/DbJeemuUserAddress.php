<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 23:16
 */
class DbJeemuUserAddressModel extends Db_JeemuBase
{
    public function set(int $uid, string $country, string $province, string $city): bool
    {
        if ($this->hasByUid($uid)) {
            //更新
            return $this->updateAddress($uid, $country, $province, $city);
        }
        $data['uid'] = $uid;
        $data['country'] = $country;
        $data['province'] = $province;
        $data['city'] = $city;
        $data['insert_time'] = time();
        $data['update_time'] = time();
        if ($this->insert($data)->rowCount()) {
            return true;
        }
        return false;
    }


    public function updateAddress(int $uid, string $country, string $province, string $city): bool
    {
        $data['country'] = $country;
        $data['province'] = $province;
        $data['city'] = $city;
        $data['update_time'] = time();
        if ($this->update($data, ['uid[=]' => $uid])->rowCount()) {
            return true;
        }
        return false;
    }

    public function hasByUid(int $uid): bool
    {
        return $this->has(['uid[=]' => $uid]);
    }
}