<?php
    require_once 'include.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
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
    <script>$(document).ready(function () {
            $(".memenu").memenu();
        });</script>
</head>
<body>
<!--header-->
<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="search">
                <form method="post" action="products.php">
                    <input name="fuzzy" type="text" onFocus="this.value = '';"
                           onBlur="if (this.value == '') {this.css('placeholder','搜索');}">
                    <input type="submit" value="Go">
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
                    <p><a href="javascript:;" class="simpleCart_empty">清空购物车</a></p>

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
                                                foreach ($brands as $key=>$val){
                                            ?>
                                            <li><a href="products.php?gender=男&bid=<?php echo $val['bid']?>"><?php echo $val['bname']?></a></li>
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
                                                foreach ($brands as $key=>$val){
                                                    ?>
                                                    <li><a href="products.php?gender=女&bid=<?php echo $val['bid']?>"><?php echo $val['bname']?></a></li>
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

<div class="banner">
    <div class="container">
        <script src="./js/responsiveslides.min.js"></script>
        <script>
            $(function () {
                $("#slider").responsiveSlides({
                    auto: true,
                    nav: true,
                    speed: 500,
                    namespace: "callbacks",
                    pager: true,
                });
            });
        </script>
        <div id="top" class="callbacks_container">
            <ul class="rslides" id="slider">
                <li>
                    <div class="banner-text">
                        <h3>Lorem Ipsum is not simply dummy </h3>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a
                            Latin professor .</p>
                        <a href="single.php">Learn More</a>
                    </div>

                </li>
                <li>

                    <div class="banner-text">
                        <h3>There are many variations </h3>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a
                            Latin professor .</p>
                        <a href="single.php">Learn More</a>

                    </div>

                </li>
                <li>
                    <div class="banner-text">
                        <h3>Sed ut perspiciatis unde omnis</h3>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a
                            Latin professor .</p>
                        <a href="single.php">Learn More</a>

                    </div>

                </li>
            </ul>
        </div>

    </div>
</div>
<!--content-->
<div class="content">
    <div class="container">
        <div class="content-top">
            <h1>新品上市</h1>

            <div class="grid-in">
                <?php
                    $sql = "select s.sid,s.simage,t.tname,s.sname,c.cateid from shoes s  JOIN types t ON s.stid=t.tid JOIN cates c on t.cateid=c.cateid  order by s.spubtime limit 6";
                    $products = getAllProByUser($sql);
                    for ($index = 0; $index < 3; $index++) {
                        $url = urlencode($products[$index]['sid']) . '&cates=' . urlencode($products[$index]['cateid']);
                        ?>
                        <div class="col-md-4 grid-top">
                            <a href="single.php?sid=<?php echo $url ?>" class="b-link-stripe b-animate-go  thickbox">
                                <img class="img-responsive" height="290" width="285" src="<?php
                                    $images = explode(";", $products[$index]['simage']);
                                    echo "./uploads/shoes/" . $images[mt_rand(0, count($images) - 2)];
                                ?>"
                                     alt="">
                                <div class="b-wrapper">
                                    <h3 class="b-animate b-from-left    b-delay03 ">
                                        <span><?php echo $products[$index]['tname'] ?></span>
                                    </h3>
                                </div>
                            </a>
                            <p><a href="single.php?sid=<?php echo $url; ?>"><?php echo $products[$index]['sname'] ?></a>
                            </p>
                        </div>
                    <?php } ?>
                <div class="clearfix"></div>
            </div>
            <div class="grid-in">
                <?php
                    for ($index = 3; $index < 6; $index++) {
                        $url = urlencode($products[$index]['sid']) . '&cates=' . urlencode($products[$index]['cateid']);
                        ?>
                        <div class="col-md-4 grid-top">
                            <a href="single.php?sid=<?php echo $url; ?>" class="b-link-stripe b-animate-go  thickbox">
                                <img class="img-responsive" height="290" width="285" src="<?php
                                    $images = explode(";", $products[$index]['simage']);
                                    echo "./uploads/shoes/" . $images[mt_rand(0, count($images) - 2)];
                                ?>"
                                     alt="">
                                <div class="b-wrapper">
                                    <h3 class="b-animate b-from-left    b-delay03 ">
                                        <span><?php echo $products[$index]['tname'] ?></span>
                                    </h3>
                                </div>
                            </a>
                            <p><a href="single.php?sid=<?php echo $url; ?>"><?php echo $products[$index]['sname'] ?></a>
                            </p>
                        </div>
                    <?php } ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <!----->

        <div class="content-top-bottom">
            <h2>特色藏管</h2>
            <div class="col-md-6 men">
                <a href="single.php" class="b-link-stripe b-animate-go  thickbox"><img class="img-responsive"
                                                                                       src="./images/t1.jpg" alt="">
                    <div class="b-wrapper">
                        <h3 class="b-animate b-from-top top-in   b-delay03 ">
                            <span>uthink</span>
                        </h3>
                    </div>
                </a>


            </div>
            <div class="col-md-6">
                <div class="col-md1 ">
                    <a href="single.php" class="b-link-stripe b-animate-go  thickbox"><img class="img-responsive"
                                                                                           src="./images/t2.jpg"
                                                                                           alt="">
                        <div class="b-wrapper">
                            <h3 class="b-animate b-from-top top-in1   b-delay03 ">
                                <span>uthink</span>
                            </h3>
                        </div>
                    </a>

                </div>
                <div class="col-md2">
                    <div class="col-md-6 men1">
                        <a href="single.php" class="b-link-stripe b-animate-go  thickbox"><img class="img-responsive"
                                                                                               src="./images/t3.jpg"
                                                                                               alt="">
                            <div class="b-wrapper">
                                <h3 class="b-animate b-from-top top-in2   b-delay03 ">
                                    <span>uthink</span>
                                </h3>
                            </div>
                        </a>

                    </div>
                    <div class="col-md-6 men2">
                        <a href="single.php" class="b-link-stripe b-animate-go  thickbox"><img class="img-responsive"
                                                                                               src="./images/t4.jpg"
                                                                                               alt="">
                            <div class="b-wrapper">
                                <h3 class="b-animate b-from-top top-in2   b-delay03 ">
                                    <span>uthink</span>
                                </h3>
                            </div>
                        </a>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!---->
    <div class="content-bottom">
        <ul>
            <!--  <li><a href="#"><img class="img-responsive" src="./images/lo.png" alt=""></a></li>
              <li><a href="#"><img class="img-responsive" src="./images/lo1.png" alt=""></a></li>
              <li><a href="#"><img class="img-responsive" src="./images/lo2.png" alt=""></a></li>
              <li><a href="#"><img class="img-responsive" src="./images/lo3.png" alt=""></a></li>
              <li><a href="#"><img class="img-responsive" src="./images/lo4.png" alt=""></a></li>
              <li><a href="#"><img class="img-responsive" src="./images/lo5.png" alt=""></a></li>-->
            <div class="clearfix"></div>
        </ul>
    </div>
</div>
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