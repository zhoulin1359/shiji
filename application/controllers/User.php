<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 0:08
 */
class UserController extends BaseController
{

    public function loginAction(){
        $param['phone'] = \Jeemu\Dispatcher::getInstance()->getRequest()->getBody('phone');
        $param['password'] = \Jeemu\Dispatcher::getInstance()->getRequest()->getBody('password');
        $valid = GUMP::is_valid($param, [
            'phone' => 'required|phone_number|exact_len,11',
            'password' => 'required|min_len,6|max_len,18'
        ]);
        if ($valid !== true) {
            return jsonResponse([$param], -1, $valid[0]);
        }
        $model = new UserModel();
        $data = $model->getLoginInfoByPhone($param['phone']);
        if (empty($data)){
            return jsonResponse(['url'=>'/register','alert'=>'confirm','type'=>'push'], 302, '当前手机号还没有注册，先去注册？');
        }
        if ($data['password'] != $model->getPassword($param['password'],$data['salt'])){
            return jsonResponse([], -1, '密码错误');
        }
        if ($data['status'] != 1){
            return jsonResponse([], -1, '当前账号已被禁用');
        }
        LoginModel::login((int)$data['id'], (int)$data['group_id'], $data['nick'], (new DbJeemuResModel())->getUrlById((int)$data['headimg_res_id']), isWechat());
        return jsonResponse();
    }

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
        $model = new UserModel();

        if ($model->hasByPhone($param['phone'])){
            return jsonResponse(['url'=>'/login','alert'=>'confirm','type'=>'push'],302,'当前手机号已经注册，直接去登录？');
        }

        $smsModel = new DbJeemuSmsModel();
        $smsData = $smsModel->getSmsByPhone($param['phone']);
        if (empty($smsData)){
            return jsonResponse([],-1,'短信验证码不正确');
        }
        if ($param['code'] != $smsData['code']){
            return jsonResponse([],-1,'短信验证码不正确');
        }
        if ($param['phone'] != $smsData['phone']){
            return jsonResponse([],-1,'短信验证码不正确');
        }
        $smsModel->updateStatusById((int)$smsData['id']);


        if ($uid = $model->setByPhone($param['phone'], $param['password'])) {
            $userInfo = $model->getUserLoginInfoById($uid);
            if (!empty($userInfo)) {
                LoginModel::login($uid, $userInfo['group_id'], $userInfo['nick'], $userInfo['head_img'], isWechat());
                return jsonResponse();
            }else{
                return jsonResponse([$model->getError(),$model->getLog()], 0, '服务器出现问题!请重试....');
            }
        } else {
            return jsonResponse([], 0, '服务器出现问题!请重试....');
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
            return jsonResponse(['type' => 'go','alert'=>'alert', 'url' => (new Jeemu\Wechat\UserInfo(conf('wechat.appid'), conf('wechat.appsecret')))->getBaseUrl(Jeemu\Dispatcher::getInstance()->getRequest()->host . '/api/wechat/code' . $path)],1,'前去登录?');
        }
        return jsonResponse(['type' => 'push','alert'=>'alert', 'url' => '/login'.$path],1,'前去登录?');
    }


    public function loginUrlAction(){
        if ($this->uid){
            return jsonResponse([]);
        }
        return jsonResponse([],302,'请登录');
    }


    public function userInfoAction(){
        if ($this->uid){
            return jsonResponse(['nick'=>$this->getUserInfo('nick'),'headImg'=>$this->getUserInfo('headImg')]);
        }
        return jsonResponse([],302,'请登录');
    }
}