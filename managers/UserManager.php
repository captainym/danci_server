<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-11-11
 * Time: 下午5:06
 * To change this template use File | Settings | File Templates.
 */ 
class UserManager extends Manager {

    public function add_user($data) {

        $user_name = $data['user_name'];
        $email = $data['email'];
        $passwd = $data['passwd'];
        $imei = $data['imei'];
        $sid = $data['sid'];

        $rs = $this->check_user_name($user_name);
        if($rs['status'] != 0) {
            return $rs;
        }

        $user = new User();
        $user->user_name = $user_name;
        $user->email = $email;
        $user->passwd = $passwd;
        $user->imei = $imei;
        $user->word_used = 0;
        $user->word_limit = G::$conf['DEFAULT_WORD_LIMIT'];

        try {
            $user->save();
        } catch (Exception $e) {
            $this->logger->error('error to save user:[' . $e->getMessage() . "]", $data);
            return $this->arrayResult(1, '内部错误，无法注册用户，请联系管理员');
        }

        return $this->arrayResult(0, 'ok', $user->id);
    }

    public function get_user_by_id($user_id) {
        $sql = "select * from `user` where id = ?";
        return $this->executeQuery($sql, array($user_id));
    }

    public function get_user_by_name($user_name) {
        $sql = "select * from `user` where username= ?";
        return $this->executeQuery($sql, array($user_name));
    }

    public function add_payment($user_id, $data) {
        $pay_amount = $data['pay_amount'];
        $word_limit_inc = $data['word_limit_inc'];

        $pay_time = time();
        $payment = new UserPayment();
        $payment->pay_amount = $pay_amount;
        $payment->user_id = $user_id;
        $payment->word_limit_inc = $word_limit_inc;
        $payment->pay_time = $pay_time;

        try {
            $payment->save();
        } catch (Exception $e) {
            $this->logger->error('error to save payment for user:'. $user_id. '[' . $e->getMessage() . ']', $data);
            return $this->arrayResult(1, '内部错误，充值失败，请联系管理员');
        }

        return $this->arrayResult(0, 'ok', array('payment_id'=>$payment->id, 'user_id'=>$user_id));
    }

    public function check_user_name($user_name) {
        if(empty($user_name)) {
            return $this->arrayResult(1, '用户名不能为空');
        }

        $pattern = '|^[a-zA-Z][a-zA-Z0-9_]{5,16}|';
        if(preg_match($pattern, $user_name)) {
            return $this->arrayResult(0, '验证通过');
        }

        return $this->arrayResult(1, '用户名必须是字母打头，只能有数字，字母和下划线组成');
    }
}
