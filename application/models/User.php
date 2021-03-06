<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 0:02
 */
class UserModel extends \Jeemu\Db\Connect\Mysql
{
    public function setByPhone(string $phone, string $password): int
    {
        $data['headimg_res_id'] = 1;
        $data['phone'] = $phone;
        $data['salt'] = randStr(16);
        $data['password'] = $this->getPassword($password, $data['salt']);
        $data['insert_time'] = time();
        $data['update_time'] = time();
        $this->insert($data);
        if ($id = $this->dbObj->id()) {
            $this->update(['nick' => '史迹_' . $id], ['id[=]' => $id]);
            return $id;
        }
        return 0;
    }


    public function getPassword(string $password, string $salt)
    {
        return md5($password . $salt);
    }

    public function getNameAndHeadImgByUids(array $uids): array
    {
        $data = $this->joinSelect(['user.id', 'nick','url'],['[>]res'=>['headimg_res_id'=>'id']], ['user.id' => $uids]);
        if ($data) {
            return DataModel::handleArray($data, 'id');
        }
        return [];
    }

    /**
     * 获取用户登录信息
     * @param int $id
     * @return array
     */
    public function getUserLoginInfoById(int $id): array
    {
        $result = [];
        $data = $this->get(['nick', 'group_id', 'headimg_res_id'], ['id[=]' => $id, 'status[=]' => 1]);
        if ($data) {
            $result = $data;
            $result['head_img'] = (new DbJeemuResModel())->getUrlById($data['headimg_res_id']);
        }
        return $result;
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

    public function getLoginInfoByPhone(string $phone): array
    {
        $result = [];
        $data = $this->get(['id', 'password', 'salt', 'nick', 'group_id', 'headimg_res_id', 'status'], ['phone[=]' => $phone]);
        if ($data) {
            $result = $data;
        }
        return $result;
    }

    public function getGroupIdByUid(int $id): int
    {
        $data = $this->get(['group_id'], ['id[=]' => $id]);
        if ($data) {
            return (int)$data['group_id'];
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

    public function hasByPhone(string $phone): bool
    {
        return $this->has(['phone[=]' => $phone]);
    }
}