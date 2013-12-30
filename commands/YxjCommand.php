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

        $sql = 'select username, passwd from user';
        $rs = $this->user->executeQuery($sql,array(), false);
        foreach ($rs as $item) {
            print_r($item);
            $user_name = $this->mCrypt->decrypt($item['username']);
            $passwd = $this->mCrypt->decrypt($item['passwd']);

            echo "$user_name:$passwd\n";
        }
	var_dump($this->mCrypt->encrypt('abc123'));

    }
}
