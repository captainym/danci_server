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
        $headers = getallheaders();
        $this->logger->info("get all headers", $headers);
        $this->logger->info('get raw body', http_get_request_body());
        $this->logger->info('start to register user', $_POST);
        $rs = $this->user->add_user($_POST);
        $this->logger->info('end to register user', $rs);

        echo json_encode($rs);
    }

    public function actionAuth() {
        $this->logger->info('start to auto user', $_POST);
        $rs = $this->user->auth($_POST);
        $this->logger->info('end to auth user', $rs);
        echo json_encode($rs);
    }

    public function actionOp() {
        $rs = $this->action->add_op($_POST);
        echo json_encode($rs);
    }
}
