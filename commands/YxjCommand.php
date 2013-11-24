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
            'username'=>'yuanxijie1', 'email'=>'yuanxijie@gmail.com',
            'imei' =>'123123123123', 'sid'=> 'sid123123', 'passwd'=>'123123'
        );

        $rs = $this->mCrypt->encrypt(json_encode($data));
        echo $rs;

        $rs = $this->mCrypt->decrypt($rs);
        echo $rs;
        var_dump(json_decode($rs, true));
        exit;


        $rs = $this->user->add_user($data);
        var_dump($rs);
        $rs = $this->user->auth(array('username'=>'yuanxijie', 'passwd'=>'123123'));
        var_dump($rs);
    }
}
