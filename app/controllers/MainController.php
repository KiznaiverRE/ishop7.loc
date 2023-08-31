<?php


namespace app\controllers;


use ishop\App;
use ishop\Cache;
use RedBeanPHP\R;

class MainController extends AppController
{
    // Можем переопределять layout прямо здесь
    // public $layout = 'main';

    public function indexAction(){
        $brands = R::find('brand', 'LIMIT 3');
        $hits = array_chunk(R::find('product', "hit = '1' AND status = '1' LIMIT 8"), 4);

        $this->setMeta(App::$app->getProperty('shop_name'), 'description', 'keywords');
        $this->set(compact('brands', 'hits'));
    }
}