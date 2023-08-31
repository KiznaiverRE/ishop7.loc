<?php


namespace ishop\base;

//Будет отвечать, в первую очередь за работу с базой данными, но не только, за работу с данными вообще. Валидация данных, функции, обрабатывающие данные (для загрузки файлов)
use ishop\Db;
use Valitron\Validator;

abstract class Model
{
    public $attributes = []; //тут будет массив свойств модели, который будет идентичен полям в таблицах БД, чтоб загружать автоматом из форм данные в модель и сохранять и выгружать их в БД
    public $errors = []; // Туда будем складывать ошибки
    public $rules = []; //Для правил валидации данных

    public function __construct(){ //Тут будет организовывать подключение к БД, понадобятся настройки к БД
        Db::instance();
    }

    // Грузим данные из POST запроса и записываем в атрибуты
    public function load($data){
        foreach ($this->attributes as $name => $value){
            if (isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function save($table){
        $tbl = \R::dispense($table);
        foreach ($this->attributes as $name => $value){
            $tbl->$name = $value;
        }
        return \R::store($tbl);
    }

    public function update($table, $id){
        $bean = \R::load($table, $id);
        foreach ($this->attributes as $name => $value){
            $bean->$name = $value;
        }
        return \R::store($bean);
    }

    public function validate($data){
        Validator::langDir(WWW. '/validator/lang');
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);
        if ($v->validate()){
            return true;
        }else{
            $this->errors = $v->errors();
            return false;
        }
    }
    public function getErrors(){
        $errors = '<ul>';
        foreach ($this->errors as $error){
            foreach ($error as $item){
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }
}