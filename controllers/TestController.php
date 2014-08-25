<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-24
 * Time: 下午10:11
 * To change this template use File | Settings | File Templates.
 */ 
class TestController extends Controller {
    public function actionWords() {
        $rs = $this->word->get_all_word();
        //foreach ($rs as &$w) {
        //    $w['stem'] = ltrim($w['stem'], ' 词根');
        //}

        echo json_encode($rs);
    }
    public function actionRedirect() {
        $http_response_header = array();
        foreach($_SERVER as $key=>$val) {
            if(strpos(strtolower($key), 'http_') !== false) {
                $http_response_header[$key] = $val;
            }
        }
        $this->logger->info('get all headers', $http_response_header);
	unset($_SERVER['HTTP_REFERER']);
	unset($_SERVER['HTTP_COOKIE']);
   //     $this->redirect("http://s.click.taobao.com/t?e=m%3D2%26s%3D2yy5%2Bh1%2FaD4cQipKwQzePCperVdZeJviEViQ0P1Vf2kguMN8XjClAkduMtaU0zo2gd5GRF2xIprLpik5Qhm%2F7AkrRYEDUEiSySLJV%2BQyE%2FsqaPWiCxEbbudn1BbglxZYxUhy8exlzcq9AmARIwX9K%2BnbtOD3UdznPV1H2z0iQv9NkKVMHClW0QbMqOpFMIvnvjQXzzpXdTHGJe8N%2FwNpGw%3D%3D");
     $this->redirect("/bdc/test/redirect1");
    }
    public function actionRedirect1() {
        $http_response_header = array();
        foreach($_SERVER as $key=>$val) {
            if(strpos(strtolower($key), 'http_') !== false) {
                $http_response_header[$key] = $val;
            }
        }
        $this->logger->info('get second headers', $http_response_header);
   }
}
