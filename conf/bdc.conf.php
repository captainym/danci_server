<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-11
 * Time: 下午6:19
 * To change this template use File | Settings | File Templates.
 */

//debug
if(YII_DEBUG) {
    return array(
        //默认的单词上限
        'DEFAULT_WORD_LIMIT' => 1500,
        'BAIDU_AK' => 'T9QZjyRGOr3SOkuhufGBAO5S',
        'BAIDU_SK' => 'wzK2rcHuBHOFvsldoqN8u3aqXjhM2FBd',
        'BUCKET' => 'baiduwords',
        'CLOUD_BASE_PATH' => '/words',
        'PARTITIONS' => 20
    );
}

//online
return array(
    'DEFAULT_WORD_LIMIT' => 1500,
    'BAIDU_AK' => 'T9QZjyRGOr3SOkuhufGBAO5S',
    'BAIDU_SK' => 'wzK2rcHuBHOFvsldoqN8u3aqXjhM2FBd',
    'BUCKET' => 'baiduwords',
    'CLOUD_BASE_PATH' => '/words',
    'PARTITIONS' => 20
);