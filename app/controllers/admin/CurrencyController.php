<?php


namespace app\controllers\admin;


use app\models\admin\Currency;

class CurrencyController extends AppController
{
    public function indexAction(){
        $currencies = \R::findAll('currency');
        $this->setMeta('Список валют');
        $this->set(compact('currencies'));
    }

    public function deleteAction(){
        $id = $this->getRequestParam();
        $currency = \R::load('currency', $id);
        \R::trash($currency);
        $_SESSION['success'] = "Изменения сохранены";
        redirect();
    }

    public function editAction(){
        if(!empty($_POST)){
            $id = $this->getRequestParam(false);
            $currency = new Currency();
            $data = $_POST;
            $currency->load($data);
            $currency->attributes['base'] = $currency->attributes['base'] ? 1 : 0;
            if(!$currency->validate($data)){
                $currency->getErrors();
                redirect();
            }
            if($currency->update('currency', $id)){
                $_SESSION['success'] = "Изменения сохранены";
                redirect();
            }
        }

        $id = $this->getRequestParam();
        $currency = \R::load('currency', $id);
        $this->setMeta("Редактирование валюты {$currency->title}");
        $this->set(compact('currency'));
    }

    public function addAction(){
        if (!empty($_POST)){
            $currency = new Currency();
            $data = $_POST;
            $currency->load($data);
            $currency->attributes['base'] = $currency->attributes['base'] ? 1 : 0;
            if (!$currency->validate($data)){
                $currency->getErrors();
                redirect();
            }
            if ($currency->save('currency')){
                $_SESSION['success'] = 'Валюта добавлена';
                redirect();
            }
        }
        $groups = \R::findAll('attribute_group');
        $this->setMeta('Новая валюта');
        $this->set(compact('groups'));
    }
}