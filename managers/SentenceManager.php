<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-6
 * Time: 上午11:07
 * To change this template use File | Settings | File Templates.
 */ 
class SentenceManager extends Manager {
    public function get_sentence($word, $start=0, $limit=10) {
        $start = intval($start);
        $limit = intval($limit);


        $sql = "select id, sentence, meaning, voice_key from word_sentence where word = ? limit $start, $limit";
        $items = $this->executeQuery($sql, array($word), false);
        $rs = array();

        $base_path = G::$conf['bdc']['CLOUD_BASE_PATH'];
        $base_url = $this->get_download_server_url();

        if(is_array($items)) {
            foreach ($items as $item) {
                $voice_key = $item['voice_key'];

                $mp3_file_path = $base_path . "/" . $word . "/sentence/" . $voice_key;
                $mp3_url = $base_url . "?file_type=mp3&file_path=".urlencode($mp3_file_path);
                unset($item['voice_key']);
                $item['voice'] = $mp3_url;
                $rs []= $item;
            }
        }

        return $rs;
    }

    public function get_download_server_url() {
        return "http://acodingfarmer.com/bdc/cloud/file";
    }
}
