<?php


namespace ishop\base;


abstract class Controller
{
    public $route;
    public $controller;
    public $view;
    public $model;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = ['title' => '', 'description' => '', 'keywords' => ''];


    public function __construct($route)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->view = $route['action'];
        $this->model = $route['controller'];
        $this->prefix = $route['prefix'];
    }

    public function getView(){
        $viewObject = new View($this->route,$this->meta,  $this->layout, $this->view);
        $viewObject->render($this->data);
    }

    public function set($data){
        $this->data = $data;
    }

    public function setMeta($title = '', $description = '', $keywords = ''){
        $this->meta['title'] = $title;
        $this->meta['description'] = $description;
        $this->meta['keywords'] = $keywords;
    }

    public function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function loadView ($view, $vars = []){ // Похож на метод render(), он будет для возвращения HTML ответа на Ajaz-запрос
        extract($vars);
        require APP . "/views/{$this->prefix}/{$this->controller}/{$view}.php";
        die;
    }
}