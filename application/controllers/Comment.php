<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/17
 * Time: 23:33
 */
class CommentController extends BaseController
{
    public function oilAction()
    {
        $param['oil_id'] = getRequestQuery('oil_id');
        $valid = GUMP::is_valid($param, ['oil_id' => 'required|integer']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        $result = (new CommentModel())->getByOilId($param['oil_id'],getRequestQuery('order',0),getRequestQuery('page_num',0));
        $cidArr = DataModel::handleArrayGetPk($result, 'id');
        $userPraiseData = [];
        if ($this->uid){
            $userPraiseData = (new CommentPraiseModel())->getIdByCidsAndUid($cidArr,$this->uid);
        }
        foreach ($result as $key => $value) {
            if (isset($userPraiseData[$value['id']])) {
                $result[$key]['user_praise'] = ['is_praise' => true, 'id' => $userPraiseData[$value['id']]];
            } else {
                $result[$key]['user_praise'] = ['is_praise' => false, 'id' => 0];
            }
        }
        return jsonResponse($result);
    }
}