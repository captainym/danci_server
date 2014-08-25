<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-12-15
 * Time: 下午2:25
 * To change this template use File | Settings | File Templates.
 */ 
class AuthController extends Controller {
    public function actionIndex() {
		$this->logger->info("get auth info", $_GET);
		$ret = $this->weChat->checkSignature();
		if($ret) {
			echo $_GET['echostr'];
			$this->logger->info("echo str:" . $_GET['echostr']);
		}
    }
}
