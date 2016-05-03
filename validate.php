<?php
    /**
     * Created by PhpStorm.
     * User: 81061
     * Date: 2016/4/20 0020
     * Time: 22:42
     */
    require_once './lib/db.class.php';
    $act = $_GET['act'];
    echo 'act'.$act;
    $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
    $uaccount=$_POST['username'];
    $upwd=$_POST['password'];

    switch ($act) {
        case 'login':
            $sql="select * from users where uaccount='{$uaccount}' and upwd='{$upwd}'";
            $res=$mysql->getOne($sql);
            if($res){
                echo true;
            }else{
                echo false;
            }
            break;
        case 'reg':
            break;
        default:
            break;
    }