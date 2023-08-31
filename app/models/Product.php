<?php


namespace app\models;


class Product extends AppModel
{
    public function setRecentlyViewed($id){ // Добавляет просмотренный товар
        $recentlyViewed = $this->getAllRecentlyViewed(); // Для начал получим все товары уже просмотренные из кук
        if (!$recentlyViewed){ // А если там ничего нет, то запишем текущий товар
            setcookie('recentlyViewed', $id, time() + 3600*24, '/');
        }else{
            $recentlyViewed = explode(',', $recentlyViewed);
            if (!in_array($id, $recentlyViewed)){
                $recentlyViewed[] = $id;
                $recentlyViewed = implode(',', $recentlyViewed);
                setcookie('recentlyViewed', $recentlyViewed, time() + 3600*24, '/');
            }else{

                $recentlyViewed = array_diff($recentlyViewed, array($id));
                $recentlyViewed[] = $id;
                $recentlyViewed = implode(',', $recentlyViewed);
                setcookie('recentlyViewed', $recentlyViewed, time() + 3600*24, '/');
            }
        }
    }

    public function getRecentlyViewed(){ // Получаем просмотренный товар
        if (!empty($_COOKIE['recentlyViewed'])){
            $recentlyViewed = $_COOKIE['recentlyViewed'];
            $recentlyViewed = explode(',', $recentlyViewed);
            return array_reverse(array_slice($recentlyViewed, -3));
        }

        return false;
    }

    public function getAllRecentlyViewed(){ // Получить все просмотренные товары
        if (!empty($_COOKIE['recentlyViewed'])){
            return $_COOKIE['recentlyViewed'];
        }
        return false;
    }

}