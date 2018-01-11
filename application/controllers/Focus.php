<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/11
 * Time: 17:30
 */
class FocusController extends BaseController
{
    public function isFocusAction() {
        $param['target_id'] = getRequestQuery('target_id');
        $param['type'] = getRequestQuery('type');
        $valid = GUMP::is_valid($param,['target_id'=>'required|integer','type'=>'required|alpha_numeric']);
        if ($valid !== true){
            return jsonResponse([],-1,$valid[0]);
        }
        $model = new  FocusTargetModel();
        if ($model->isFocusByTypeAndTargetId($param['target_id'],$param['type'],$this->uid)){
            return jsonResponse([true]);
        }else{
            return jsonResponse([false]);
        }
    }
}