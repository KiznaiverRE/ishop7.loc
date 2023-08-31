<?php

function debug($arr, $die = false){
    echo '<pre>' . print_r($arr, true) . '<pre>';
    if ($die) die;
}
function redirect($http = false){
    if ($http){ // Если передан http, знач хочет редирект на какую-то страницу
        $redirect = $http;
    }else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH; // $_SERVER['HTTP_REFERER'] - адрес, откуда пользователь пришёл
    }
    header("location:$redirect");
    exit; // Обязательно завершить скрипт так или die();
}

function hchrs($str){
    return htmlspecialchars($str, ENT_QUOTES);
}