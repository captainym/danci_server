<?php
class WxModule extends Module{

    public function init()
    {
        $uri = Yii::app()->getRequest()->getPathInfo();
    }
}
