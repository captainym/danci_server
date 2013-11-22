<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-6
 * Time: 上午11:07
 * To change this template use File | Settings | File Templates.
 */ 
class ImgManager extends Manager {
    public function get_image($word_id, $start=0, $count=10) {
        $start = intval($start);
        $count = intval($count);

        $sql = "SELECT id, word_id, img_url, img_key FROM `word_tips_img` where word_id = ? limit $start, $count";
        return $this->executeQuery($sql, array($word_id), false);
    }
}
