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
        $img_partitions = G::$conf['bdc']['IMAGE_TIP_PARTITION'];
        $start = intval($start);
        $limit = intval($limit);

        $word_info = $this->word->get_pure_word_info($word);
        if(!$word_info) {
            $this->logger->error('error to find word:'. $word);
            return $this->arrayResult(1, 'word:'. $word. '不在库中');
        }
        $word_id = $word_info['id'];
        $rs = $this->account->get_bae_account_for_word($word_id);
        if($rs['status'] != 0) {
            $this->logger->error('error to get account info for word:' . $word, $rs);
            return $this->arrayResult(1, 'error to get account info for word:');
        }
        $account = $rs['data']['account'];
        $bae = $rs['data']['bae'];

        $img_partition_id = intval($word_id) % $img_partitions;

        $sql = "select word, img_key  from word_tips_img_{$img_partition_id} where word = ? order by rank desc limit $start, $limit";
        $items =  $this->executeQuery($sql, array($word), false);

        $base_path = G::$conf['bdc']['CLOUD_BASE_PATH'];
        $rs = array();
        if(is_array($items)) {
            foreach($items as $item) {
                $word = $item['word'];
                $img_key = $item['img_key'];

                $img_file_path = $base_path . "/" . $word . "/images/" . $img_key;
                $img_url = $this->gen_download_url('jpeg', $img_file_path, $account, $bae);
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
        $sql = "select id, tip from word_tips_txt where word = ? order by adopt_times desc limit $start, $limit";
        $rs = $this->executeQuery($sql, array($word), false);
        if(!$rs) {
            $rs = array();
        }

        $rs =  $this->arrayResult(0, 'ok', $rs);
        $rs['word'] = $word;
        return $rs;
    }


    public function adopt_img($word, $img_key) {
        $default_inc = intval(G::$conf['bdc']['ADOPT_RANK_INC']);

        $sql = 'update word_tips_img set adopt_times = adopt_times + 1, rank = rank + ' . $default_inc . ' where word = ? and img_key =?';
        return $this->executeUpdate($sql, array($word, $img_key));
    }

    public function adopt_txt($word, $tip_id) {
        $sql = 'update word_tips_txt set adopt_times = adopt_times + 1  where id=?';
        return $this->executeUpdate($sql, array($tip_id));
    }

    public function gen_download_url($file_type, $file_path, $account, $bae) {
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

    public function add_txt_tip($data) {
        $word = $data['word'];
        $studyNo = $data['studyNo'];
        $tip_txt = $data['tip_txt'];
        $create_time = intval($data['create_time']);

        if($this->exists_txt_tip($tip_txt)) {
            return $this->arrayResult(1, 'tip:[' . $tip_txt . ']已存在，不能添加重复的助记');
        }


        $tip = new WordTipsTxt();
        $tip->tip = $tip_txt;
        $tip->create_time = $create_time;
        $tip->adopt_times = 1;
        $tip->opt_time = $create_time;
        $tip->rank = 0;
        $tip->word = $word;
        $tip->user_name = $studyNo;
        $tip->tip_md5 = md5($tip_txt);

        try {
            $tip->save();
        } catch (Exception $e) {
            $this->logger->info('error to save tip:'. $e->getMessage(), $data);
            return $this->arrayResult(1, 'error to save tip:'. $e->getMessage());
        }

        return $this->arrayResult(0, 'ok', array('id'=>$tip->id));
    }

    public function exists_txt_tip($txt) {
        if(empty($txt)) {
            return true;
        }
        $tip_md5 = md5($txt);
        $sql = 'select 1 from word_tips_txt where tip_md5 = ? and tip = ?';
        $rs = $this->executeQuery($sql, array($tip_md5, $txt));
        if(!$rs) {
            return false;
        }

        return true;
    }
}
