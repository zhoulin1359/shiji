<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 0:02
 */
class DbJeemuUserModel extends Db_JeemuBase
{
    public function setByPhone(string $phone, string $password): bool
    {
        $data['phone'] = $phone;
        $data['salt'] = randStr(16);
        $data['password'] = md5($password . $data['salt']);
        $data['insert_time'] = time();
        $this->insert($data);
        if ($this->dbObj->id()) {
            return true;
        }
        return false;
    }

    /*
     * "{"openid":"o2v4SwuiQtqk00qEaPTWg-jjQ0MI",
     * "nickname":"积木","sex":1,"language":"zh_CN",
     * "city":"深圳","province":"广东","country":"中国",
     * "headimgurl":"http:\/\/wx.qlogo.cn\/mmopen\/vi_32\/DYAIOgq83epnfU0xRUrHo3suopzXxZGyTkfNfmEz9a8PRWxcwBQPs8NXkwvBL1sxOJaUKGV3Fiajs5q3fXFmiaMg\/0",
     * "privilege":[]}"
     */
    public function setByWechat(string $openid, string $nick, int $sex, int $resId): int
    {
        if ($uid = $this->getUidByOpenid($openid)) {
            $this->updateByWechat($nick, $sex, $resId);
            return $uid;
        }
        $data['openid'] = $openid;
        $data['nick'] = $nick;
        $data['sex'] = $sex;
        $data['headimg_res_id'] = $resId;
        $data['insert_time'] = time();
        $data['update_time'] = time();
        $this->insert($data);
        if ($id = $this->dbObj->id()) {
            return $id;
        }
        return 0;
    }

    public function updateByWechat(string $nick, int $sex, int $resId): bool
    {
        $data['nick'] = $nick;
        $data['sex'] = $sex;
        $data['headimg_res_id'] = $resId;
        $data['update_time'] = time();
        if ($this->update($data)->rowCount()) {
            return true;
        }
        return false;
    }

    public function getUidByOpenid(string $openid): int
    {
        $data = $this->get(['id'], ['openid[=]' => $openid]);
        if ($data) {
            return $data['id'];
        }
        return 0;
    }

    public function hasByOpenid(string $openid): bool
    {
        return $this->has(['openid[=]' => $openid]);
    }
}