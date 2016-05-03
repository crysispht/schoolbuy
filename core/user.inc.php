<?php
    function reg()
    {
        $arr = array();
        $arr['uaccount'] = addslashes($_POST['username']);
        $arr['upwd'] = md5(addslashes($_POST['password']));
        $arr['uregtime'] = time();
        $arr['uemail'] = $_POST['email'];
//        $uploadFile = uploadFile();
//
//        //print_r($uploadFile);
//        if ($uploadFile && is_array($uploadFile)) {
//            $arr['face'] = $uploadFile[0]['name'];
//        } else {
//            return "注册失败";
//        }
        //完成注册的功能
        $arr['utoken'] = md5($arr['uaccount'] . $arr['upwd'] . $arr['uregtime']);
        $arr['utoken_exptime'] = $arr['uregtime'] + 3 * 3600;//过期时间
        $arr['udelete'] = 1;
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $res = $mysql->insert('users', $arr);
        $lastInsertId = $mysql->insertId();
        if ($res) {
            //发送邮件
            $transport = Swift_SmtpTransport::newInstance('smtp.sina.com');
            //设置登陆账号和密码
            $transport->setUsername('uthinkiwilldo@sina.com');
            $transport->setPassword(email_pwd);
            //得到发送邮件对象Swift_Mailer对象
            $mailer = Swift_Mailer::newInstance($transport);
            //得到邮件信息对象
            $message = Swift_Message::newInstance();
            //设置管理员信息
            $message->setFrom(array('uthinkiwilldo@sina.com' => 'king'));
            //将邮件发给谁
            $message->setTo(array($arr['uemail'] => 'Soldier'));
            //设置邮件主题
            $message->setSubject('激活邮件');
            $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?act=active&token={$arr['utoken']}";
            $urlencode = urlencode($url);
            $str = <<<EOF
            亲爱的{$arr['uaccount']}您好~！感谢您注册我们的网站
            请点击此链接激活您的账号。。。<br>
            <a href="{$url}">{$urlencode}</a><br>
            如果点此链接无反应，可以将其复制到游览器中来执行，链接的有效时间为3小时。
EOF;
            //设置邮件内容
            $message->setBody("{$str}", 'text/html', 'utf-8');
            try {
                if ($mailer->send($message)) {
                    $mes = "恭喜您{$arr['uaccount']}注册成功，请到邮箱激活之后登陆<br>";
                    $mes .= '3秒钟之后跳转到登陆页面';
                    $mes .= '<meta http-equiv="Refresh" content="3;url=./login.php">';
                } else {
                    $mes = '注册失败，请重新注册';
                    $mes .= '3秒钟之后跳转到登陆页面';
                    $mes .= '<meta http-equiv="Refresh" content="3;url=./login.php">';
                }
            } catch (Swift_SwiftException $ex) {
                $mysql->delete('users', 'id=' . $lastInsertId);
                $mes = "邮件发送错误 :" . $ex->getMessage();
            }
        } else {
            $mes = "用户注册失败，3秒钟后跳转到注册页面";
            $mes .= '<meta http-equiv="refresh" content="3;url=./reg.php"/>';
        }
        return $mes;
    }

    function login()
    {
        $username = $_POST['username'];
        //addslashes():使用反斜线引用特殊字符
        //$username=addslashes($username);
        $username = addslashes($username);
        $password = addslashes($_POST['password']);
        $password = md5($password);
        $sql = "select * from users where uaccount='{$username}' and upwd='{$password}'";
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        if ($mysql->errno()) {
            die('数据库错误: ' . $mysql->error());
        } else {
            $row = $mysql->getOne($sql);
        }
        //$resNum=getResultNum($sql);
        //echo $resNum;
        if ($row) {
            if ($row['udelete'] === 1) {
                $mes = '请先激活，在登录';
                $mes .= '<meta http-equiv="Refresh" content="3;url=index.php">';
            } else {
                $mes = '登陆成功，3秒后跳转到主页';
                $mes .= '<meta http-equiv="Refresh" content="3;url=index.php">';
                $_SESSION['loginFlag'] = $row['uid'];
                $_SESSION['username'] = $row['uaccount'];
            }
        } else {
            $mes = "登陆失败！<a href='../login.php'>重新登陆</a>";
        }
        return $mes;
    }

    function userOut()
    {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time() - 1);
        }

        session_destroy();
        header("location:index.php");
    }

    function active()
    {
        $token = addslashes($_GET['token']);
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $sql = "select uid,utoken_exptime,udelete from users where utoken='{$token}'";
        $row = $mysql->getOne($sql);
        $now = time();
        if ($now > $row['utoken_exptime']) {
            $mes = '链接失效';
        } elseif ($row['udelete'] === '0') {
            $mes = "账户已激活，该链接无效，3秒钟之后跳转到登陆页面";
            $mes .= '<meta http-equiv="Refresh" content="3;url=index.php">';
        } elseif ($row['udelete'] === '1') {
            $res = $mysql->update('users', array('udelete' => 0), "uid='{$row['uid']}'");
            if ($res) {
                $mes = "激活成功，3秒钟后跳转到登陆页面";
                $mes .= '3秒钟之后跳转到登陆页面';
                $mes .= '<meta http-equiv="Refresh" content="3;url=index.php">';
            } else {
                $mes = '激活失败，请重新激活';
            }
        }
        return $mes;
    }


