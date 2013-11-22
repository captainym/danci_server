<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-2-2
 * Time: 下午3:12
 * To change this template use File | Settings | File Templates.
 */ 
class Bucket extends CActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'bucket';
    }
}
