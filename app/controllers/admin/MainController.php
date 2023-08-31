<?php


namespace app\controllers\admin;


use app\controllers\admin\AppController;
use ishop\App;

class MainController extends AppController
{

    public function __construct($route)
    {
        parent::__construct($route);
    }

    public function indexAction(){
        $countNewOrders = \R::count('order', "status = '0'"); //status это поле ENUM, Значит там строка, помещаем кавычки
        $countUsers = \R::count('user');
        $countProducts = \R::count('product');
        $countCategories = \R::count('category');
        $this->setMeta('Панель управления '.'ishop7', 'Панель управления '.'ishop7', 'keywords');
        $this->set(compact('countNewOrders', 'countCategories', 'countProducts', 'countUsers'));
    }
}