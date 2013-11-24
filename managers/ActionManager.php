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
        $op_time = $data['opt_time'];
        $op_user = $data['username'];
        $word = $data['word'];

        return $this->arrayResult(0, 'ok');
    }
}
