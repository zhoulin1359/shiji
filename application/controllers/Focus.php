<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/11
 * Time: 17:30
 */
class FocusController extends BaseController
{
    public function isFocusAction()
    {
        $param['target_id'] = getRequestQuery('target_id');
        $param['type'] = getRequestQuery('type');
        $valid = GUMP::is_valid($param, ['target_id' => 'required|integer', 'type' => 'required|alpha_numeric']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        $model = new  FocusTargetModel();
        if ($model->isFocusByTypeAndTargetId($param['target_id'], $param['type'], $this->uid)) {
            return jsonResponse([true]);
        } else {
            return jsonResponse([false]);
        }
    }

    public function getCategoryListAction()
    {
        return jsonResponse((new FocusModel())->getListByUid($this->uid));
    }


    public function addCategoryAction()
    {
        $param['name'] = getRequestBody('name');
        $valid = GUMP::is_valid($param, ['name' => 'required|max_len,20']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        if ($id = (new FocusModel())->set($param['name'], $this->uid)) {
            return jsonResponse(['id' => $id, 'name' => $param['name']]);
        }
        return jsonResponse([], 0, response()::RESPONSE_INFO_100);
    }

    public function focusAction()
    {
        $param['target_id'] = getRequestQuery('target_id',0);
        $param['type'] = getRequestQuery('type');
        $param['focus_id'] = getRequestQuery('focus_id',0);
        $valid = GUMP::is_valid($param, ['target_id' => 'required|integer', 'type' => 'required|alpha_numeric', 'focus_id' => 'required|integer']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }

        $model = new  FocusTargetModel();
        if ($model->focus($param['target_id'], $param['type'], $param['focus_id'], $this->uid)) {
            return jsonResponse([true]);
        }
        return jsonResponse([false]);
    }

    public function cancelAction()
    {
        $param['target_id'] = getRequestQuery('target_id');
        $param['type'] = getRequestQuery('type');
        $valid = GUMP::is_valid($param, ['target_id' => 'required|integer', 'type' => 'required|alpha_numeric']);
        if ($valid !== true) {
            return jsonResponse([], -1, $valid[0]);
        }
        $model = new  FocusTargetModel();
        if ($model->cancel($param['target_id'], $param['type'], $this->uid)) {
            return jsonResponse([true]);
        }
        return jsonResponse([false]);
    }
}