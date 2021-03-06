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
        '所有房源', '/pages/house/list/index'
    ],
    [
        '房源介绍页', '/pages/house/show/index?id=<id>', 'id: 房源编号'
    ],
    [
        '房源详情页', '/pages/house/detail/index?id=<id>', 'id: 房源编号'
    ],
    [
        '房源图片页', '/pages/house/gallery/index?id=<id>', 'id: 房源编号'
    ],
    [
        '房源户型页', '/pages/house/housetype/index?id=<id>', 'id: 房源编号'
    ],
    [
        '房源周边页', '/pages/house/around/index?id=<id>', 'id: 房源编号'
    ],
];
