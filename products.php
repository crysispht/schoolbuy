<?php
    require_once 'include.php';
    $sid = addslashes(isset($_GET['sid']) ? $_GET['sid'] : '');
    $cates = addslashes(isset($_GET['cates']) ? $_GET['cates'] : '');
    $gender = addslashes(isset($_GET['gender']) ? $_GET['gender'] : '');
    $bid = addslashes(isset($_GET['bid']) ? $_GET['bid'] : '');
    $tid = addslashes(isset($_GET['tid']) ? $_GET['tid'] : '');
    $fuzzy = addslashes(isset($_POST['fuzzy']) ? $_POST['fuzzy'] : '');
    if(isset($_POST['fuzzy'])){
        $fuzzy=addslashes($_POST['fuzzy']);
    }elseif (isset($_GET['fuzzy'])){
        $fuzzy=addslashes($_GET['fuzzy']);
    }else{
        $fuzzy='';
    }
    $page = addslashes(isset($_GET['page']) ? $_GET['page'] : 1);
    if (isset($singlepro['error'])) {
        header("Location: index.php");
        //确保重定向后，后续代码不会被执行
        exit();
    }
    $wherearr = array('b.bid' => $bid, 's.sgender' => $gender, 't.tid' => $tid, 'fuzzy'=>$fuzzy);
    $where=parseSearchWhere(array('sid'=>$sid,'cates'=>$cates,'gender'=>$gender,'bid'=>$bid,'tid'=>$tid,'fuzzy'=>$fuzzy));
    $productsarry = getProByPage($page, 3, $wherearr);
    $cart=new SimpleCart();
?>
<!DOCTYPE html>
<html>
<head>
    <title>商品预览</title>
    <link href="./css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./js/jquery.min.js"></script>
    <!-- Custom Theme files -->
    <!--theme-style-->
    <link href="css/simplePagination.css" rel="stylesheet" type="text/css" media="all">
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
    <!--    <link href="https://cdnjs.cloudflare.com/ajax/libs/amazeui/2.6.1/css/amazeui.min.css" rel="stylesheet" type="text/css" media="all"/>-->
    <!--    <link href='http://fonts.useso.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>-->
    <!--    <link href='http://fonts.useso.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>-->
    <link href="http://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!--//fonts-->
    <!-- start menu -->
    <link href="./css/memenu.css" rel="stylesheet" type="text/css" media="all"/>
    <script type="text/javascript" src="./js/memenu.js"></script>
    <script src="./js/jquery.simplePagination.js"></script>
    <script>$(document).ready(function () {
            $(".memenu").memenu();
        });</script>
<!--    <script src="./js/simpleCart.min.js"></script>-->
    <script>
        var totalRows=<?php echo $totalRows;?>;
        var page_index=<?php echo $page;?>;
        var itemsOnPage = 3;
        $(function() {
           // $("#paging").pagination('enable');
            $("#paging").pagination({
                items: totalRows,
                itemsOnPage: itemsOnPage,
                cssStyle: 'dark-theme',
                
                //onPageClick: changePage,
                hrefTextPrefix:'products.php?'+'<?php echo $where?>'+'page=',
                currentPage:page_index
            });
        });
    </script>
</head>
<body>
<!--header-->
<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="search">
                <form method="post" action="products.php">
                    <input name="fuzzy" type="text" placeholder="搜索" onFocus="this.value = '';"
                           onBlur="if (this.value == '') {this.css('placeholder','搜索')}">
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

<!--content-->
<!---->
<div class="product">
    <div class="container">
        <div class="col-md-3 product-price">

            <div class=" rsidebar span_1_of_left">
                <div class="of-left">
                    <h3 class="cate">商品大区</h3>
                </div>
                <ul class="menu">
                    <?php
                        $categories = getAllCate();
                        $index = 1;
                        foreach ($categories as $keys => $vals) {
                            ?>
                            <li class="<?php echo 'item' . $index; ?>"><a href="#"><?php echo $vals['cName']; ?></a>
                                <ul class="cute">
                                    <?php
                                        $jndex = 1;
                                        $types = getTypesByCateId($vals['cateid']);
                                        if (is_array($types)) {
                                            foreach ($types as $vals) {
                                                ?>
                                                <li class="<?php echo 'subitem' . $jndex ?>"><a
                                                        href="#"><?php echo $vals['tname'] ?> </a>
                                                </li>
                                                <?php
                                                $jndex++;
                                            }
                                        } else {
                                            echo '<li class="subitem2"><a href="#">无该种类商品 </a></li>';
                                        }

                                    ?>
                                </ul>
                            </li>
                            <?php
                            $index++;
                        }
                    ?>
                </ul>
            </div>
            <!--initiate accordion-->
            <script type="text/javascript">
                $(function () {
                    var menu_ul = $('.menu > li > ul'),
                        menu_a = $('.menu > li > a');
                    menu_ul.hide();
                    menu_a.click(function (e) {
                        e.preventDefault();
                        if (!$(this).hasClass('active')) {
                            menu_a.removeClass('active');
                            menu_ul.filter(':visible').slideUp('normal');
                            $(this).addClass('active').next().stop(true, true).slideDown('normal');
                        } else {
                            $(this).removeClass('active');
                            $(this).next().stop(true, true).slideUp('normal');
                        }
                    });

                });
            </script>
            <!---->
            <div class="product-middle">

                <div class="fit-top">
                    <h6 class="shop-top">uthinkiwilldo</h6>
                    <a href="#" class="shop-now">现在就去购物吧</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="sellers">
                <div class="of-left-in">
                    <h3 class="tag">标签</h3>
                </div>
                <div class="tags">
                    <ul>
                        <?php
                            $types = getTypes();
                            if (is_array($types)) {
                                foreach ($types as $val) {
                                    ?>
                                    <li>
                                        <a href="products.php?tid=<?php echo $val['tid'] ?>"><?php echo $val['tname'] ?></a>
                                    </li>
                                <?php }
                            } ?>
                        <div class="clearfix"></div>
                    </ul>

                </div>

            </div>
            <!---->
            <div class="product-bottom">
                <div class="of-left-in">
                    <h3 class="best">热销商品</h3>
                </div>
                <?php
                    $sql = "select s.sid,s.simage,s.sname,s.sdiscount,s.sprices, s.sdiscount/s.sprices pec  from shoes s,brands b,types t where s.sdelete=0 and b.bstate=1 and t.tdelete=0 and s.sbid=b.bid and s.stid=t.tid order by s.sdiscount/s.sprices desc LIMIT 3";
                    $products = getAllProByUser($sql);
                    for ($i = 2; $i > 0; $i--) {
                        $simages = substr($products[$i]['simage'], 0, strpos($products[$i]['simage'], ";"));
                        ?>
                        <div class="product-go">
                            <div class=" fashion-grid">
                                <a href="single.php?sid=<?php echo $products[$i]['sid']?>"><img class="img-responsive "
                                                 src="<?php echo './uploads/shoes/' . $simages ?>" alt=""></a>
                            </div>
                            <div class=" fashion-grid1">
                                <h6 class="best2"><a
                                        href="single.php?sid=<?php echo $products[$i]['sid'] ?>"><?php echo $products[$i]['sname'] ?> </a>
                                </h6>

                                <span class=" price-in1"> &#65509;<?php echo $products[$i]['sdiscount'] ?></span>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
            </div>
            <div class=" per1">
                <?php $simages = substr($products[0]['simage'], 0, strpos($products[0]['simage'], ";")); ?>
                <a href="single.php?sid=<?php echo $products[0]['sid'] ?>"><img class="img-responsive"
                                                                                src="<?php echo './uploads/shoes/' . $simages ?>"
                                                                                alt="">
                    <div class="six1">
                        <h4>折扣</h4>
                        <span><?php echo round($products[0]['pec'], 2) * 100 ?>%</span>
                    </div>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-9 product1">
            <div class=" bottom-product">
                <?php
                    foreach ($productsarry as $key => $val) {
                        $simages = substr($val['simage'], 0, strpos($val['simage'], ";"));
                        ?>
                        <div class="col-md-4 bottom-cd simpleCart_shelfItem">
                            <div class="product-at ">
                                <a href="single.php?sid=<?php echo $val['sid'] ?>"><img class="img-responsive"
                                                                                        src="./uploads/shoes/<?php echo $simages ?>"
                                                                                        alt="<?php echo $val['sname'] ?>">
                                    <div class="pro-grid">
                                        <span class="buy-in">详细信息</span>
                                    </div>
                                </a>
                            </div>
                            <p class="tun"><?php echo $val['sname'] ?></p>
                            <a href="single.php?sid=<?php echo $val['sid']?>" class="item_add"><p class="number item_price">
                                    <i> </i>&#65509;<?php echo $val['sdiscount'] ?></p></a>
                        </div>
                    <?php } ?>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="clearfix"></div>
        <nav class="in">
            <ul class="pagination">
                <div id="paging"></div>
            </ul>
        </nav>
    </div>

</div>

<!---->

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