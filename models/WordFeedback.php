<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-12-8
 * Time: 下午4:40
 * To change this template use File | Settings | File Templates.
 */
class WordFeedback extends CActiveRecord
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'user_word_feedback';
    }
}