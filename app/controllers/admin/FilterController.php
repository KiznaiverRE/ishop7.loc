<?php


namespace app\controllers\admin;


use app\models\admin\FilterAttr;
use app\models\admin\FilterGroup;

class FilterController extends AppController
{
    public function groupDeleteAction(){
        $id = $this->getRequestParam();
        $count = \R::count('attribute_value', 'attr_group_id = ?', [$id]);
        if ($count){
            $_SESSION['error'] = 'Удаление невозможно. В группе есть атрибуты';
            redirect();
        }
        \R::exec('DELETE FROM attribute_group WHERE id = ?', [$id]);
        $_SESSION['success'] = 'Удалено';
        redirect();
    }

    public function attributeDeleteAction(){
        $id = $this->getRequestParam();

        \R::exec('DELETE FROM attribute_product WHERE attr_id = ?', [$id]);
        \R::exec('DELETE FROM attribute_value WHERE id = ?', [$id]);
        $_SESSION['success'] = 'Удалено';
        redirect();
    }

    public function attributeEditAction(){
        if (!empty($_POST)){
            $id = $this->getRequestParam(false);
            $attr = new FilterAttr();
            $data = $_POST;
            $attr->load($data);
            if (!$attr->validate($data)){
                $attr->getErrors();
                redirect();
            }
            if ($attr->update('attribute_value', $id)){
                $_SESSION['success'] = 'Изменения сохранены';
                redirect();
            }
        }


        $id = $this->getRequestParam();
        $attr = \R::load('attribute_value', $id);
        $attr_groups = \R::findAll('attribute_group');
        $this->setMeta('Редактирование атрибута');
        $this->set(compact('attr', 'attr_groups'));
    }

    public function attributeAddAction(){
        if (!empty($_POST)){
            $attr = new FilterAttr();
            $data = $_POST;
            $attr->load($data);
            if (!$attr->validate($data)){
                $attr->getErrors();
                redirect();
            }
            if ($attr->save('attribute_value', false)){
                $_SESSION['success'] = 'Фильтр добавлен';
                redirect();
            }
        }
        $groups = \R::findAll('attribute_group');
        $this->setMeta('Новый фильтр');
        $this->set(compact('groups'));
    }

    public function groupEditAction(){
        if (!empty($_POST)){
            $id = $this->getRequestParam(false);
            $group = new FilterGroup();
            $data = $_POST;
            $group->load($data);
            if (!$group->validate($data)){
                $group->getErrors();
                redirect();
            }
            if ($group->update('attribute_group', $id)){
                $_SESSION['success'] = 'Изменения сохранены';
                redirect();
            }
        }

        $id = $this->getRequestParam();
        $group = \R::load('attribute_group', $id);
        $this->setMeta("Редактирование группы {$group->title}");
        $this->set(compact('group'));
    }

    public function groupAddAction(){
        if (!empty($_POST)){
            $group = new FilterGroup();
            $data = $_POST;
            $group->load($data);
            if (!$group->validate($data)){
                $group->getErrors();
                redirect();
            }
            if ($group->save('attribute_group', false)){
                $_SESSION['success'] = 'Группа добавлена';
                redirect();
            }
        }
        $this->setMeta('Новая группа фильтров');
    }
    public function attributeGroupAction(){
        $attrs_group = \R::findAll('attribute_group');
        $this->setMeta('Группы фильтров');
        $this->set(compact('attrs_group'));
    }
    public function attributeAction(){
        $attrs = \R::getAssoc("SELECT attribute_value.*, attribute_group.title FROM attribute_value JOIN attribute_group ON attribute_group.id = attribute_value.attr_group_id");
        $this->setMeta('Фильтры');
        $this->set(compact('attrs'));
    }
}