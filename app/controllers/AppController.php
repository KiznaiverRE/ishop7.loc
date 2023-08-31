<?php


namespace app\controllers;


use app\models\AppModel;
use app\widgets\currency\Currency;
use ishop\App;
use ishop\base\Controller;
use ishop\Cache;
use RedBeanPHP\R;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        App::$app->setProperty('currencies', Currency::getCurrencies());
        App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));
        App::$app->setProperty('cats', self::cacheCategory());
    }

    // Идея в том, чтобы класть в кэш не только саму меню, но и массив категорий, которые используются в меню, этот массив и для хлебных крошек пригодится
    public static function cacheCategory(){
        $cache = Cache::instance();

        $cats = $cache->get('cats');
        // Пробуем получить категории из кэша, если их нет, то получим из БД, запишем в кэш и вернём
        if (!$cats){
            $cats = R::getAssoc("SELECT * FROM category");
            $cache->set('cats', $cats);
        }



        return $cats;
    }
}