<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/8
 * Time: 17:54
 */
class OilController extends BaseController
{
    public function listAction()
    {
        jsonResponse((new OilModel())->getList());
    }


    public function detailAction()
    {
        $param['id'] = Jeemu\Dispatcher::getInstance()->getRequest()->getQuery('id');
        $valid = GUMP::is_valid($param, ['id' => 'required|integer']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        $result['score'] = (new OilScoreModel())->getScoreByOilId($param['id']);
        if ($this->uid){
            $result['user_score'] = (new OilScoreLogModel())->getScoreByOliIdAndUid($param['id'], $this->uid);
        }else{
            $result['user_score'] = [
                'score'=>0,
                'exist'=>false
            ];
        }

        return jsonResponse($result);
    }
}