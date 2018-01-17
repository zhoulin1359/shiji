<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/17
 * Time: 17:09
 */
class OilImagesModel extends \Jeemu\Db\Connect\Mysql
{
    public function getByOilId(int $oilId): array
    {
        $data = $this->select(['swiper_res_id', 'previewer_res_id', 'title', 'content'], ['oil_id[=]' => $oilId, 'status[=]' => 1, 'ORDER' => ['order' => 'DESC']]);
        if ($data) {
            $resIdArr = [];
            foreach ($data as $value){
                $resIdArr[] = $value['swiper_res_id'];
                $resIdArr[] = $value['previewer_res_id'];
            }
            $resIdArr = array_unique($resIdArr);
            $imgData = (new ResModel())->getIdAndUrlByIds($resIdArr);
            foreach ($data as $key => $value){
                $swiper_url = isset($imgData[$value['swiper_res_id']])?$imgData[$value['swiper_res_id']]:'';
                $previewer_url = isset($imgData[$value['previewer_res_id']])?$imgData[$value['previewer_res_id']]:'';
                if (empty($swiper_url) || empty($previewer_url)){
                    unset($data[$key]);
                    break;
                }
                $data[$key]['content'] = nl2br($value['content']);
                $data[$key]['swiper_url'] = $swiper_url;
                $data[$key]['previewer_url'] = $previewer_url;
            }
            return $data;
        }
        return [];
    }
}