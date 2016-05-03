<?php
//
//    /**
//     * 仿写CodeIgniter的购物车类
//     * 购物车基本功能
//     * 1) 将物品加入购物车
//     * 2) 从购物车中删除物品
//     * 3) 更新购物车物品信息 【+1/-1】
//     * 4) 对购物车物品进行统计
//     *    1. 总项目
//     * 2. 总数量
//     * 3. 总金额
//     * 5) 对购物单项物品的数量及金额进行统计
//     * 6) 清空购物车
//     */
//    class Cart
//    {
//        //物品id及名称规则,调试信息控制
//        private $product_id_rule = '\.a-z0-9-_';    //小写字母 | 数字 | ._-
//        private $product_name_rule = '\.\:a-z0-9-_';//小写字母 | 数字 | ._-:
//        private $debug = TRUE;
//
//        //购物车
//        private $_cart_contents = array();
//
//        /**
//         * 构造函数
//         *
//         * @param array
//         */
//        public function __construct()
//        {
//            //是否第一次使用?
//            if (isset($_SESSION['cart_contents'])) {
//                $this->_cart_contents = $_SESSION['cart_contents'];
//            } else {
//                $this->_cart_contents['cart_total'] = 0;
//                $this->_cart_contents['total_items'] = 0;
//            }
//
//            if ($this->debug === TRUE) {
//                //$this->_log("cart_create_success");
//            }
//        }
//
//        /**
//         * 将物品加入购物车
//         *
//         * @access    public
//         * @param array $items 一维或多维数组,必须包含键值名:
//         * id -> 物品ID标识,
//         * qty -> 数量(quantity),
//         * price -> 单价(price),
//         * name -> 物品姓名
//         * @return bool
//         */
//        public function insert($items = array())
//        {
//            //输入物品参数异常
//            if (!is_array($items) OR count($items) == 0) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_no_items_insert");
//                }
//                return FALSE;
//            }
//
//            //物品参数处理
//            $save_cart = FALSE;
//            if (isset($items['id'])) {
//                if ($this->_insert($items) === TRUE) {
//                    $save_cart = TRUE;
//                }
//            } else {
//                foreach ($items as $val) {
//                    if (is_array($val) AND isset($val['id'])) {
//                        if ($this->_insert($val) == TRUE) {
//                            $save_cart = TRUE;
//                        }
//                    }
//                }
//            }
//
//            //当插入成功后保存数据到session
//            if ($save_cart) {
//                $this->_save_cart();
//                return TRUE;
//            }
//
//            return FALSE;
//        }
//
//        /**
//         * 更新购物车物品信息
//         *
//         * @access    public
//         * @param    array
//         * @return    bool
//         */
//        public function update($items = array())
//        {
//            //输入物品参数异常
//            if (!is_array($items) OR count($items) == 0) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_no_items_insert");
//                }
//                return FALSE;
//            }
//
//            //物品参数处理
//            $save_cart = FALSE;
//            if (isset($items['rowid']) AND isset($items['qty'])) {
//                if ($this->_update($items) === TRUE) {
//                    $save_cart = TRUE;
//                }
//            } else {
//                foreach ($items as $val) {
//                    if (is_array($val) AND isset($val['rowid']) AND isset($val['qty'])) {
//                        if ($this->_update($val) === TRUE) {
//                            $save_cart = TRUE;
//                        }
//                    }
//                }
//            }
//
//            //当更新成功后保存数据到session
//            if ($save_cart) {
//                $this->_save_cart();
//                return TRUE;
//            }
//
//            return FALSE;
//        }
//
//        /**
//         * 获取购物车物品总金额
//         *
//         * @return    int
//         */
//        public function total()
//        {
//            return $this->_cart_contents['cart_total'];
//        }
//
//        /**
//         * 获取购物车物品种类
//         *
//         * @return    int
//         */
//        public function total_items()
//        {
//            return $this->_cart_contents['total_items'];
//        }
//
//        /**
//         * 获取购物车
//         *
//         * @return    array
//         */
//        public function contents()
//        {
//            return $this->_cart_contents;
//        }
//
//        /**
//         * 获取购物车物品options
//         *
//         * @param    string
//         * @return    array
//         */
//        public function options($rowid = '')
//        {
//            if ($this->has_options($rowid)) {
//                return $this->_cart_contents[$rowid]['options'];
//            } else {
//                return array();
//            }
//        }
//
//        /**
//         * 清空购物车
//         *
//         */
//        public function destroy()
//        {
//            unset($this->_cart_contents);
//
//            $this->_cart_contents['cart_total'] = 0;
//            $this->_cart_contents['total_items'] = 0;
//
//            unset($_SESSION['cart_contents']);
//        }
//
//        /**
//         * 判断购物车物品是否有options选项
//         *
//         * @param    string
//         * @return    bool
//         */
//        private function has_options($rowid = '')
//        {
//            if (!isset($this->_cart_contents[$rowid]['options']) OR count($this->_cart_contents[$rowid]['options']) === 0) {
//                return FALSE;
//            }
//
//            return TRUE;
//        }
//
//        /**
//         * 插入数据
//         *
//         * @access    private
//         * @param    array
//         * @return    bool
//         */
//        private function _insert($items = array())
//        {
//            //输入物品参数异常
//            if (!is_array($items) OR count($items) == 0) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_no_data_insert");
//                }
//                return FALSE;
//            }
//
//            //如果物品参数无效（无id/qty/price/name）
//            if (!isset($items['id']) OR !isset($items['qty']) OR !isset($items['price']) OR !isset($items['name'])) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_items_data_invalid");
//                }
//                return FALSE;
//            }
//
//            //去除物品数量左零及非数字字符
//            $items['qty'] = trim(preg_replace('/([^0-9])/i', '', urlencode($items['qty'])));
//            $items['qty'] = trim(preg_replace('/^([0]+)/i', '', urlencode($items['qty'])));
//
//            //如果物品数量为0，或非数字，则我们对购物车不做任何处理!
//            if (!is_numeric($items['qty']) OR $items['qty'] == 0) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_items_data(qty)_invalid");
//                }
//                return FALSE;
//            }
//
//            //物品ID正则判断
//            if (!preg_match('/^[' . $this->product_id_rule . ']+$/i', $items['id'])) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_items_data(id)_invalid");
//                }
//                return FALSE;
//            }
//
//            //物品名称正则判断
//            if (!preg_match('/^[' . $this->product_name_rule . ']+$/i', $items['name'])) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_items_data(name)_invalid");
//                }
//                return FALSE;
//            }
//
//            //去除物品单价左零及非数字（带小数点）字符
//            $items['price'] = trim(preg_replace('/([^0-9\.])/i', '', $items['price']));
//            $items['price'] = trim(preg_replace('/^([0]+)/i', '', $items['price']));
//
//            //如果物品单价非数字
//            if (!is_numeric($items['price'])) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_items_data(price)_invalid");
//                }
//                return FALSE;
//            }
//
//            //生成物品的唯一id
//            if (isset($items['options']) AND count($items['options']) > 0) {
//                $rowid = md5($items['id'] . implode('', $items['options']));
//            } else {
//                $rowid = md5($items['id']);
//            }
//
//            //加入物品到购物车
//            unset($this->_cart_contents[$rowid]);
//            $this->_cart_contents[$rowid]['rowid'] = $rowid;
//            foreach ($items as $key => $val) {
//                $this->_cart_contents[$rowid][$key] = $val;
//            }
//
//            return TRUE;
//        }
//
//        /**
//         * 更新购物车物品信息（私有）
//         *
//         * @access    private
//         * @param    array
//         * @return    bool
//         */
//        private function _update($items = array())
//        {
//            //输入物品参数异常
//            if (!isset($items['rowid']) OR !isset($items['qty']) OR !isset($this->_cart_contents[$items['rowid']])) {
//                if ($this->debug == TRUE) {
//                    $this->_log("cart_items_data_invalid");
//                }
//                return FALSE;
//            }
//
//            //去除物品数量左零及非数字字符
//            //$items['qty'] = preg_replace('/([^0-9])/i', '', $items['qty']);
//            $items['qty'] = preg_replace('/^([0]+)/i', '', $items['qty']);
//
//            //如果物品数量非数字，对购物车不做任何处理!
//            if (!is_numeric($items['qty'])) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_items_data(qty)_invalid");
//                }
//                return FALSE;
//            }
//
//            //如果购物车物品数量与需要更新的物品数量一致，则不需要更新
//            if ($this->_cart_contents[$items['rowid']]['qty'] == $items['qty']) {
//                if ($this->debug === TRUE) {
//                    $this->_log("cart_items_data(qty)_equal");
//                }
//                return FALSE;
//            }
//
//            //如果需要更新的物品数量等于0，表示不需要这件物品，从购物车种清除
//            //否则修改购物车物品数量等于输入的物品数量
//            if ($items['qty'] == 0) {
//                unset($this->_cart_contents[$items['rowid']]);
//            } else {
//                $this->_cart_contents[$items['rowid']]['qty'] = $items['qty'];
//            }
//
//            return TRUE;
//        }
//
//        /**
//         * 保存购物车数据到session
//         *
//         * @access    private
//         * @return    bool
//         */
//        private function _save_cart()
//        {
//            //首先清除购物车总物品种类及总金额
//            unset($this->_cart_contents['total_items']);
//            unset($this->_cart_contents['cart_total']);
//
//            //然后遍历数组统计物品种类及总金额
//            $total = 0;
//            foreach ($this->_cart_contents as $key => $val) {
//                if (!is_array($val) OR !isset($val['price']) OR !isset($val['qty'])) {
//                    continue;
//                }
//
//                $total += ($val['price'] * $val['qty']);
//
//                //每种物品的总金额
//                $this->_cart_contents[$key]['subtotal'] = ($val['price'] * $val['qty']);
//            }
//
//            //设置购物车总物品种类及总金额
//            $this->_cart_contents['total_items'] = count($this->_cart_contents);
//            $this->_cart_contents['cart_total'] = $total;
//
//            //如果购物车的元素个数少于等于2，说明购物车为空
//            if (count($this->_cart_contents) <= 2) {
//                unset($_SESSION['cart_contents']);
//                return FALSE;
//            }
//
//            //保存购物车数据到session
//            $_SESSION['cart_contents'] = $this->_cart_contents;
//            return TRUE;
//        }
//
//        /**
//         * 日志记录
//         *
//         * @access    private
//         * @param    string
//         * @return    bool
//         */
//        private function _log($msg)
//        {
//            return @file_put_contents('/uploads/log/cart_err.log', $msg, FILE_APPEND);
//        }
//    }
//
//    /*End of file cart.php*/
//    /*Location /htdocs/cart.php*/
//
//
/////*
//////购物车session的产生代码
////    if(!$session && !$scid) {
////        /*
////        session用来区别每一个购物车，相当于每个车的身份证号；
////        scid只用来标识一个购物车id号，可以看做是每个车的名字；
////        当该购物车的id和session值两者都不存在时，就产生一个新购物车
////        */
////        $session = md5(uniqid(rand()));
////        /*
////        产生一个唯一的购物车session号
////        rand()先产生个随机数，uniqid()再在该随机数的基础上产生一个独一无二的字符串，最后对该字符串进行md5
////        */
////        SetCookie(scid, $session, time() + 14400);
////        /*
////        设置该购物车cookie
////        变量名：scid（不知到这里是不是少了一个$号呢？）
////        变量值：$session
////        有效时间：当前时间+14400秒（4小时内）
////        关于setcookie函数的详细用法，大家还是参看php手册吧~
////        */
////    }
////
////
////    class Cart { //开始购物车类
////        function check_item($table, $session, $product) {
////            /*
////            查验物品(表名，session，物品)
////            */
////
////            $query = SELECT * FROM $table WHERE session='$session' AND product='$product' ;
////        /*
////        看一看'表'里该'购物车'中有没有该'产品'
////        即，该产品有没有已经放入购物车
////        */
////
////        $result = mysql_query($query);
////        if(!$result) {
////            return 0;
////        }
////        /*
////        查询失败
////        */
////
////        $numRows = mysql_num_rows($result);
////        if($numRows == 0) {
////            return 0;
////            /*
////            若没有找到，则返回0
////            */
////        } else {
////            $row = mysql_fetch_object($result);
////            return $row->quantity;
////            /*
////            若找到，则返回该物品数量
////            这里有必要解释一下mysql_fetch_object函数（下面还会用到）：
////            【mysql_fetch_object() 和 mysql_fetch_array() 类似，只有一点区别 - 返回一个对象而不是数组。】
////            上面这句话摘自php手册，说得应该很明白了吧~
////            简单的说就是，取一条记录中的某个字段，应该用“->”而不是像数组一样用下标
////            */
////        }
////    }
////
////        function add_item($table, $session, $product, $quantity) {
////            /*
////            添加新物品(表名，session，物品，数量)
////            */
////            $qty = $this->check_item($table, $session, $product);
////            /*
////            调用上面那个函数，先检查该类物品有没有已经放入车中
////            */
////
////            if($qty == 0) {
////                $query = INSERT INTO $table (session, product, quantity) VALUES ;
////            $query .= ('$session', '$product', '$quantity') ;
////            mysql_query($query);
////            /*若车中没有，则像车中添加该物品*/
////        } else {
////                $quantity += $qty; //若有，则在原有基础上增加数量
////                $query = UPDATE $table SET quantity='$quantity' WHERE session='$session' AND ;
////            $query .= product='$product' ;
////            mysql_query($query);
////            /*
////            并修改数据库
////            */
////        }
////        }
////
////        function delete_item($table, $session, $product) {
////            /*
////            删除物品(表名，session，物品)
////            */
////            $query = DELETE FROM $table WHERE session='$session' AND product='$product' ;
////        mysql_query($query);
////        /*
////        删除该购物车中该类物品
////        */
////    }
////
////        function modify_quantity($table, $session, $product, $quantity) {
////            /*
////            修改物品数量(表名，session，物品，数量)
////            */
////            $query = UPDATE $table SET quantity='$quantity' WHERE session='$session' ;
////        $query .= AND product='$product' ;
////        mysql_query($query);
////        /*
////        将该物品数量修改为参数中的值
////        */
////    }
////
////        function clear_cart($table, $session) {
////            /*
////            清空购物车（没什么好说）
////            */
////            $query = DELETE FROM $table WHERE session='$session' ;
////        mysql_query($query);
////    }
////
////        function cart_total($table, $session) {
////            /*
////            车中物品总价
////            */
////            $query = SELECT * FROM $table WHERE session='$session' ;
////        $result = mysql_query($query);
////        /*
////        先把车中所有物品取出
////        */
////
////        if(mysql_num_rows($result) > 0) {
////            while($row = mysql_fetch_object($result)) {
////                /*
////                如果物品数量>0个，则逐个判断价格并计算
////                */
////
////                $query = SELECT price FROM inventory WHERE product='$row->product' ;
////                $invResult = mysql_query($query);
////                /*
////                从inventory（库存）表中查找该物品的价格
////                */
////
////                $row_price = mysql_fetch_object($invResult);
////                $total += ($row_price->price * $row->quantity);
////                /*
////                总价 += 该物品价格 * 该物品数量
////                （ 大家应该能看明白吧:) ）
////                */
////            }
////
////        }
////        return $total; //返回总价钱
////    }
////
////
////        function display_contents($table, $session) {
////            /*
////            获取关于车中所有物品的详细信息
////            */
////            $count = 0;
////            /*
////            物品数量计数
////            注意，该变量不仅仅为了对物品数量进行统计，更重要的是，它将作为返回值数组中的下标，用来区别每一个物品！
////            */
////
////            $query = SELECT * FROM $table WHERE session='$session' ORDER BY id ;
////        $result = mysql_query($query);
////        /*
////        先取出车中所有物品
////        */
////
////        while($row = mysql_fetch_object($result)) {
////            /*
////            分别对每一个物品进行取详细信息
////            */
////
////            $query = SELECT * FROM inventory WHERE product='$row->product' ;
////            $result_inv = mysql_query($query);
////            /*
////            从inventory（库存）表中查找该物品的相关信息
////            */
////
////            $row_inventory = mysql_fetch_object($result_inv);
////            $contents[product][$count] = $row_inventory->product;
////            $contents[price][$count] = $row_inventory->price;
////            $contents[quantity][$count] = $row->quantity;
////            $contents[total][$count] = ($row_inventory->price * $row->quantity);
////            $contents[description][$count] = $row_inventory->description;
////            /*
////            把所有关于该物品的详细信息放入$contents数组
////            $contents是一个二维数组
////            第一组下标是区别每个物品各个不同的信息（如物品名，价钱，数量等等）
////            第二组下标是区别不同的物品（这就是前面定义的$count变量的作用）
////            */
////            $count++; //物品数量加一（即下一个物品）
////        }
////        $total = $this->cart_total($table, $session);
////        $contents[final] = $total;
////        /*
////        同时调用上面那个cart_total函数，计算下总价钱
////        并放入$contents数组中
////        */
////
////        return $contents;
////        /*
////        将该数组返回
////        */
////    }
////
////
////        function num_items($table, $session) {
////            /*
////            返回物品种类总数（也就是说，两个相同的东西算一种    好像是废话- -!）
////            */
////            $query = SELECT * FROM $table WHERE session='$session' ;
////        $result = mysql_query($query);
////        $num_rows = mysql_num_rows($result);
////        return $num_rows;
////        /*
////        取出车中所有物品，获取该操作影响的数据库行数，即物品总数（没什么好说的）
////        */
////    }
////
////        function quant_items($table, $session) {
////            /*
////            返回所有物品总数（也就是说，两个相同的东西也算两个物品   - -#）
////            */
////            $quant = 0;// 物品总量
////            $query = SELECT * FROM $table WHERE session='$session' ;
////        $result = mysql_query($query);
////        while($row = mysql_fetch_object($result)) {
////            /*
////            把每种物品逐个取出
////            */
////            $quant += $row->quantity; //该物品数量加到总量里去
////        }
////        return $quant; //返回总量
////    }
////
////    }*/