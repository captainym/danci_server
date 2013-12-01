<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-10-27
 * Time: 下午8:44
 * To change this template use File | Settings | File Templates.
 */ 
class ActionController extends Controller {
    public function actionRegister() {
        $this->logger->info('start to register user', $_POST);
        $rs = $this->user->add_user($_POST);
        $this->logger->info('end to register user', $rs);

        echo json_encode($rs);
    }

    public function actionAuth() {
        $rs = $this->user->auth($_POST);
        echo json_encode($rs);
    }

    public function actionOp() {
        $rs = $this->action->add_op($_POST);
        echo json_encode($rs);
    }
}
