<?php


namespace app\controllers\admin;


use app\models\User;
use ishop\libs\Pagination;

class UserController extends AppController
{
    public function indexAction(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perpage = 3;
        $count = \R::count('user');
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();
        $users = \R::findAll('user', "LIMIT $start, $perpage");
        $this->setMeta('Список пользователей');
        $this->set(compact('users', 'pagination', 'count'));
    }

    public function editAction(){
        $user_id = $this->getRequestParam();
        $user = \R::load('user', $user_id);

        $this->setMeta("Реадктирование пользователя $user->name");
        $this->set(compact('user'));
    }
    public function loginAdminAction(){
        if (!empty($_POST)){
            $user = new User();
            if (!$user->login(true)){
                $_SESSION['error'] = 'Логин или пароль введены неверно';
            }

            if (User::isAdmin()){
                debug(11111);
                redirect(ADMIN);
            }else{
                debug(2222);
                redirect();
            }
        }
        $this->layout = 'login';
    }
}