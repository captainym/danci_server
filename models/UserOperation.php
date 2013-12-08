<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-12-1
 * Time: 下午4:25
 * To change this template use File | Settings | File Templates.
 */ 
class UserOperation extends CActiveRecord
{
    public static function model($className = __CLASS__) {
        return parent::model();
    }

    public function tableName() {
        return 'user_operation';
    }
}