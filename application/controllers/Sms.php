<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/19
 * Time: 17:45
 */
class SmsController extends BaseController
{
    public function sendAction(){
        $param['phone'] = Jeemu\Dispatcher::getInstance()->getRequest()->getQuery('phone');

        $valid = GUMP::is_valid($param,['phone'=>'required|phone_number|max_len,11|min_len,11']);
        if ($valid !== true){
            return jsonResponse([],-1,$valid[0]);
        }
        $model = new DbJeemuSmsModel();
        if ($model->set($param['phone'])){
            return jsonResponse();
        }else{
            return jsonResponse([],0,$model->getSmsError());
        }
    }
}