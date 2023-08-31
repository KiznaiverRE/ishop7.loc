<?php


namespace app\controllers;

// Класс для выбора валют
use app\models\Cart;
use ishop\App;
use RedBeanPHP\R;

class CurrencyController extends AppController
{
    public function changeAction(){
        $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;

        if ($currency){

//            App::$app->setProperty('currency', $currency);
//            $curr = App::$app->getProperty('currency');
//            setcookie('currency', $currency, time() + 3600*24*7);

            $curr = R::findOne('currency', 'code = ?', [$currency]);
            if (!empty($curr)){
                setcookie('currency', $currency, time() + 3600*24*7, '/');
                Cart::recalc($curr);
            }
        }

        redirect();
    }
}