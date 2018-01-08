<?php

/**
 * Created by PhpStorm.
 * User: JeemuZhou
 * Date: 2018/1/8
 * Time: 18:14
 */
class DataModel
{
    static public function handleArray(array $arr, string $pk): array
    {
        $result = [];
        foreach ($arr as $value) {
            $result[$value[$pk]] = $value;
        }
        return $result;
    }
}