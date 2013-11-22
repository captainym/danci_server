<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-2
 * Time: 下午7:41
 * To change this template use File | Settings | File Templates.
 */ 

//$arr = array("word_stem_rel"=>'WordStemRel', 'bing_img'=>'BingImg',
//    'bing_sentence'=>'BingSentence', 'word_stem_rel'=>'WordStemRel','word_tips_img'=>'WordTipsTmg', 'word_tips_txt'=>'WordTipsTxt');
$arr = array("user"=>'User', 'user_payment'=>'UserPayment');
$template = <<<END
<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-10-27
 * Time: 下午8:26
 * To change this template use File | Settings | File Templates.
 */
class %s extends CActiveRecord
{
    public static function model(\$className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '%s';
    }
}
END;

foreach($arr as $table_name=>$class_name)  {
    file_put_contents($class_name. ".php", sprintf($template, $class_name, $table_name));
}

