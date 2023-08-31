<?php


namespace ishop;


use RedBeanPHP\R;

class Db
{
    use Tsingleton;

    protected function __construct(){
        $db = require_once CONF . '/config_db.php'; //Теперь в переменной $db будет лежать массив из этого файла (наши данные для подключения).
        class_alias('\RedBeanPHP\R','\R');
        R::setup($db['dsn'], $db['user'], $db['password']);


        if (!\R::testConnection()){
            throw new \Exception('Нет соединения', 500);
        }

//         По умолчания RedBean может на лету создавать поля и даже таблицы, если сохраняем в несуществующую, например. Заморозим возможность RedBean изменять табличку в любой момент
        R::freeze(TRUE);

        if (DEBUG){
            R::debug(true, 1);
        }

    }
}