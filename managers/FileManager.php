<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-2-2
 * Time: 下午2:58
 * To change this template use File | Settings | File Templates.
 */ 
class FileManager extends Manager {
    public function get_file($file_path, $params) {
        $vender = $params['vender'];
        $class_name = ucfirst($vender) . "CS";
        if(!class_exists($class_name)) {
            throw new Exception("invalid cloud store vender:" . $vender);
        }

        $this->$class_name->init($params);
        $value = $this->$class_name->get_object($file_path);

        return $value;
    }
}
