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
        //disable session， 提高并发
        session_write_close();
        $word = $_GET['name'];
        $user_id = $_GET['user_id'];
        $rs = $this->word->get_word_info($user_id, $word);

        echo json_encode($rs);
    }

    /**
     * 获取一个单词的例句，分页获取，最多100条
     */
    public function actionSentence() {
        //disable session， 提高并发
        session_write_close();
        $word = $_GET['word'];
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $count = isset($_GET['count']) ? $_GET['count'] : 0;

        $rs = $this->sentence->get_sentence($word, $start, $count);
        echo json_encode($rs);
    }

    /**
     * 获取助记信息，包括img和txt, 通过参数区分,默认文字助记
     */
    public function actionTips() {
        //disable session， 提高并发
        session_write_close();
        $word = trim($_GET['word']);
        $type = trim($_GET['type']);
        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $count = isset($_GET['count']) ? $_GET['count'] : 50;

        if($type == 'img') {
            $rs = $this->tips->get_img_tips($word, $start, $count);
        } else {
            $rs = $this->tips->get_txt_tips($word, $start, $count);
        }

        echo json_encode($rs);
    }

    public function actionUser() {
        //disable session， 提高并发
        session_write_close();
        $studyNo = $_GET['studyNo'];
        $user = $this->user->get_user_by_id($studyNo);
        if(!$user) {
            $rs = $this->user->arrayResult(1, 'invalid studyNo:' . $studyNo);
        } else {
            $rs = $this->user->arrayResult(0, 'ok', array(
               'word_used'=>$user['word_used'], 'word_limit'=>$user['word_limit'], 'create_time'=>$user['create_time']
            ));
        }

        echo json_encode($rs);
    }
}
