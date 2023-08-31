<?php


namespace app\widgets\currency;


use ishop\App;
use RedBeanPHP\R;

class Currency
{
    protected $tpl; // Тут записан шаблон, который будем использовать
    protected $currencies; //Список всех валют
    protected $currency; // Активная валюта

    public function __construct(){
        $this->tpl = __DIR__ . '/currency_tpl/currency.php'; // __DIR__ - директоря, где текущий файл находится
        $this->run();
    }

    //Будет получать список валют и текущую валюту, на основе этих данных будет вызывать метод, который будет строить код
    protected function run(){
        $this->currencies = App::$app->getProperty('currencies');
        $this->currency = App::$app->getProperty('currency');
        echo $this->getHtml();
    }

    // Эти методы статичные, чтоб не создавать объект и вызвать его в общем контроллере AppController, т.к. нам везде потребуется знать активную валюту, там мы результат работы этих методов запишем в реестр, и он нам доступен будет везде
    public static function getCurrencies(){
        return R::getAssoc("SELECT code, title, symbol_left, symbol_right, value, base FROM currency ORDER BY base DESC"); // Получаем ассоц. массив, с ним проще работать, сортируем так, чтоб первой была базовая валюта
    }

    // Тут мы проверим в куках наличие валюты, и мы проверим, реально ли существует она из $currencies, если она есть, берём её, если нет, то выберем базовую валюту
    public static function getCurrency($currencies){
        if (isset($_COOKIE['currency']) && array_key_exists($_COOKIE['currency'], $currencies)){
            $key = $_COOKIE['currency'];
        }else{
            $key = key($currencies); // Функция key возвращает текущий элемент массива, или первый
        }

        $currency = $currencies[$key];
        $currency['code'] = $key;

        return $currency;
    }

    // Метод будет подключать шаблон из конструктора
    protected function getHtml(){
        ob_start();
        require_once $this->tpl;
        return ob_get_clean();
    }
}