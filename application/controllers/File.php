<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2017/12/28
 * Time: 15:31
 */
class FileController extends BaseController
{
    public function uploadImgAction(){
        $upload = \Jeemu\Dispatcher::getInstance()->getUpload();
        $result = $upload->moveTo();
        if ($result){
            return jsonResponse(['url'=>'http://img.dwstatic.com/lol/1712/378211993215/1514257242940.jpg']);
            return response()->sendHtml(json_encode(['result'=>0,'message'=>'','data'=>['url'=>$result]]));
        }
        return response()->sendHtml(json_encode(['result'=>0,'message'=>'','data'=>['url'=>$result]]));
    }
}