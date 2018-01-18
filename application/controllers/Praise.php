<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/18
 * Time: 14:41
 */
class PraiseController extends BaseController
{
    /**
     * 评论点赞
     * @return bool
     */
    public function praiseCommentAction()
    {
        $param['c_id'] = getRequestQuery('c_id');
        $param['p_id'] = getRequestQuery('p_id');
        $valid = GUMP::is_valid($param, ['c_id' => 'required|integer', 'p_id' => 'required|integer']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        $result = (new CommentPraiseModel())->set($param['c_id'], $this->uid, $param['p_id']);
        if ($result['status'] && $result['add']) {
            (new CommentModel())->addPraiseById($param['c_id']);
        }
        return jsonResponse($result);
    }


    public function cancelCommentAction()
    {
        $param['p_id'] = getRequestQuery('p_id');
        $valid = GUMP::is_valid($param, ['p_id' => 'required|integer']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        $result = (new CommentPraiseModel())->cancel($param['p_id'],$this->uid);
        if ($result['status'] && $result['dec']){
            (new CommentModel())->decPraiseById($result['c_id']);
        }
        return jsonResponse($result);
    }
}