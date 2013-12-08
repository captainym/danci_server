<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-2-2
 * Time: 下午2:56
 * To change this template use File | Settings | File Templates.
 */ 
class ImgController extends Controller {

    public function actionAccess() {
        $file_name = $_GET[''];
    }

    public function actionRender() {
        $auth = $_GET['name'];
        $auth = str_replace("-", "/", $auth);
        $auth = base64_decode($auth);
        $auth = $this->mCrypt->decrypt($auth);
        $params = json_decode($auth, true);

        if(!$params) {
            $this->logger->error("error to decypt :" . $auth);
            $this->error404();
        }

        $file_path = $params['file_path'];
        $data = false;
        try {
            $data = $this->userFile->get_file($file_path, $params);
        } catch (Exception $e) {
            $this->logger->error("error to get file, ", $params);
            $this->error404();
        }

        if(!$data) {
            $this->error404();
        }

        $file_type = $params['file_type'];
        header("Cache-Control: max-age=315360000");
        header("Expires: Wed, 01 Feb 2023 06:37:24 GMT");

        header("Content-Type: image/$file_type");
        header("Content-Length: " .(string)strlen($data));

        echo $data;
        exit;
    }

    public function error404() {
          echo "404";
//        header("Location: http://www.baidu.com/img/shouye_b5486898c692066bd2cbaeda86d74448.gif");
        exit;
    }
    function dl_file($file){

        //First, see if the file exists
        if (!is_file($file)) { die("<b>404 File not found!</b>"); }

        //Gather relevent info about file
        $len = filesize($file);
        $filename = basename($file);
        $file_extension = strtolower(substr(strrchr($filename,"."),1));

        //This will set the Content-Type to the appropriate setting for the file
        switch( $file_extension ) {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            case "mp3": $ctype="audio/mpeg"; break;
            case "wav": $ctype="audio/x-wav"; break;
            case "mpeg":
            case "mpg":
            case "mpe": $ctype="video/mpeg"; break;
            case "mov": $ctype="video/quicktime"; break;
            case "avi": $ctype="video/x-msvideo"; break;

            //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
            case "php":
            case "htm":
            case "html":
            case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;

            default: $ctype="application/force-download";
        }

        //Begin writing headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");

        //Use the switch-generated Content-Type
        header("Content-Type: $ctype");

        //Force the download
        $header="Content-Disposition: attachment; filename=".$filename.";";
        header($header );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$len);
        @readfile($file);
        exit;
    }
}
