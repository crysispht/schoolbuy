<?php
    require_once 'include.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>结算</title>
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
    <!--    <link href='http://fonts.useso.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>-->
    <!--    <link href='http://fonts.useso.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'><!--//fonts-->
    <link href="http://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- start menu -->
    <link href="./css/memenu.css" rel="stylesheet" type="text/css" media="all"/>
    <script type="text/javascript" src="./js/memenu.js"></script>
    <script>$(document).ready(function () {
            $(".memenu").memenu();
        });</script>
    <!--    <script src="./js/simpleCart.min.js"> </script>-->
</head>
<body>
<!--header-->
<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="search">
                <form>
                    <form method="post" action="products.php">
                        <input name="fuzzy" type="text" onFocus="this.value = '';"
                               onBlur="if (this.value == '') {this.css('placeholder','搜索');}">
                        <input type="submit" value="Go">
                    </form>
                </form>
            </div>
            <div class="header-left">
                <?php if (isset($_SESSION['loginFlag']) && $_SESSION['loginFlag']): ?>
                    <ul style="color:white;">
                        <li>欢迎您 <?php echo $_SESSION['username']; ?></li>
                        <li><a href="doAction.php?act=userOut">[退出]</a></li>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li><a href="login.php">登陆</a></li>
                        <li><a href="reg.php">免费注册</a></li>
                    </ul>
                <?php endif; ?>
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
                    <li><a class="color1" href="products.php?gender=男">男生</a>
                        <div class="mepanel">
                            <div class="row">
                                <div class="col1">
                                    <div class="h_nav">
                                        <ul style="font-size: larger">
                                            <?php
                                                $brands = getBrandsBySex('男');
                                                foreach ($brands as $key => $val) {
                                                    ?>
                                                    <li>
                                                        <a href="products.php?gender=男&bid=<?php echo $val['bid'] ?>"><?php echo $val['bname'] ?></a>
                                                    </li>
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
                    <li class="grid"><a class="color2" href="products.php?gender=女"> 女生</a>
                        <div class="mepanel">
                            <div class="row">
                                <div class="col1">
                                    <div class="h_nav">
                                        <ul style="font-size: larger">
                                            <?php
                                                $brands = getBrandsBySex('女');
                                                foreach ($brands as $key => $val) {
                                                    ?>
                                                    <li>
                                                        <a href="products.php?gender=女&bid=<?php echo $val['bid'] ?>"><?php echo $val['bname'] ?></a>
                                                    </li>
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
<div class="container">
    <div class="check">
        <h1>我的购物车(<label><?php echo $cart->getNum() ?></label>)</h1>
        <div class="col-md-9 cart-items">
            <?php
                if (empty($cart->getItems())) {
                echo '<h1 class="jumbotron">购物车中暂时没有商品，请尽情购物吧^_^</h1>';
            } else{
                $index = 1;
                foreach ($cart->getItems() as $key => $val) {

                    ?>

                    <script>$(document).ready(function (c) {
                            $('.close<?php echo $index;?>').on('click', function (c) {
                                $.post('doAction.php?act=delItem',{sid:'<?php echo $val['sid']?>'}, function (data) {
                                    window.location.reload();
                                });
                                $('.cart-header').fadeOut('slow', function (c) {
                                    $('.cart-header').remove();
                                });

                            });
                        });
                    </script>
                    <div class="cart-header">
                        <div class="close<?php echo $index; ?>"></div>
                        <div class="cart-sec simpleCardivhelfItem">
                            <div class="cart-item cyc">
                                <img src="uploads/shoes/<?php echo $val['img'] ?>" class="img-responsive" alt=""/>
                            </div>
                            <div class="cart-item-info">
                                <h3><a href="single.php?sid=<?php echo $val['sid'] ?>"><?php echo $val['sname'] ?></a>
                                </h3>
                                <ul class="qty col-xs-12">
                                    <li><p>颜色：<?php echo $val['color'] ?></p></li>
                                    <li><p>尺寸 : <?php echo $val['size'] ?></p></li>
                                    <li class="list-inline">
                                        <p>数量
                                            <button id="item<?php echo $index; ?>reduce" type="button"
                                                    class="btn btn-danger">-
                                            </button><?php echo $val['num'] ?>
                                            <button id="item<?php echo $index; ?>sub" type="button"
                                                    class="btn btn-success">+
                                            </button>
                                        </p>
                                    </li>
                                    <script>
                                        $("#item<?php echo $index;?>sub").on('click',function () {
                                            $.post('doAction.php?act=incNum',{sid:'<?php echo $val['sid']?>'}, function () {
                                                window.location.reload();
                                            });
                                        });
                                        $("#item<?php echo $index;?>reduce").on('click',function () {
                                            $.post('doAction.php?act=decNum',{sid:'<?php echo $val['sid']?>'}, function () {
                                                window.location.reload();
                                            });
                                        });
                                    </script>
                                    <li class="list-inline"><p style="text-decoration: line-through">原价
                                            : ￥<?php echo $val['sprice'] ?></p>
                                        <p>现价 : ￥<?php echo $val['discount'] ?></p></li>
                                    <li></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                    </div>
                    <?php $index++;
                } ?>
        </div>
        <div class="col-md-3 cart-total">
            <a class="continue" href="products.php">继续购物吧</a>
            <div class="price-details">
                <h3>价格详情</h3>
                <span>总计</span>
                <span id="totalprices" class="total1">￥<?php echo $cart->getPrice() ?></span>
                <span>折扣</span>
                <span id="discountrate"
                      class="total1"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . round(($cart->getPrice() - $cart->getDiscount()) / ($cart->getPrice()), 2) * 100; ?>
                    %</span>
                <span>为您省去了</span>
                <span id="spreads" class="total1">￥<?php echo number_format(($cart->getPrice() - $cart->getDiscount()),2) ?></span>
                <div class="clearfix"></div>
            </div>
            <ul class="total_price">
                <li class="last_price"><h4>总共</h4></li>
                <li class="last_price"><span id="totaldiscount">￥<?php echo $cart->getDiscount() ?></span></li>
                <div class="clearfix"></div>
            </ul>


            <div class="clearfix"></div>
            <a class="order" href="#">结算</a>
            <div class="total-item">
                <h3>其它选项</h3>
                <h4>优惠券</h4>
                <a class="cpns" href="#">查看是否拥有优惠券</a>
                <p><a href="#">登陆</a>账户使用优惠券</p>
            </div>
        </div>

        <div class="clearfix"></div>
        <?php } ?>
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
                    <li><a href="#"><i class="fa fa-qq"> </i></a></li>
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