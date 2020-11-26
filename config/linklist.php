<?php

/*
 * This file is part of house315
 *
 * (c) Alex <alex@parse.cn>
 *
 * 列出微信小程序内页面的链接和参数说明
 */

return [
    [
        '首页', '/pages/house/home/index'
    ],
    [
        '房友圈', '/pages/article/index'
    ],
    [
        '答疑', '/pages/question/index'
    ],
    [
        '我的', '/pages/account/index'
    ],
    [
        '所有楼盘', '/pages/house/list/index'
    ],
    [
        '楼盘介绍页', '/pages/house/show/index?id=<id>', 'id: 楼盘编号'
    ],
    [
        '楼盘详情页', '/pages/house/detail/index?id=<id>', 'id: 楼盘编号'
    ],
    [
        '楼盘图片页', '/pages/house/gallery/index?id=<id>', 'id: 楼盘编号'
    ],
    [
        '楼盘户型页', '/pages/house/housetype/index?id=<id>', 'id: 楼盘编号'
    ],
    [
        '楼盘周边页', '/pages/house/around/index?id=<id>', 'id: 楼盘编号'
    ],
];