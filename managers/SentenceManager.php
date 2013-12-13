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
        $base_path = G::$conf['bdc']['CLOUD_BASE_PATH'];

        $word_info = $this->word->get_pure_word_info($word);
        if(!$word_info) {
            return $this->arrayResult(1, 'word:'. $word . '不存在');
        }

        $word_id = $word_info['id'];
        $rs = $this->account->get_bae_account_for_word($word_id);
        if($rs['status'] != 0) {
            $this->logger->error('error to get account info for word:' . $word, $rs);
            return $this->arrayResult(1, 'error to get account info for word:'. $word);
        }

        $account = $rs['data']['account'];
        $bae = $rs['data']['bae'];

        $rs = array();
        if(is_array($items)) {
            foreach ($items as $item) {
                $voice_key = $item['voice_key'];

                $mp3_file_path = $base_path . "/" . $word . "/sentence/" . $voice_key;
                unset($item['voice_key']);
                $item['voice'] = $this->gen_download_url('mp3', $mp3_file_path, $account, $bae);
                $rs []= $item;
            }
        }
        $rs = $this->arrayResult(0, 'ok', $rs);
        $rs['word'] = $word;

        return $rs;
    }

    /**
     * 获取可用的bae下载server
     * @return string
     */
    public function get_download_server_info($word) {

        $rs = $this->account->get_bae_account_for_word($word);
        if($rs['status'] != 0) {
            $this->logger->error('error to get account info for word:' . $word, $rs);
            return false;
        }

        $account = $rs['data']['account'];
        $bae = $rs['bae']['bae'];

        return $rs;
    }

    public function gen_download_url($file_type, $file_path,  $account, $bae) {
        $bcs_token_params = array(
            'vender'=>'baidu','bucket'=>$account['bucket'],
                'ak'=>$account['ak'], 'sk'=>$account['sk']
        );
        $bcs_token_params['file_path'] = $file_path;
        $bcs_token_params['file_type'] = $file_type;

        $token = $this->mCrypt->encrypt(json_encode($bcs_token_params));

        return $bae['domain_name'] . "?token=" . urlencode($token);
    }
}
