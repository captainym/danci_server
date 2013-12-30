<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-12-30
 * Time: 下午3:34
 * To change this template use File | Settings | File Templates.
 */ 
class AppStoreController extends Controller {
    public function actionIndex() {
        $app_store_url = G::$conf['bdc']['APP_STORE_URL'];
        $this->logger->info('start to download app');
        $this->redirect($app_store_url);
    }
}
