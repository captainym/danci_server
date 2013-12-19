<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-16
 * Time: 下午2:59
 * To change this template use File | Settings | File Templates.
 */ 
class TestCommand extends Command {
    public function run($args)
    {
        error_reporting(E_ALL & ~E_NOTICE);
        ini_set('display_errors', true);

        $rs = $this->tips->adopt_img('overfish','a4756dc9f41767ed60d0a75e084073f3');
        var_dump($rs);
    }
}
