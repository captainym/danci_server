<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-12-13
 * Time: 涓嬪崍8:48
 * To change this template use File | Settings | File Templates.
 */ 
class UserWords extends CActiveRecord
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'user_words';
    }
}
