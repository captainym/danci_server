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
        'DEFAULT_WORD_LIMIT' => 1000,
        'BAIDU_AK' => 'A140a6cf0c4e29e9503a8126db46ca12',
        'BAIDU_SK' => 'D53472f377cf50a0af4d9c457ed6f974',
        'BUCKET' => 'baiduwords',
        'CLOUD_BASE_PATH' => '/words',
        'PARTITIONS' => 10,
        'ADOPT_RANK_INC' => 5,
        'IMAGE_TIP_PARTITION' => 10
    );
}

//online
return array(
    'DEFAULT_WORD_LIMIT' => 1000,
    'BAIDU_AK' => 'A140a6cf0c4e29e9503a8126db46ca12',
    'BAIDU_SK' => 'D53472f377cf50a0af4d9c457ed6f974',
    'BUCKET' => 'baiduwords',
    'CLOUD_BASE_PATH' => '/words',
    'PARTITIONS' => 10,
    'ADOPT_RANK_INC' => 5,
    'IMAGE_TIP_PARTITION' => 10
);
