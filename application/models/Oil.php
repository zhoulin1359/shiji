<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/8
 * Time: 17:55
 */
class OilModel extends Jeemu\Db\Connect\Mysql
{
    public function getList(): array
    {
        $data = $this->select(['id', 'name', 'content', 'author_id', 'head_img_res_id', 'publish_time'], ['status[=]' => 1]);
        if ($data) {
            $authorArr = [];
            $resArr = [];
            foreach ($data as $value) {
                $authorArr[] = $value['author_id'];
                $resArr[] = $value['head_img_res_id'];
            }
            $resData = (new ResModel())->getIdAndUrlByIds($resArr);
            // $resArr = DataModel::handleArray($resData, 'id');
            $authorData = (new AuthorModel())->getNameByIds($authorArr);
            $authorArr = DataModel::handleArray($authorData, 'id');
            foreach ($data as $key => $value) {
                $data[$key]['publish_time'] = date(conf('client_style.date'),$value['publish_time']);
                $data[$key]['content'] = subStrByStart($value['content'],conf('client_style.content_len'));
                $data[$key]['author'] = isset($authorArr[$value['author_id']]) ? $authorArr[$value['author_id']]['name'] : '';
                $data[$key]['head_img_url'] = isset($resData[$value['head_img_res_id']]) ? $resData[$value['head_img_res_id']] : '';
            }
            return $data;
        }
        return [];
    }
}