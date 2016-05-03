<?php
    require_once 'include.php';
    $cart = new SimpleCart();
    $act = $_REQUEST['act'];
//    if ($act === "reg") {
//        $mes = reg();
//    } elseif ($act === "login") {
//        $mes = login();
//    } elseif ($act === "userOut") {
//        userOut();
//    } elseif ($act === "active") {
//        $mes = active();
//    } elseif ($act === 'clearCart') {
//        $cart->clear();
//        $mes = $cart->getNum();
//    }
    $mes='';
    switch ($act) {
        case 'reg':
            $mes = reg();
            break;
        case 'login':
            $mes = login();
            break;
        case 'userOut':
            userOut();
            break;
        case 'active':
            $mes = active();
            break;
        case 'clearCart':
            $cart->clear();
            $mes = $cart->getNum();
            break;
        case 'addCart':
            $cart->addItem($_POST);
            $mes=$cart->getNum();
                break;
        case 'delItem':
            $cart->delItem($_POST['sid']);
            //$mes=$cart->getNum();
            break;
        case 'incNum':
            $cart->incNum($_POST['sid']);
            //$mes=$cart->getNum();
            break;
        case 'decNum':
            $cart->decNum($_POST['sid']);
            //$mes=$cart->getNum();
            break;
        case 'modNum':
            $cart->modNum($_POST['sid'],$_POST['num']);
            //$mes=$cart->getNum();
            break;
        default:
            break;
    }
    echo $mes;