<?php


namespace app\controllers\admin;


use app\models\AppModel;
use app\models\User;
use ishop\base\Controller;

class AppController extends Controller
{
    public $layout = 'admin';

    public function __construct($route)
    {
        parent::__construct($route);
//        debug($route);
        if (!User::isAdmin() && $route['action'] != 'login-admin'){
            redirect(ADMIN. '/user/login-admin'); //UserController::loginAdminAction
        }
        new AppModel();
    }

    public function getRequestParam($get = true, $param = 'id'){
        if ($get){
            $data = $_GET;
        }else{
            $data = $_POST;
        }

        $param = !empty($data[$param]) ? (int)$data[$param] : null;

        if (!$param){
            throw new \Exception('Страница не найдена', 404);
        }

        return $param;
    }
}