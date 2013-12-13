<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-2-3
 * Time: 下午3:07
 * To change this template use File | Settings | File Templates.
 */ 
class UploadCommand extends Command {
    public function run($args)
    {
        $dir = "/Users/yuan/Pictures/2012-04-29/";
        $username = "yuan";
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if(is_file($dir . $file) && strpos($file, 'JPG') !== false) {
                        $file_data = file_get_contents($dir. $file);

                        $file_path = "/" . $username . "/" . date('Ymd') . "/" . md5($file_data);
                        $data = array('user_id' => 1, 'bucket_id' => 1,
                            'vender' => 'baidu', 'bucket' => 'baidu-yuan',
                            'file_type' => 'JPG',
                            'ak' => 'DCce75b9b7fbb87aea4c26b311088af8',
                            'sk' => '1fb93d9de42c78f05849c801034bd7e3',
                            'file_path'=>$file_path, 'memo'=>'great wall');
                        echo "start to upload " . $file . ":" . time() . ":file_size:" . filesize($dir . $file) . "\n";
                        $ret = $this->userFile->add_file($file_path, $file_data, $data);
                        var_dump($ret) ;
                        echo "end to upload; time:". time() . "\n";
                    }
                }
                closedir($dh);
            }
        }
    }

}
