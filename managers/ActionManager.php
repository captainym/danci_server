<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-6
 * Time: 下午1:55
 * To change this template use File | Settings | File Templates.
 */ 
class ActionManager extends Manager {
    public function add_op($data) {
        $op_type = $data['otype'];
        $op_value = $data['ovalue'];
        $word = $data['word'];
        $op_time = time();


        $option = new UserOperation();

        return $this->arrayResult(0, 'ok');
    }

    public function add_feedback($data) {
        $word = $data['word'];
        $studyNo = $data['studyNo'];
        $status = $data['feedback_type'];
        $create_time = intval($data['create_time']);

        $feedback = new WordFeedback();
        $feedback->user_id = $studyNo;
        $feedback->word = $word;
        $feedback->status = $status;
        $feedback->feedback_time = $create_time;

        try {
            $feedback->save();
        } catch (Exception $e) {
            $this->logger->error('error to save feeback:'. $e->getMessage(), $data);
            return $this->arrayResult(1, 'error to save feeback:'. $e->getMessage());
        }

        return $this->arrayResult(0, 'ok', array('id'=>$feedback->id));
    }
}
