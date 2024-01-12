<?php


namespace app\controllers;


use RedBeanPHP\R;

class SearchController extends AppController
{
    public function typeaheadAction(){
        if ($this->isAjax()){
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;
            if ($query){
                $products = R::getAll("SELECT id, title FROM product WHERE title LIKE ? AND status = 'publish' LIMIT 9", ["%{$query}%"]);
                echo json_encode($products);
            }
        }
        die;
    }

    public function indexAction(){
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;
        if ($query){
            $products = R::find('product', 'title LIKE ?', ["%{$query}%"]);
            $this->set(compact('products', 'query'));
            $this->setMeta('Поиск по ' . hchrs($query));
        }
    }
}