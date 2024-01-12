<?php


namespace app\controllers;


use app\models\Cart;
use app\models\Order;
use app\models\User;

class CartController extends AppController
{
    public function addAction(){
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
        $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;
        $mod = null; // Сюда получаем модификаторы
        if ($id){
            $product = \R::findOne('product', 'id = ?', [$id]);
            if (!$product){
                return false;
            }
            if ($mod_id){ // Проверяем, выбран ли какой-то идентификатор
                $mod = \R::findOne('modification', 'id = ? AND product_id = ?', [$mod_id, $id]);
            }
        }

        $cart = new Cart();
        $cart->addToCart($product, $qty, $mod);
        if ($this->isAjax()){
            $this->loadView('cart_modal'); // Параметры не передаём, т.к. храним корзину в сессии
        }
        redirect(); // Если данные пришли не АЯКСОМ, перезапрашиваем страницу, сделав редирект
    }

    public function showAction(){
        $this->loadView('cart_modal');
    }

    public function deleteAction(){
        $id = !empty($_GET['id']) ? $_GET['id'] : null;

        $cart = new Cart();
        $cart->delete($id);

        if ($this->isAjax()){
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function clearAction(){
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);
        $this->loadView('cart_modal');
    }

    public function viewAction(){
        $this->setMeta('Корзина');
    }

    public function checkoutAction(){
        if (!empty($_POST)){
            // регистрация пользователя
            if (!User::checkAuth()){
                $user = new User();
                $data = $_POST;
                $user->load($data);
                if (!$user->validate($data) || !$user->checkUnique()){
                    $user->getErrors();
                    $_SESSION['form_data'] = $data;
                    redirect();
                }else{
                    $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                    if (!$user_id = $user->save('user')){
                        $_SESSION['error'] = 'Ошибка';
                        redirect();
                    }
                }
            }

            //сохранение заказа (Если авторизирован)
            $data['user_id'] = isset($user_id) ? $user_id : $_SESSION['user']['id'];
            $data['note'] = !empty($_POST['note']) ? $_POST['note'] : '';
            $user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : $_POST['email'];
            $order_id = Order::saveOrder($data); // Сохранит заказ в базе и вернёт его id
            Order::mailOrder($order_id, $user_email);
        }
        redirect();
    }

}