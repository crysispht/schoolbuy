<?php
    require_once 'include.php';
    if (!isset($_GET['sid'])) {
//        echo '<meta http-equiv="Refresh" content="0;url=index.php">';
//        die();
        //重定向浏览器
        header("Location: index.php");
        //确保重定向后，后续代码不会被执行
        exit();
    } else {
        $sid = $_GET['sid'];
        $cates = isset($_GET['cates']) ? $_GET['cates'] : '';
    }
    $singlepro = getProById($sid);
    if (isset($singlepro['error'])) {
        header("Location: index.php");
        //确保重定向后，后续代码不会被执行
        exit();
    }

    $cart = new SimpleCart();
?>
<!DOCTYPE html>
<html>
<head>
    <title>商品详情页</title>
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


    <script src="./js/main.js"></script>
    <!--    <script src="./js/simpleCart.min.js"></script>-->
    <script>
        function clearCart() {
            $.post('doAction.php?act=clearCart', function (data) {
                $("#carttotal").text(data);
            });
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
                                <a href="single.php?sid=<?php echo $products[$i]['sid'] ?>"><img class="img-responsive "
                                                                                                 src="<?php echo './uploads/shoes/' . $simages ?>"
                                                                                                 alt=""></a>
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
        </div>
        <!--单个商品展示-->
        <div class="col-md-9 product-price1">
            <div class="col-md-5 single-top">
                <div class="flexslider">
                    <ul class="slides">
                        <?php
                            $simages = array_filter(explode(";", $singlepro['products']['simage']));
                            $continue = true;
                            if (is_array($simages)) {
                                $counts = count($simages);
                                if ($counts > 4) {
                                    $counts = 4;
                                    $continue = true;
                                }
                                if ($counts == 1) {
                                    $simages[1] = '';
                                    $counts = 2;
                                    $continue = false;
                                }
                                foreach (array_rand($simages, $counts) as $val) {
                                    ?>
                                    <li data-thumb="<?php echo 'uploads/shoes/' . $simages[$val] ?>">
                                        <img src="<?php echo './uploads/shoes/' . $simages[$val] ?>"/>
                                    </li>
                                    <?php
                                    if ($continue == false)
                                        break;
                                }
                            } ?>
                    </ul>
                </div>
                <!-- FlexSlider -->
                <script defer src="./js/jquery.flexslider.js"></script>
                <link rel="stylesheet" href="./css/flexslider.css" type="text/css" media="screen"/>

                <script>
                    // Can also be used with $(document).ready()
                    $(window).load(function () {
                        $('.flexslider').flexslider({
                            animation: "slide",
                            controlNav: "thumbnails"
                        });
                    });
                </script>
            </div>
            <div class="col-md-7 single-top-in simpleCart_shelfItem" id="singleItem">
                <div class="single-para ">
                    <h4 class="item_name"><?php echo $singlepro['products']['sname'] ?></h4>
                    <div class="star-on">
                        <ul class="star-footer">
                            <?php
                                $sum = 0;
                                if (isset($singlepro['comments'])) {
                                    $counts = count($singlepro['comments']);
                                    for ($i = 0; $i < $counts; $i++) {
                                        $sum += $singlepro['comments'][$i]['scscore'];
                                    }
                                    for ($i = 0; $i < $sum / $counts; $i++) {
                                        ?>
                                        <li><a href="#"><i> </i></a></li>
                                        <?php
                                    }
                                } else {
                                    $counts = 0;
                                    echo " <label>无评分</label>";
                                }
                            ?>
                        </ul>
                        <div class="review">
                            <a href="#"> <?php echo $counts . ' 个评论' ?> </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <h5 style="margin: 0"
                        class="item_price"><?php echo "&#65509;" . $singlepro['products']['sdiscount'] ?></h5>
                    <p><?php echo $singlepro['products']['sinfo'] ?> </p>
                    <div class="available">
                        <ul>
                            <li class="size-in"><label>颜色</label>
                                <select id="itemcolor">
                                    <?php
                                        $colors = explode(";", $singlepro['products']['scolor']);
                                        foreach ($colors as $val) {
                                            ?>
                                            <option><?php echo $val ?></option>
                                        <?php } ?>
                                </select></li>
                            <li class="size-in"><label>尺寸</label><select id="itemsize">
                                    <?php
                                        $sizenum = $singlepro['sizenum'];
                                        if (is_array($sizenum)) {
                                            foreach ($sizenum as $key => $val) {
                                                ?>
                                                <option><?php echo $val['sizenum'] ?></option>
                                                <?php
                                            }
                                        } else {
                                            echo "<option>" . $sizenum . "</option>";
                                        } ?>
                                </select></li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <ul class="tag-men">
                        <li><span>款式</span>
                            <span class="women1"><?php echo $singlepro['products']['sgender'] . '款'; ?></span></li>
                        <li><span>品牌</span>
                            <span class="women1"><?php echo $singlepro['products']['bname']; ?></span></li>
                    </ul>
                    <?php
                        $item = array('sid' => $singlepro['products']['sid'],
                            'sname' => $singlepro['products']['sname'],
                            'discount' => $singlepro['products']['sdiscount'],
                            'sprice' => $singlepro['products']['sprices'],
                            'num' => 1,
                            'img' => $simages[0]);
                        $itemStr= "'".implode("','",$item)."'";
                    ?>
                    <a id="addcart" href="javascript:addCart(<?php echo $itemStr ?>)"
                       class="add-cart item_add">加入购物车</a>
                    <script>
                        function addCart(sid, sname, discount, sprice, num, img) {
                            var data = {
                                "sid": sid,
                                "sname": sname,
                                "discount": discount,
                                "sprice": sprice,
                                "num": parseInt(num),
                                "img": img,
                                "color": $("#itemcolor").val(),
                                "size": $("#itemsize").val()
                            };
                            $.post('doAction.php?act=addCart', data, function (data) {
                                $("#carttotal").text(data);
                                alert('商品已加入购物车^_^');
                            });
                        }
                    </script>
                </div>
            </div>
            <div class="clearfix"></div>

            <!---->
            <div class="cd-tabs">
                <nav>
                    <ul class="cd-tabs-navigation">
                        <li><a data-content="fashion" href="#0" style="width: 8em">描&nbsp;&nbsp;&nbsp;述 </a></li>
                        <li><a data-content="cinema" href="#0" style="width: 8em">额外信息</a></li>
                        <li><a data-content="television" href="#0" class="selected " style="width: 8em">评&nbsp;&nbsp;&nbsp;论(<?php echo $counts ?>
                                )</a></li>

                    </ul>
                </nav>
                <ul class="cd-tabs-content">
                    <li data-content="fashion">
                        <div class="facts">
                            <p> <?php echo $singlepro['products']['sdetail'] ?> </p>
                            <ul>
                                <li>Research</li>
                                <li>Design and Development</li>
                                <li>Porting and Optimization</li>
                                <li>System integration</li>
                                <li>Verification, Validation and Testing</li>
                                <li>Maintenance and Support</li>
                            </ul>
                        </div>

                    </li>
                    <li data-content="cinema">
                        <div class="facts1">
                            <?php
                                $prozhushi = array('sname' => '鞋名称', 'sprices' => '鞋子价格', 'sdiscount' => '鞋库折扣', 'sgender' => '鞋子款式', 'scolor' => '鞋子颜色', 'sinfo' => '内容简介', 'sdetail' => '详细信息', 'bname' => '品牌', 'tname' => '鞋子类型');
                                foreach ($singlepro['products'] as $key => $val) {
                                    if ($key == 'sid' || $key == 'simage') {
                                        continue;
                                    }
                                    ?>
                                    <div class="color">
                                        <p><?php echo $prozhushi[$key] ?></p>
                                        <span><?php echo $val ?></span>
                                        <div class="clearfix"></div>
                                    </div>
                                <?php } ?>
                        </div>

                    </li>
                    <li data-content="television" class="selected">
                        <div class="comments-top-top">
                            <?php
                                if (isset($singlepro['comments'])) {
                                    foreach ($singlepro['comments'] as $key => $val) {
                                        ?>
                                        <div class="top-comment-left">
                                            <img class="img-responsive" src="./images/co.png" alt="">
                                        </div>
                                        <div class="top-comment-right">
                                            <h6>
                                                <a href="#"><?php echo $val['uaccount'] ?></a> <?php echo "&nbsp;&nbsp;&nbsp;" . timeToString($val['sctime']) ?>
                                            </h6>
                                            <ul class="star-footer">
                                                <?php for ($i = 0; $i < $val['scscore']; $i++) { ?>
                                                    <li><a href="#"><i> </i></a></li>
                                                <?php } ?>
                                            </ul>
                                            <p><?php echo $val['sccomments'] ?></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    <?php }
                                } else {
                                    echo "<label>无品论内容</label>";
                                } ?>
                            <!--
                            <a class="add-re" href="#">添加评论</a>
                            -->
                        </div>

                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div>
            <!--////单个商品展示-->
            <div class=" bottom-product">
                <?php
                    $products = getProByRands(3);
                    foreach ($products as $key => $val) {
                        $simages = substr($val['simage'], 0, strpos($val['simage'], ";"));
                        ?>
                        <div class="col-md-4 bottom-cd simpleCart_shelfItem">
                            <div class="product-at ">
                                <a href="single.php?sid=<?php echo $val['sid'] ?>"><img class="img-responsive"
                                                                                        src="./uploads/shoes/<?php echo $simages ?>"
                                                                                        alt="">
                                    <div class="pro-grid">
                                        <span class="buy-in">现在就买</span>
                                    </div>
                                </a>
                            </div>
                            <p class="tun"><?php echo $val['sname'] ?></p>
                            <a href="#" class="item_add"><p class="number item_price">
                                    <i> </i>&#65509;<?php echo $val['sdiscount'] ?></p></a>
                        </div>
                    <?php } ?>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="clearfix"></div>
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
