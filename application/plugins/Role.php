<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/10
 * Time: 18:14
 */
class RolePlugin extends Yaf\Plugin_Abstract
{
    private $session;
    private $uid = 0;


    public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
        $this->session = session();
        $this->session->start();
        if ($uid = $this->session->get('uid')) {
            $this->uid = $uid;
        } else {
            $uuid = request()->getCookie(response()::COOKIE_UUID);
            if ($uuid) {
                $aes = new Aes_Xcrypt(conf('aes.key'));
                $uuid = $aes->decode(base64_decode($uuid));
                if (!empty($uuid)) {
                    $cookieRedis = new RedisCookieModel();
                    $uid = $cookieRedis->get($uuid);
                    if (isset($uid['user_agent']) && $uid['user_agent'] === md5(request()->userAgent) && isset($uid['uid'])) {
                        $userData = (new UserModel())->getUserLoginInfoById($uid['uid']);
                        if (!empty($userData)) {
                            $this->uid = $uid['uid'];
                            LoginModel::login($uid['uid'], $userData['group_id'], $userData['nick'], $userData['head_img'], isWechat());
                        }
                    } else {
                        response()->setCookie(response()::COOKIE_UUID, 0, -1);
                    }
                } else {
                    response()->setCookie(response()::COOKIE_UUID, 0, -1);
                }
            }
        }



        $uri = $request->getRequestUri();
        $roleId = (new UserRoleModel())->getIdByRole($uri);
        if (empty($roleId)){
            jsonResponse([],404,'找不到当前页面');die;
        }
        if (empty($this->uid)){
            $groupId = 0;
        }else{
            if (isset($userData['group_id'])){
                $groupId = $userData['group_id'];
            }else{
                $groupId = (new UserModel())->getGroupIdByUid($this->uid);
            }
        }
        $roleArr = (new UserGroupModel())->getRolesByGroup($groupId);
        if (!in_array($roleId,$roleArr)){
            jsonResponse([],302,'请登录');die;
        }
    }
}