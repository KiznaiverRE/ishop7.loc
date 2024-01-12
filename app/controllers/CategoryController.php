<?php


namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Category;
use app\widgets\filter\Filter;
use ishop\App;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class CategoryController extends AppController
{
    public function viewAction(){
        $alias = $this->route['alias'];
        $category = R::findOne('category', 'alias = ?', [$alias]);
        if (!$category){
            throw new \Exception('Страница не найдена', 404);
        }

        //Хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category->id);

        $cat_model = new Category();
        $ids = $cat_model->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;
//        debug($ids);

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = App::$app->getProperty('pagination');

        $sql_part = '';
        if (!empty($_GET['filter'])){
            /*
            SELECT `product`.* FROM `product` WHERE category_id IN (6) AND id IN
            (
                SELECT product_id FROM attribute_product WHERE attr_id IN (1,5) GROUP BY product_id HAVING COUNT(product_id) = 2
            )
            */
            $sql_part =
            $filter = Filter::getFilter();

            if ($filter){
                $cnt = Filter::getCountGroups($filter);
                $sql_part = "AND id IN (SELECT product_id FROM attribute_product WHERE attr_id IN ($filter) GROUP BY product_id HAVING COUNT(product_id) = $cnt)";
            }
        }


        $total = R::count('product', "category_id IN ($ids) $sql_part");
        $pagination = new Pagination($page, $perPage, $total);
        $start = $pagination->getStart();


        $products = R::find('product', "status = 'publish' AND category_id IN ($ids) $sql_part LIMIT $start, $perPage");
//        debug($products);
        if ($this->isAjax()){
            $this->loadView('filter', compact('products', 'pagination', 'total'));
        }
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'total'));
    }
}