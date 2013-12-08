<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-24
 * Time: 下午3:01
 * To change this template use File | Settings | File Templates.
 */ 
class YxjCommand extends Command {
    public function run($args)
    {
        error_reporting(E_ALL & ~E_NOTICE);
        ini_set('display_errors', true);

        $data = array(
            'word'=>'herd', 'studyNo'=>'9999', 'feedback_type'=>'11',
            'create_time'=>strval(time()) . ".1239191"
        );
        $rs = $this->action->add_feedback($data);
        var_dump($rs);
    }
}
