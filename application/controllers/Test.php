<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 21:41
 */
class TestController extends BaseController
{
    private $appid = 'wxfa31e52b4e31f982';
    private $appsecret = 'f1ab5f7267fc73eb7c0ff710efef2759';

    public function indexAction(){
        $code = getRequestQuery('code');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code';
        $result = curlHttpsGet($url);
       // var_dump($result);
        $result = json_decode($result);
        if (isset($result->access_token)){
            $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$result->access_token.'&openid='.$this->appid.'&lang=zh_CN';
            $result = curlHttpsGet($url);
            //var_dump($result);
            $result = json_decode($result);
            if (isset($result->openid)){
                $resModel = new DbJeemuResModel();
                $resId = $resModel->setByUrl($result->headimgurl);
                $userModel = new DbJeemuUserModel();
                if ($uid = $userModel->setByWechat($result->openid,$result->nickname,$result->sex,$resId)){
                    (new DbJeemuUserAddressModel())->set($uid,$result->country,$result->province,$result->city);
                    var_dump((new DbJeemuUserAddressModel())->getLog());
                    var_dump((new DbJeemuUserAddressModel())->getError());
                    jsonResponse([$uid]);
                }
            }
        }
    }
}