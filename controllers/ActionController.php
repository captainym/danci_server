<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-10-27
 * Time: 下午8:44
 * To change this template use File | Settings | File Templates.
 */ 
class ActionController extends Controller {
    /**
     * 采纳助记的接口，img和txt的通过type来区分
     */
    public function  actionAdopt() {

    }

    public function actionRegister() {
        $rs = $this->user->add_user($_POST);
        echo json_encode($rs);
    }

    public function actionAuth() {

    }

    public function actionOp() {

    }
}
