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
        return jsonResponse((new CommentModel())->getByOilId($param['oil_id']));
    }
}