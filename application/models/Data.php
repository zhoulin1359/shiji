<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/8
 * Time: 18:14
 */
class DataModel
{
    static public function handleArray(array $arr, string $pk, string $str = ''): array
    {
        $result = [];
        foreach ($arr as $value) {
            $result[$value[$pk]] = $str ? (isset($value[$str]) ? $value[$str] : $value) : $value;
        }
        return $result;
    }


    static public function handleArrayGetPk(array $arr, string $pk): array
    {
        $result = [];
        foreach ($arr as $value) {
            $result[] = isset($value[$pk]) ? $value[$pk] : '';
        }
        return $result;
    }


    static public function handleTimeGetDate(int $time)
    {
        $nowTime = time();
         //今天之内|五天以内|本月|本年|其他
        if (date('Ymd',$nowTime) === date('Ymd',$time)){
            return date('H:i',$time);
        }
        if (86400 * 5 > $nowTime - $time){
            return date('m-d H:i',$time);
        }
        if (date('Ym',$nowTime) === date('Ym',$time)){
            return date('m-d',$time);
        }
        if (date('Y',$nowTime) === date('Y',$time)){
            return date('m-d',$time);
        }
        return date('Y-m-d',$time);
    }
}