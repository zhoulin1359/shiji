<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/20
 * Time: 16:28
 */
class WechatController extends BaseController
{
    public function indexAction(){
        var_dump((new Jeemu\Wechat\AccessToken(conf('wechat.appid'),conf('wechat.appsecret')))->get());
    }

    public function jssdkAction(){
        //jsonResponse([$this->getRequest()->getRequestUri()]);
        //jsonResponse($_SERVER);
        $param['url'] = getRequestQuery('url');
        $valid = GUMP::is_valid($param,[
            'url'=>'required|valid_url'
        ]);
        if ($valid !== true){
            return jsonResponse([$param],-1,$valid[0]);
        }
        $jssdk = new Jeemu\Wechat\JsSdk(conf('wechat.appid'),conf('wechat.appsecret'));
        $result = $jssdk->get($param['url']);
        if (empty($result)){
            return jsonResponse([],0,'服务器出现问题!请重试...');
        }
        jsonResponse($result);
    }
}