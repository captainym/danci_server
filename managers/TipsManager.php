<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-11
 * Time: 下午7:02
 * To change this template use File | Settings | File Templates.
 */ 
class TipsManager extends Manager {
    public function get_img_tip_by_id($img_tip_id) {
        $sql = "select img_url, img_key from word_tips_txt where id = ?";
        return $this->executeQuery($sql, array($img_tip_id));
    }

    public function get_txt_tip_by_id($txt_tip_id) {
        $sql = "select tip from word_tips_txt where id = ?";
        return $this->executeQuery($sql, array($txt_tip_id));
    }

    public function get_img_tips($word, $start=0, $limit=50) {
        $start = intval($start);
        $limit = intval($limit);

        $sql = "select word, img_key  from word_tips_img where word = ? order by rank limit $start, $limit";
        $items =  $this->executeQuery($sql, array($word), false);

        $base_path = G::$conf['bdc']['CLOUD_BASE_PATH'];
        $base_url = $this->get_download_server_url();
        $rs = array();
        if(is_array($items)) {
            foreach($items as $item) {
                $word = $item['word'];
                $img_key = $item['img_key'];

                $img_file_path = $base_path . "/" . $word . "/images/" . $img_key;
                $img_url = $base_url . "?file_type=jpeg&file_path=".urlencode($img_file_path);
                $rs []= array('img_key'=>$img_key, 'img_url'=>$img_url);
            }
        }

        return $rs;
    }

    public function get_txt_tips($word, $start=0, $limit=50) {
        $start = intval($start);
        $limit = intval($limit);
        $sql = "select tip from word_tips_txt where word = ? order by rank limit $start, $limit";
        return $this->executeQuery($sql, array($word), false);
    }

    public function get_download_server_url() {
        return "http://imgdu.com/bdc/cloud/file";
    }
}
