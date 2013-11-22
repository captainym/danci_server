<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Email: yuanxijie@gmail.com
 * Date: 13-2-2
 * Time: 下午3:15
 * To change this template use File | Settings | File Templates.
 */ 
class UserFileManager extends Manager {
    public function get_file($file_path, $params) {
        $vender = $params['vender'];
        $class_name = ucfirst($vender) . "CS";
        if(!class_exists($class_name)) {
            throw new Exception("invalid cloud store vender:" . $vender) ;
        }

        $this->$class_name->init($params);
        $value = $this->$class_name->get_object($file_path);

        return $value;
    }

    public function get_file_by_user_file_id($user_file_id) {
        $user_file = UserFile::model()->findByPK($user_file_id);
    }

    public function add_file($file_path, $file_data, $params) {
        $vender = $params['vender'];
        $class_name = ucfirst($vender) . "CS";
        if(!class_exists($class_name)) {
            throw new Exception("invalid cloud store vender:" . $vender) ;
        }

        $user_file = new UserFile();
        $columns = array('user_id', 'bucket_id', 'vender', 'bucket', 'file_type', 'ak', 'sk', 'file_path','memo');
        foreach($columns as $col) {
            $user_file->$col = $params[$col] ;
        }
        $user_file->create_time = time();

        try {
            $user_file->save();
        } catch (Exception $e) {
            $this->logger->error("error to save user file :", $params);

            return false;
        }

        $this->$class_name->init($params);
        $ret = $this->$class_name->add_object($file_path, $file_data, $params);
        if($ret == true) {
            $user_file->status = "upload_ok";
            try {
                $user_file->update();
            } catch (Exception $e) {
                $this->logger->error("error to update user file :" . $user_file->id);

                return false;
            }
        }

        return $user_file->id;
    }
}
