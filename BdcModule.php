<?php
class BdcModule extends Module{

    public function init()
    {
        $uri = Yii::app()->getRequest()->getPathInfo();
    }
}
