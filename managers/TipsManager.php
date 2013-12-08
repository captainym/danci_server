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
        $words = array('psychology', 'accident', 'divorce', 'remind', 'mental', 'herd');
        $rindex = rand(0,1000);
        $word = $words[$rindex%6];

        $sql = "select word, img_key  from word_tips_img where word = ? order by rank limit $start, $limit";
        $items =  $this->executeQuery($sql, array($word), false);



        $base_path = G::$conf['bdc']['CLOUD_BASE_PATH'];
        $rs = array();
        if(is_array($items)) {
            foreach($items as $item) {
                $word = $item['word'];
                $img_key = $item['img_key'];

                $img_file_path = $base_path . "/" . $word . "/images/" . $img_key;
//                $img_url = $base_url . "?file_type=jpeg&file_path=".urlencode($img_file_path);
                $img_url = $this->gen_download_url_tmp('jpeg', $img_file_path);
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


    public function adopt_img($word, $img_key) {
        $sql = 'update word_tips_img set adopt_times = adopt_times + 1 where word = ? and img_key =?';
        return $this->executeUpdate($sql, array($word, $img_key));
    }

    public function adpot_txt($word, $tip_id) {
        $sql = 'update word_tips_txt set adopt_times = adopt_times + 1  where id=?';
        return $this->executeUpdate($sql, array($tip_id));
    }

    public function gen_download_url($word, $file_type, $file_path) {
        $rs = $this->account->get_bae_account_for_word($word);
        if($rs['status'] != 0) {
            $this->logger->error('error to get account info for word:' . $word, $rs);
            return false;
        }

        $account = $rs['data']['account'];
        $bae = $rs['data']['bae'];

        $bcs_token_params = array(
            'vender'=>'baidu','bucket'=>$account['bucket'],
            'ak'=>$account['ak'], 'sk'=>$account['sk']
        );
        $bcs_token_params['file_path'] = $file_path;
        $bcs_token_params['file_type'] = $file_type;

        $token = $this->mCrypt->encrypt(json_encode($bcs_token_params));

        return $bae['domain_name'] . "?token=" . urlencode($token);
    }

    public function get_download_bcs() {
        $bucket = G::$conf['bdc']['BUCKET'];
        $baidu_ak = G::$conf['bdc']['BAIDU_AK'];
        $baidu_sk = G::$conf['bdc']['BAIDU_SK'];
        $params = array('vender'=>'baidu','bucket'=>$bucket,
            'ak'=>$baidu_ak, 'sk'=>$baidu_sk);

        return $params;
    }

    public function gen_download_url_tmp($file_type, $file_path) {
        $base_url = "http://detail.duapp.com";

        $bcs_token_params = $this->get_download_bcs();
        $bcs_token_params['file_path'] = $file_path;
        $bcs_token_params['file_type'] = $file_type;

        $token = $this->mCrypt->encrypt(json_encode($bcs_token_params));

        return $base_url . "?token=" . urlencode($token);
    }
}
