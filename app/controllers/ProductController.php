<?php


namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Product;

class ProductController extends AppController
{
    public function viewAction(){
        $alias = $this->route['alias'];
        $product = \R::findOne('product', "alias = ? AND status = 'publish'", [$alias]); // Обязательно экранируем данные от пользователя
        //Выбрасываем исключение, если продукт не найден
        if (!$product){
            throw new \Exception('Товар ' . $alias . ' не найден', 404);
        }

        //Хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->category_id, $product->title);

        //Связанные товары
        $related = \R::getAll("SELECT * FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);

        //Запись в куки запрошенного товара
        $p_model = new Product();
        $p_model->setRecentlyViewed($product->id);

        //Просмотренные товары
        $r_viewed = $p_model->getRecentlyViewed();

        $recentlyViewed = null;
        if ($r_viewed){
            $recentlyViewed = \R::find('product', 'id IN (' . \R::genSlots($r_viewed) .') LIMIT 3', $r_viewed); // \R::genSlots($r_viewed) принимает массив и подставляет на каждый элемент массива ?
        }

        //Галерея
        $gallery = \R::findAll('gallery', 'product_id = ?', [$product->id]);

        //Модификации товара
        $mods = \R::findAll('modification', 'product_id = ?', [$product->id]);

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product', 'related', 'gallery', 'recentlyViewed', 'breadcrumbs', 'mods'));
    }

}