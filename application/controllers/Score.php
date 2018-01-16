<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/16
 * Time: 10:00
 */
class ScoreController extends BaseController
{
    // public function
    public function setScoreAction()
    {
        $param['oil_id'] = getRequestBody('oil_id');
        $param['score'] = getRequestBody('score');
        $valid = GUMP::is_valid($param, ['oil_id' => 'required|integer', 'score' => 'required|integer|max_numeric,5|min_numeric,1']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        $model = new OilScoreLogModel();
        if ($model->hasByOilIdAndUid($param['oil_id'], $this->uid)) {
            return jsonResponse([], -1, '您已经评过分了');
        }
        $model->set($param['oil_id'], $this->uid, $param['score']);
        if ((new OilScoreModel())->set($param['oil_id'], $param['score'])) {
            return jsonResponse();
        }
        return jsonResponse([], 0, response()::RESPONSE_INFO_100);
    }


    public function getScoreAction(){
        $param['oil_id'] = getRequestQuery('oil_id');
        $valid = GUMP::is_valid($param, ['oil_id' => 'required|integer']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        return jsonResponse([(new OilScoreModel())->getScoreByOilId($param['oil_id'])]);
    }
}