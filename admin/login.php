<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>登陆</title>
    <link type="text/css" rel="stylesheet" href="styles/reset.css">
    <link type="text/css" rel="stylesheet" href="styles/main.css">
    <!--[if IE 6]>
    <script type="text/javascript" src="../js/DD_belatedPNG_0.0.8a-min.js"></script>
    <script type="text/javascript" src="../js/ie6Fixpng.js"></script>
    <![endif]-->
</head>

<body>
<div class="headerBar">
    <div class="logoBar login_logo">
        <div class="comWidth">
            <div class="logo fl">
                <a href="#"><img src="../images/logo.png" alt="uthinkiwilldo"></a>
            </div>
            <h3 class="welcome_title">你想我做尽实现</h3>
            <h3 class="welcome_title">欢迎登陆</h3>
        </div>
    </div>
</div>

<div class="loginBox">
    <div class="login_cont">
        <form action="doLogin.php" method="post">
            <ul class="login">
                <li class="l_tit">管理员帐号</li>
                <li class="mb_10"><input type="text" name="account" placeholder="请输入管理员帐号"
                                         class="login_input user_icon"></li>
                <li class="l_tit">密码</li>
                <li class="mb_10"><input type="password" name="apwd" class="login_input password_icon"></li>
                <li class="l_tit">验证码</li>
                <li class="mb_10"><input type="text" name="verify" class="login_input password_icon"></li>
                <img src="getVerify.php" alt=""/>
                <li class="autoLogin"><input type="checkbox" id="a1" class="checked" name="autoFlag" value="1"><label
                        for="a1">自动登陆(一周内自动登陆)</label></li>
                <li><input type="submit" value="" class="login_btn"></li>
            </ul>
        </form>
    </div>
</div>

<div class="hr_25"></div>
<div class="footer">
        <div class="footer-top-at">
            <div class="col-md-4 amet-sed ">
                <h4>联系 我们</h4>

                <p>
                    你想我做</p>
                <p>尽实现</p>
                <p>官方号码：123456789</p>
                <ul class="social">
                    <li><a href="#"><i  class="fa fa-qq"> </i></a></li>
                    <li><a href="#"><i class="fa fa-weixin"> </i></a></li>
                    <li><a href="#"><i class="fa fa-weibo"> </i></a></li>

                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    <div class="footer-class">
        <p>Copyright &copy; 2016.uthinkiwilldo All rights reserved.</p>
    </div>
</div>
</body>
</html>
