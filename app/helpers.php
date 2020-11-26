<?php

/**
 * Created by parse.cn
 * Author: Alex (dinghua@me.com)
 * Date: 2019-04-19
 * Time: 14:45
 * All rights reserved.
 */

if (!function_exists('image_url')) {
    function image_url($path)
    {
        return url($path);
    }
}

if (!function_exists('human_time')) {
    function human_time($time)
    {
        $time      = strtotime($time);
        $diff_time = time() - $time;
        if ($diff_time < 60) {
            $str = '刚刚';
        } elseif ($diff_time < 60 * 60) {
            $min = floor($diff_time / 60);
            $str = $min . '分钟前';
        } elseif ($diff_time < 60 * 60 * 24) {
            $h   = floor($diff_time / (60 * 60));
            $str = $h . '小时前';
        } elseif ($diff_time < 60 * 60 * 24 * 3) {
            $d = floor($diff_time / (60 * 60 * 24));
            if ($d == 1) {
                $str = '昨天';
            } else {
                $str = '前天';
            }
        } else {
            if (date('Y') == date('Y', $time)) {
                $str = date("m月d日", $time);
            } else {
                $str = date("Y年m月d日", $time);
            }
        }

        return $str;
    }
}


/**
 * 根据起点坐标和终点坐标测距离
 *
 * @param  [array]   $from    [起点坐标(经纬度),例如:array(118.012951,36.810024)]
 * @param  [array]   $to    [终点坐标(经纬度)]
 * @param  [bool]    $km        是否以公里为单位 false:米 true:公里(千米)
 * @param  [int]     $decimal   精度 保留小数位数
 *
 * @return [string]  距离数值
 */
if (!function_exists('get_distance')) {
    function get_distance($from, $to, $km = false, $decimal = 2)
    {
        sort($from);
        sort($to);
        $EARTH_RADIUS = 6370.996; // 地球半径系数

        $distance = $EARTH_RADIUS * 2 * asin(sqrt(pow(sin(($from[ 0 ] * pi() / 180 - $to[ 0 ] * pi() / 180) / 2), 2) + cos($from[ 0 ] * pi() / 180) * cos($to[ 0 ] * pi() / 180) * pow(sin(($from[ 1 ] * pi() / 180 - $to[ 1 ] * pi() / 180) / 2), 2))) * 1000;

        if ($km) {
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }
}
