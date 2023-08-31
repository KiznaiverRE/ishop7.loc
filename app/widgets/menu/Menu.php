<?php


namespace app\widgets\menu;


use ishop\App;
use ishop\Cache;
use RedBeanPHP\R;

class Menu
{

    // Свойства это настройки для пользователя будут

    protected $data;
    protected $tree; // Это массив дерева, которое будем строить из данных
    protected $menuHtml; // Готовый HTML код нашего меню
    protected $tpl; // Здесь хранится шаблон для меню. По-умолчанию ничего, из-за старых версий PHP, могут быть запрещены константы
    protected $container = 'ul'; // Контейнер для меню. По-умолчанию, меню подразумевается классическим, поэтому ul, иногда может быть select
    protected $class = 'menu';
    protected $table = 'category'; // Таблица из который выбираем данные
    protected $cache = 3600; // Насколько кэшируем
    protected $cacheKey = 'ishop_menu'; // Ключ, под которым будут сохраняться файлы кэша
    protected $attrs = []; // Атрибуты для меню.
    protected $prepend = ''; // Свойство для админки, строка, которую пользователь захотеть вставить, например, если работаем с select, сформируем option'ы, но захотим вставить option по-умолчанию


    // Конструктор будет заполнять недостающие свойства и получать опции
    public function __construct($options = [])
    {
        $this->tpl = __DIR__ . '/menu/menu_tpl/menu.php'; // Это будет шаблон меню по-умолчанию, если пользователь не определил его в настройках, когда создаёт экземпляр класса в ВИДЕ
        $this->getOptions($options); // Сюда передаём массив настроек из виджета, который в конструкт попадает

        $this->run();
    }

    //7762802

    // Принимает настройки виджета и будет заполнять свойства выше
    protected function getOptions($options){
        foreach ($options as $k => $v){
            if (property_exists($this, $k)){
                $this->$k = $v;
            }
        }
    }

    // Меню будем кэшировать
    protected function run(){
//        $cache = Cache::instance();
//        $this->menuHtml = $cache->get($this->cacheKey);


        // Если не получили менюшку из кэша, то должны сформировать эти данные и записать в кэш
//        if (!$this->menuHtml){
            $this->data = App::$app->getProperty('cats');
            if (!$this->data){
                $this->data = $cats = R::getAssoc("SELECT * FROM {$this->table}");
            }
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
//            if ($this->cache){
//                $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
//            }
//        }
        // Если получили данные из кэша, то меню выводим
        $this->output();
    }

    protected function output(){
        $attrs = '';
        if (!empty($this->attrs)){
            foreach ($this->attrs as $key => $value){
                $attrs .= " $key='$value' ";
            }
        }
        echo "<{$this->container} class='{$this->class}' $attrs> ";
            echo $this->prepend;
            echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    // Из ассоциативного массива категорий получим дерево, где если элемент относится к какому-то родителю, он будет вложен в родителя
    protected function getTree(){
        $tree = [];
        $data = $this->data;
        foreach ($data as $id =>& $node){
            if (!$node['parent_id']){
                $tree[$id] = &$node;
            }else{
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }

    // Получает HTML-код
    // tab или разделитель нужен для админки, если хотим выводить, например, список select, чтоб визуально показать отношение к родительской категории
    protected function getMenuHtml($tree, $tab = ''){
        $str = '';
        foreach ($tree as $id => $category){
            $str .= $this->catToTemplate($category, $tab, $id);
        }

        return $str;
    }

    // Берём категорию и формируем из неё кусок HTML-кода
    protected function catToTemplate($category, $tab, $id){
        ob_start(); // Вкл буфер
        require $this->tpl;
        return ob_get_clean(); // Возвращаем результат из буфера
    }

}