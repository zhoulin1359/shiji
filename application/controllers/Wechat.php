<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/20
 * Time: 16:28
 */
class WechatController extends BaseController
{
    public function indexAction()
    {
        var_dump((new Jeemu\Wechat\AccessToken(conf('wechat.appid'), conf('wechat.appsecret')))->get());
    }

    public function jssdkAction()
    {
        //jsonResponse([$this->getRequest()->getRequestUri()]);
        //jsonResponse($_SERVER);
        $param['url'] = getRequestQuery('url');
        $valid = GUMP::is_valid($param, [
            'url' => 'required|valid_url'
        ]);
        if ($valid !== true) {
            return jsonResponse([$param], -1, $valid[0]);
        }
        $jssdk = new Jeemu\Wechat\JsSdk(conf('wechat.appid'), conf('wechat.appsecret'));
        $result = $jssdk->get($param['url']);
        if (empty($result)) {
            return jsonResponse([], 0, '服务器出现问题!请重试...');
        }
        jsonResponse($result);
    }


    public function redirectAction()
    {
        return jsonResponse([(new Jeemu\Wechat\UserInfo(conf('wechat.appid'), conf('wechat.appsecret')))->getBaseUrl(Jeemu\Dispatcher::getInstance()->getRequest()->host . '/home/wechat/code')]);
    }

    public function codeAction()
    {
        $code = getRequestQuery('code');
        $valid = GUMP::is_valid(['code' => $code], [
            'code' => 'required'
        ]);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        $userInfoObj = (new Jeemu\Wechat\UserInfo(conf('wechat.appid'), conf('wechat.appsecret')));
        $accessToken = $userInfoObj->getAccessToken($code);
        if (empty($accessToken)) {
            return jsonResponse([], 0, $userInfoObj->getError());
        }
        $userInfo = $userInfoObj->getUserInfo($accessToken['access_token'], $accessToken['openid']);
        if (empty($userInfo)) {
            return jsonResponse([], 0, $userInfoObj->getError());
        }

        $resModel = new DbJeemuResModel();
        $resId = $resModel->setByUrl($userInfo['headimgurl']);
        $userModel = new DbJeemuUserModel();
        if ($uid = $userModel->setByWechat($userInfo['openid'], $userInfo['nickname'], $userInfo['sex'], $resId)) {
            (new DbJeemuUserAddressModel())->set($uid, $userInfo['country'], $userInfo['province'], $userInfo['city']);
            $this->login($uid, 2, $userInfo['nickname'], $userInfo['headimgurl'], true);
            return response()->sendHtml('<script>window.location.href=\'' . (getRequestQuery('path') ? conf('client_host') . getRequestQuery('path') : conf('client_host')) . '\'</script>');
        } else {
            return jsonResponse([], 0, \Jeemu\Response::RESPONSE_INFO_100);
        }
    }


    public function sendTemplateMsgAction()
    {
        $accessToken = (new Jeemu\Wechat\AccessToken(conf('wechat.appid'), conf('wechat.appsecret')))->get();
        $templateId = 'VSnwv27VM53YpJVQZ-n1cbMaqych_E82f6s2m926_zk';
        $openId = 'o2v4SwuiQtqk00qEaPTWg-jjQ0MI';
        $msg = ['msg' => ['value' => '我是小小']];
        $result = (new Jeemu\Wechat\Template())->sendTemplateMsg($templateId, $accessToken, $openId, $msg,$url='https://www.ss.com');
        jsonResponse([serialize($result)]);
        if (!empty($result)) {
            (new WechatTemplateModel())->set($result['msgid'], $templateId, $openId, json_encode($msg), $this->uid);
        }
        jsonResponse($result);
    }
}