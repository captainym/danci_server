<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-10-27
 * Time: 下午8:27
 * To change this template use File | Settings | File Templates.
 */ 
class WordStem extends CActiveRecord
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'word_stem';
    }
}