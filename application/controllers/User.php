<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 0:08
 */
class UserController extends BaseController
{
    public function registerAction()
    {
        $param['phone'] = \Jeemu\Dispatcher::getInstance()->getRequest()->getBody('phone');
        $param['password'] = \Jeemu\Dispatcher::getInstance()->getRequest()->getBody('password');
        $param['code'] = \Jeemu\Dispatcher::getInstance()->getRequest()->getBody('code');
        $valid = GUMP::is_valid($param, [
            'phone' => 'required|phone_number|exact_len,11',
            'password' => 'required|min_len,6|max_len,18',
            'code' => 'required|exact_len,6'
        ]);
        if ($valid !== true) {
            return jsonResponse([$param], -1, $valid[0]);
        }
        $smsModel = new DbJeemuSmsModel();
        $smsData = $smsModel->getSmsByPhone($param['phone']);
        if (empty($smsData)){
            return jsonResponse([$smsData,$smsModel->getLog()],-1,'短信验证码不正确');
        }
        if ($param['code'] != $smsData['code']){
            return jsonResponse([$smsData],-1,'短信验证码不正确');
        }
        if ($param['phone'] != $smsData['phone']){
            return jsonResponse([3],-1,'短信验证码不正确');
        }
        $smsModel->updateStatusById((int)$smsData['id']);

        $model = new DbJeemuUserModel();
        if ($uid = $model->setByPhone($param['phone'], $param['password'])) {
            $userInfo = $model->getUserLoginInfoById($uid);
            if (!empty($userInfo)) {
                $this->login($uid, $userInfo['group_id'], $userInfo['nick'], $userInfo['head_img'], isWechat());
                return jsonResponse();
            }else{
                return jsonResponse([$model->getError(),$model->getLog()], -1, '服务器出现问题!请重试....');
            }
        } else {
            return jsonResponse([], -1, '服务器出现问题!请重试....');
        }
    }


    public function isLoginAction()
    {
        if ($this->uid) {
            return jsonResponse([true]);
        }
        return jsonResponse([false]);
    }

    public function getLoginUrlAction()
    {
        $path = (getRequestQuery('path') ? '?path=' . getRequestQuery('path') : '');
        if (isWechat()) {
            return jsonResponse(['type' => 'go', 'url' => (new Jeemu\Wechat\UserInfo(conf('wechat.appid'), conf('wechat.appsecret')))->getBaseUrl(Jeemu\Dispatcher::getInstance()->getRequest()->host . '/api/wechat/code' . $path)],1);
        }
        return jsonResponse(['type' => 'push', 'url' => '/login'.$path],1);
    }


    public function loginUrlAction(){
        if ($this->uid){
            return jsonResponse([]);
        }
        return jsonResponse([],302,'请登录');
    }
}