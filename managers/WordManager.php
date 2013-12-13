<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-6
 * Time: 上午11:06
 * To change this template use File | Settings | File Templates.
 */ 
class WordManager extends Manager {
    /**
     * 获取某个用户的单词信息
     * @param $user_id
     * @param $word
     * @return array
     */
    public function get_word_info($user_id, $word) {
        $user_info = $this->user->get_user_by_id($user_id);
        $word_info = $this->get_pure_word_info($word);
        $txt_tip_id = intval($user_info['txt_tip_id']);
        $img_tip_id = intval($user_info['img_tip_id']);

        $data = array('word'=>$word);
        if($txt_tip_id > 0) {
            $txt_tip = $this->tips->get_txt_tip_by_id();
            $data['txt_tip'] = $txt_tip;
        } else {
            $txt_tips = $this->tips->get_txt_tips($word);
            $data['txt_tip_list'] = array();
            foreach ($txt_tips as $txt_tip) {
                $data['txt_tip_list'] []= $txt_tip;
            }
        }

        if($img_tip_id > 0) {
            $img_tip = $this->tips->get_img_tip_by_id();
            $data['img_tip'] = $img_tip;
        } else {
            $img_tips =  $this->tips->get_img_tips($word);
            $data['img_tip_list'] = array();
            foreach($img_tips as $item) {
                $data['img_tip_list'] []= array('name'=>$item['img_key'], 'url'=>$item['img_url']);
            }
        }


        $sentences = $this->sentence->get_sentence($word);
        $data['sentence'] = $sentences;
        $data['yinbiao'] = $word_info['yinbiao'];

        return $this->arrayResult(0, 'ok', $data);
    }


    public function get_pure_word_info($word) {
        $sql = "select * from word w where w.word = ?";
        return $this->executeQuery($sql, array($word));
    }

    public function get_all_word() {
        $sql = "select * from word";
        return $this->executeQuery($sql, array(), false);
    }
}
