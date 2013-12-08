<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-20
 * Time: 下午4:35
 * To change this template use File | Settings | File Templates.
 */ 
class CloudController extends Controller {
    public function actionFile() {
        $file_path = $_GET['file_path'];
        $file_type = $_GET['file_type'];

        $bucket = G::$conf['bdc']['BUCKET'];
        $baidu_ak = G::$conf['bdc']['BAIDU_AK'];
        $baidu_sk = G::$conf['bdc']['BAIDU_SK'];
        $params = array('vender'=>'baidu','bucket'=>$bucket, 'file_path'=>$file_path,
            'ak'=>$baidu_ak, 'sk'=>$baidu_sk, 'file_type'=>$file_type);
        $data = false;
        try {
            $data = $this->userFile->get_file($file_path, $params);
        } catch (Exception $e) {
            $this->logger->error("error to get file, ", $params);
            $this->error404();
        }

        if(!$data) {
            $this->error404();
        }

        if($file_type == 'mp3') {
            $header_type = 'audio/mpeg';
        } else {
            $header_type = 'image/jpeg';
        }
        header("Cache-Control: max-age=315360000");
        header("Expires: Wed, 01 Feb 2023 06:37:24 GMT");

        header("Content-Type: $header_type");
        header("Content-Length: " .(string)strlen($data));

        echo $data;
    }
    public function error404() {
        header("HTTP/1.0 404 Not Found") ;
        exit;
    }

    public function actionMp3() {

    }
}
