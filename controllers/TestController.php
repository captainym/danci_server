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
}
