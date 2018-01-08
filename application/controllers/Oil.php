<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/8
 * Time: 17:54
 */
class OilController extends BaseController
{
    public function listAction(){
        jsonResponse((new OilModel())->getList());
    }
}