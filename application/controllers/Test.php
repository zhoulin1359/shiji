<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/20
 * Time: 21:41
 */
class TestController extends BaseController
{
    private $appid = 'wxfa31e52b4e31f982';
    private $appsecret = 'f1ab5f7267fc73eb7c0ff710efef2759';

    public function indexAction(){
        return jsonResponse([(new CommentModel())->addPraiseById(getRequestQuery('id'))]);
    }
}