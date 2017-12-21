<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 0:08
 */
class UserController extends BaseController
{
    public function registerAction(){
        $param['phone'] = \Jeemu\Dispatcher::getInstance()->getRequest()->getPost('phone');
        $param['password'] = \Jeemu\Dispatcher::getInstance()->getRequest()->getPost('password');
        $param['code'] = \Jeemu\Dispatcher::getInstance()->getRequest()->getPost('code');
        $valid = GUMP::is_valid($param,[
            'phone'=>'required|phone_number|exact_len,11',
            'password'=>'required|max_len,6|min_len,18',
            'code'=>'required|exact_len,6'
        ]);
        if ($valid !== true){
            jsonResponse([$param],-1,$valid[0]);
        }
        $model = new DbJeemuUserModel();
        if ($model -> setByPhone($param['phone'],$param['password'])){
            jsonResponse();
        }else{
            jsonResponse([],-1,'服务器出现问题!请重试....');
        }
    }


    public function isLoginAction(){
        if ($this->uid){
            return jsonResponse([true]);
        }
        return jsonResponse([false]);
    }

    public function getLoginUrlAction(){
        $isWechat = getRequestQuery('isWechat');
        if ($isWechat === 'true'){
            return jsonResponse(['type'=>'go','url'=>(new Jeemu\Wechat\UserInfo(conf('wechat.appid'),conf('wechat.appsecret')))->getBaseUrl(Jeemu\Dispatcher::getInstance()->getRequest()->host.'/api/wechat/code')]);
        }
        return jsonResponse(['type'=>'push','url'=>'/login']);
    }
}