<?php


namespace app\models;


use ishop\App;

class Cart extends AppModel
{
    public function addToCart($product, $qty = 1, $mod = null){
        if (!isset($_SESSION['cart.currency'])){
            $_SESSION['cart.currency'] = App::$app->getProperty('currency');
        }
        if ($mod){
            $ID = "{$product->id}-{$mod->id}";
            $title = "{$product->title} ($mod->title)";
            $price = $mod->price;
        }else{
            $ID = $product->id;
            $title = $product->title;
            $price = $product->price;
        }
        if (isset($_SESSION['cart'][$ID])){
            $_SESSION['cart'][$ID]['qty'] += $qty;
        }else{
            $_SESSION['cart'][$ID] = [
                'qty' => $qty,
                'title' => $title,
                'alias' => $product->alias,
                'price' => $price * $_SESSION['cart.currency']['value'],
                'img' => $product->img
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * ($price * $_SESSION['cart.currency']['value']) : $qty * ($price * $_SESSION['cart.currency']['value']);
    }

    public function delete($id){
//        if (isset($_SESSION['cart'][$id])){
            $minusQty = $_SESSION['cart'][$id]['qty'];
            $minusSum = $_SESSION['cart'][$id]['price'] * $minusQty;
            $_SESSION['cart.qty'] -= $minusQty;
            $_SESSION['cart.sum'] -= $minusSum;
            unset($_SESSION['cart'][$id]);
//        }
    }
    public static function recalc($currency){
        if (isset($_SESSION['cart.currency'])){
            if ($_SESSION['cart.currency']['base']){
                $_SESSION['cart.sum'] *= $currency->value;
            }else{
                $_SESSION['cart.sum'] = $_SESSION['cart.sum'] / $_SESSION['cart.currency']['value'] * $currency->value;
            }

            foreach ($_SESSION['cart'] as $k => $v){
                if ($_SESSION['cart.currency']['base']){
                    $_SESSION['cart'][$k]['price'] *= $currency->value;
                }else{
                    $_SESSION['cart'][$k]['price'] = $_SESSION['cart'][$k]['price'] / $_SESSION['cart.currency']['value'] * $currency->value;
                }
            }
            foreach ($currency as $k => $v){
                $_SESSION['cart.currency'][$k] = $v;
            }

        }
    }
}