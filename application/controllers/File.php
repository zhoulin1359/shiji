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

    }
}