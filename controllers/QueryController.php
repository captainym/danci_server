<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-10-27
 * Time: 下午8:12
 * To change this template use File | Settings | File Templates.
 */ 
class QueryController extends Controller {
    /**
     * 获取一个单词的所有的信息
     */
    public function actionWord() {
        $word = $_GET['name'];
        $user_id = $_GET['user_id'];
        $rs = $this->word->get_word_info($user_id, $word);

        var_dump($rs);
        header("Content-Type:text/html;charset=UTF-8");
        header("Content-Type", "text/json");

        echo json_encode($rs);
    }

    /**
     * 获取一个单词的例句，分页获取，最多100条
     */
    public function actionSentence() {
        $word = $_GET['word'];
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $count = isset($_GET['count']) ? $_GET['count'] : 0;

        $rs = $this->sentence->get_sentence($word, $start, $count);

        header("Content-Type:text/html;charset=UTF-8");
        header("Content-Type", "text/json");

        echo json_encode($rs);
    }

    /**
     * 获取助记信息，包括img和txt, 通过参数区分,默认文字助记
     */
    public function actionTips() {
        $word = trim($_GET['word']);
        $type = trim($_GET['type']);
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $count = isset($_GET['count']) ? $_GET['count'] : 50;

        if($type == 'img') {
            $rs = $this->tips->get_img_tips($word, $start, $count);
        } else {
            $rs = $this->tips->get_txt_tips($word, $start, $count);
        }


        header("Content-Type:text/html;charset=UTF-8");
        header("Content-Type", "text/json");

        echo json_encode($rs);
    }

    /**
     * 获取某个用户选择的img和txt的tips
     */
    public function actionSelectTips() {

    }
}