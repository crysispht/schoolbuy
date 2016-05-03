<?php
    require_once 'include.php';
    if (isset($_SESSION['loginFlag']) && $_SESSION['loginFlag']) {
       echo '<meta http-equiv="Refresh" content="0;url=index.php">';
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>登陆</title>
    <link href="./css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./js/jquery.min.js"></script>
    <!-- Custom Theme files -->
    <!--theme-style-->
    <link href="./css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="New Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <!--fonts-->
<!--    <link href="https://cdnjs.cloudflare.com/ajax/libs/amazeui/2.6.1/css/amazeui.min.css" rel="stylesheet"-->
<!--          type="text/css" media="all"/>-->
<!--    <link href='http://fonts.useso.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>-->
<!--    <link href='http://fonts.useso.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>-->
    <link href="http://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!--//fonts-->
    <!-- start menu -->
    <link href="./css/memenu.css" rel="stylesheet" type="text/css" media="all"/>
    <script type="text/javascript" src="./js/memenu.js"></script>
<!--    <script src="./js/simpleCart.min.js"></script>-->
    <script type="text/javascript">
        $(document).ready(function () {
            $("#captchatext").blur(function () {
                $.get('./lib/validate.func.php?act=captcha&captcha='+$("#captchatext").val(),function (data) {
                    if(data!='true'){
                        $("#loginerror").text('验证码错误');
                        $("#btnlogin").attr('disabled','disabled');
                    }else {
                        $("#btnlogin").removeAttr('disabled');
                    }
                });
            });
            $("#captchatext").focus(function () {
               $("#loginerror").text('');
            });
            $("#loginerror").text('');
        });
        function validate() {
            $.post('./lib/validate.func.php?act=login', $("#loginform").serialize(), function (data) {
               $("#validateno").val(data);
            });
            return $("#validateno").val();
        }
    </script>
</head>
<body>
<!--header-->
<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="search">
                <form method="post" action="products.php">
                    <input name="fuzzy" type="text"  onFocus="this.value = '';"
                           onBlur="if (this.value == '') {this.css('placeholder','搜索');}">
                    <input type="submit" value="Go">
                </form>
            </div>
            <div class="header-left">
                <ul>
                    <li><a class="lock" href="login.php">登陆</a></li>
                    <li><a class="lock" href="reg.php">注册</a></li>
                </ul>
                <div class="cart box_1">
                    <a href="checkout.php">
                        <h3>
                            <div class="total">
                                <span class="simpleCart_total"> ( <label
                                        id="carttotal"><?php echo $cart->getNum() ?></label> 件商品)
                           </span></div>
                            <img src="./images/cart.png" alt=""/></h3>
                    </a>
                    <p><a href="javascript:clearCart();" class="simpleCart_empty">清空购物车</a></p>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container">
        <div class="head-top">
            <div class="logo">
                <a href="index.php" style="color: black;text-decoration: none;font-size: larger"><img
                        src="./images/logo.png" alt=""> 你想我做尽实现</a>
            </div>
            <div class=" h_menu4">
                <ul class="memenu skyblue">
                    <li class="active grid"><a class="color8" href="index.php">主页</a></li>
                    <li><a class="color1" href="#">男生</a>
                        <div class="mepanel">
                            <div class="row">
                                <div class="col1">
                                    <div class="h_nav">
                                        <ul style="font-size: larger">
                                            <?php
                                                $brands = getBrandsBySex('男');
                                                foreach ($brands as $key=>$val){
                                                    ?>
                                                    <li><a href="products.php?bid=<?php echo $val['bid']?>"><?php echo $val['bname']?></a></li>
                                                <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <!--     <div class="col1">
                                         <div class="h_nav">
                                             <h4>流行品牌</h4>
                                             <ul>
                                                 <li><a href="products.html">Levis</a></li>
                                                 <li><a href="products.html">Persol</a></li>
                                                 <li><a href="products.html">Nike</a></li>
                                                 <li><a href="products.html">Edwin</a></li>
                                                 <li><a href="products.html">New Balance</a></li>
                                                 <li><a href="products.html">Jack & Jones</a></li>
                                                 <li><a href="products.html">Paul Smith</a></li>
                                                 <li><a href="products.html">Ray-Ban</a></li>
                                                 <li><a href="products.html">Wood Wood</a></li>
                                             </ul>
                                         </div>
                                     </div>-->
                            </div>
                        </div>
                    </li>
                    <li class="grid"><a class="color2" href="#"> 女生</a>
                        <div class="mepanel">
                            <div class="row">
                                <div class="col1">
                                    <div class="h_nav">
                                        <ul style="font-size: larger">
                                            <?php
                                                $brands = getBrandsBySex('女');
                                                foreach ($brands as $key=>$val){
                                                    ?>
                                                    <li><a href="products.php?bid=<?php echo $val['bid']?>"><?php echo $val['bname']?></a></li>
                                                <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <!--    <div class="col1">
                                        <div class="h_nav">
                                            <h4>Popular Brands</h4>
                                            <ul>
                                                <li><a href="products.html">Levis</a></li>
                                                <li><a href="products.html">Persol</a></li>
                                                <li><a href="products.html">Nike</a></li>
                                                <li><a href="products.html">Edwin</a></li>
                                                <li><a href="products.html">New Balance</a></li>
                                                <li><a href="products.html">Jack & Jones</a></li>
                                                <li><a href="products.html">Paul Smith</a></li>
                                                <li><a href="products.html">Ray-Ban</a></li>
                                                <li><a href="products.html">Wood Wood</a></li>
                                            </ul>
                                        </div>
                                    </div>-->
                            </div>
                        </div>
                    </li>
                    <li><a class="color4" href="blog.html">博客</a></li>
                    <li><a class="color6" href="contact.html">联系我们</a></li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

</div>


<!--content-->
<div class="container">
    <div class="account">
        <h1>登陆账号</h1>
        <div class="account-pass">
            <div class="col-md-8 account-top">
                <form method="post" action="doAction.php?act=login" id="loginform" onsubmit="return validate()">
                    <div>
                        <span style="font-size: large">用户名</span>
                        <input type="text" name="username" id="loginusername" required>
                    </div>
                    <div>
                        <span style="font-size: large">密&nbsp;&nbsp;&nbsp;码</span>
                        <input type="password" name="password" id="loginpwd" required>
                    </div>
                    <div>
                        <span style="font-size: large">验证码</span>
                        <input type="text" name="captcha" id="captchatext" style="width: 50%" required>
                        <img id="captchaimg" src="plugins/captcha/captcha.php?r=<?php echo rand() ?>" width="150"
                             alt="图片看不清楚，点击更换" onclick="this.src='plugins/captcha/captcha.php?r='+Math.random()">
                        <a onclick="$('#captchaimg').attr('src','plugins/captcha/captcha.php?r='+Math.random())">图片看不清楚，点击更换</a>
                    </div>
                    <input type="submit" value="登陆" id="btnlogin">
                    <label id="loginerror" style="color: red"></label>
                    <input type="hidden" name="validateno" id="validateno" value="">
                </form>
            </div>
            <div class="col-md-4 left-account ">
                <a href="single.html"><img class="img-responsive " src="./images/s1.jpg" alt=""></a>
                <div class="five">
                    <h2 style="margin-bottom: 0">25%</h2><span id="discount">折扣</span>
                </div>
                <a href="reg.php" class="create">创建一个账户</a>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

</div>

<!--//content-->
<div class="footer">
    <div class="container">
        <div class="footer-top-at">

            <div class="col-md-4 amet-sed">
                <h4>更多消息</h4>
                <ul class="nav-bottom">
                    <li><a href="#">怎样预定</a></li>
                    <li><a href="#">常见问题</a></li>
                    <li><a href="contact.html">联系我们</a></li>
                </ul>
            </div>
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
    </div>
    <div class="footer-class">
        <p>Copyright &copy; 2016.uthinkiwilldo All rights reserved.</p>
    </div>
</div>
</body>
</html>
