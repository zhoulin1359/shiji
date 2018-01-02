<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/28
 * Time: 15:31
 */
class FileController extends BaseController
{
    public function uploadImgAction()
    {
        $upload = \Jeemu\Dispatcher::getInstance()->getUpload();
        if (!$upload->check(['extension' => ['png', 'jpg', 'jpeg', 'gif'], 'max_size' => 1024 * 1024 * 10, 'mime_type' => ['image/png', 'image/jpeg', 'image/jpg', 'image/gif']])) {
            return jsonResponse([], -1, $upload->getError());
        }
        $fileKey = $upload->getKey();
        $resModel = new DbJeemuResModel();
        $imgData = $resModel->getIdAndUrlByKey($fileKey);
        if (!empty($imgData)) {
            return jsonResponse(['url' => $imgData['url'], 'id' => $imgData['id']]);
        }
        $result = $upload->moveTo();
        if ($result) {
            if ($id = $resModel->set($upload->getClientFilename(), $result, $upload->getClientMediaType(), $upload->getSize(), $upload->getKey(), $this->uid)) {
                return jsonResponse(['url' => $result, 'id' => $id]);
            } else {
               // var_dump($resModel->getLog());
                //var_dump($resModel->getError());
                return jsonResponse([], 0, response()::RESPONSE_INFO_100);
            }
            //return response()->sendHtml(json_encode(['result'=>0,'message'=>'','data'=>['url'=>$result]]));
        }
        return jsonResponse([], 0, response()::RESPONSE_INFO_100);
    }
}