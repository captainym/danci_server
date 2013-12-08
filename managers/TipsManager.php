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
//        $base_url = $this->get_download_server_url();
        $rs = array();
        if(is_array($items)) {
            foreach($items as $item) {
                $word = $item['word'];
                $img_key = $item['img_key'];

                $img_file_path = $base_path . "/" . $word . "/images/" . $img_key;
//                $img_url = $base_url . "?file_type=jpeg&file_path=".urlencode($img_file_path);
                $img_url = $this->gen_download_url('jpeg', $img_file_path);
                $rs []= array('img_key'=>$img_key, 'img_url'=>$img_url);
            }
        }

        $rs = $this->arrayResult(0, 'ok', $rs);
        $rs['word'] = $word;
        return $rs;
    }

    public function get_txt_tips($word, $start=0, $limit=50) {
        $start = intval($start);
        $limit = intval($limit);
        $sql = "select id, tip from word_tips_txt where word = ? order by rank limit $start, $limit";
        $rs = $this->executeQuery($sql, array($word), false);
        if(!$rs) {
            $rs = array();
        }

        $rs =  $this->arrayResult(0, 'ok', $rs);
        $rs['word'] = $word;
        return $rs;
    }

    /**
     * 获取可用的bae下载server
     * @return string
     */
    public function get_download_server_url() {
        return "http://detail.duapp.com";
    }

    /**
     * 获取一个最空的bcs
     */
    public function get_download_bcs() {
        $bucket = G::$conf['bdc']['BUCKET'];
        $baidu_ak = G::$conf['bdc']['BAIDU_AK'];
        $baidu_sk = G::$conf['bdc']['BAIDU_SK'];
        $params = array('vender'=>'baidu','bucket'=>$bucket,
            'ak'=>$baidu_ak, 'sk'=>$baidu_sk);

        return $params;
    }
    public function gen_download_url($file_type, $file_path) {
        $base_url = $this->get_download_server_url();
        $bcs_token_params = $this->get_download_bcs();
        $bcs_token_params['file_path'] = $file_path;
        $bcs_token_params['file_type'] = $file_type;

        $token = $this->mCrypt->encrypt(json_encode($bcs_token_params));

        return $base_url . "?token=" . urlencode($token);
    }

    public function adopt_img($word, $img_key) {
        $sql = 'update word_tips_img set adopt_times = adopt_times + 1 where word = ? and img_key =?';
        return $this->executeUpdate($sql, array($word, $img_key));
    }

    public function adpot_txt($word, $tip_id) {
        $sql = 'update word_tips_txt set adopt_times = adopt_times + 1  where id=?';
        return $this->executeUpdate($sql, array($tip_id));
    }
}
