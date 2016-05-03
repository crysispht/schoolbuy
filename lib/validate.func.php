<?php
    /**
     * Created by PhpStorm.
     * User: 81061
     * Date: 2016/4/20 0020
     * Time: 22:42
     */
    require_once 'db.class.php';
    require_once '../configs/configs.php';
    session_start();
    $act = $_GET['act'];
    switch ($act) {
        case 'login':
            $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
            $uaccount = addslashes($_POST['username']);
            $upwd = md5($_POST['password']);
            $sql = "select * from users where uaccount='{$uaccount}' and upwd='{$upwd}' limit 1";
            $res = $mysql->getOne($sql);
            if ($res) {
                echo "true";
            } else {
                echo "false";
            }
            break;
        case 'reg':
            $arr = array();
            foreach ($_POST as $key => $val) {
                if ($val == '') {
                    $arr[$key] = '不能为空';
                }
            }
            if ($_POST['password'] != $_POST['repassword']) {
                $arr['password'] = '两次密码必须一致';
            }
            if (strtolower($_POST['captchatext']) != $_SESSION['authcode']) {
                $arr['captchatext'] = '验证码输入错误';
            }
            echo json_encode($arr);
            break;
        case 'captcha':
            $captcha = strtolower($_GET['captcha']);
            if ($captcha == $_SESSION['authcode']) {
                echo 'true';
            } else {
                echo 'false';
            }
            break;
        case 'loginusr':
            $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
            $uaccount = addslashes($_POST['username']);
            $sql = "select * from users where uaccount='{$uaccount}'";
            $rownum=$mysql->query($sql)->num_rows;
            if ($rownum>0) {
                echo '该用户名已被使用，请更换';
            } else {
                echo '恭喜您，该用户名可以使用^_^';
            }
            break;
        default:
            break;
    }