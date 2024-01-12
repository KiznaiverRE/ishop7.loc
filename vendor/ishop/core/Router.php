<?php


namespace ishop;


use mysql_xdevapi\Exception;

class Router
{
    protected static $routes = [];
    protected static $route = [];

    public static function add($regexp, $route = []){
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes(){
        return self::$routes;
    }

    public static function getRoute(){
        return self::$route;
    }

    // Принимает запрощенный URL и делает с ним дела
    public static function dispatch($url){

        $url = self::removeQueryString($url);
        
        if (self::matchRoute($url)){
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';
            if (class_exists($controller)){
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                    if (!$controllerObject->isAjax()){
                        $controllerObject->getView();
//                        debug($controllerObject);
                    }
                }else{
                    throw new \Exception("Метод $controller::$action не найден", 404);
                }
            }else{
                throw new \Exception("Контроллер $controller не найден", 404);
            }
        }else{
            throw new \Exception('Страница не найдена', 404);
        }
    }

    //Ищет соответствие в таблице маршрутов
    public static function matchRoute($url){
        foreach (self::$routes as $pattern => $route){

            if (preg_match("#{$pattern}#i", $url, $mathces)){

                foreach ($mathces as $k => $v){
                    if (is_string($k)){
                        $route[$k] = $v;
                    }
                }

                if (empty($route['action'])){
                    $route['action'] = 'index';
                }
                if (!isset($route['prefix'])){
                    $route['prefix'] = '';
                }else{
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamesCase($route['controller']);

                self::$route = $route;
                return true;
            }
        }

        return false;
    }

    protected static function upperCamesCase($name){
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamesCase($name));
    }

    protected static function removeQueryString($url){
        if ($url){
            $params = explode('&', $url, 2);
            if (false === strpos($params[0], '=')){
                return rtrim($params[0],'/');
            }else{
                return '';
            }
        }
    }
}