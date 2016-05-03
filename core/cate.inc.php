<?php
    /**
     * 添加分类的操作
     * @return string
     */
    function addCate()
    {
        $arr = $_POST;
        connect();
        if (insert("cates", $arr)) {
            $mes = "分类添加成功!<br/><a href='../admin/addCate.php'>继续添加</a>|<a href='../admin/listCate.php'>查看分类</a>";
        } else {
            $mes = "分类添加失败！<br/><a href='../admin/addCate.php'>重新添加</a>|<a href='../admin/listCate.php'>查看分类</a>";
        }
        dbclose();
        return $mes;
    }

    /**
     * 根据ID得到指定分类信息
     * @param int $id
     * @return array
     */
    function getCateById($id)
    {
        $sql = "select cateid,cName from cates where cateid={$id}";
        return fetchOne($sql);
    }

    /**
     * 修改分类的操作
     * @param string $where
     * @return string
     */
    function editCate($where)
    {
        $arr = $_POST;
        connect();
        if (update("cates", $arr, $where)) {
            $mes = "分类修改成功!<br/><a href='../admin/listCate.php'>查看分类</a>";
        } else {
            echo showError();
            $mes = "分类修改失败!<br/><a href='../admin/listCate.php'>重新修改</a>";
        }
        return $mes;
    }

    /**
     *删除分类
     * @param string $id
     * @return string
     */
    function delCate($id)
    {
        connect();
        $res = checkProExist($id);
        if (!$res) {
            $where = "cateid=" . $id;
            if (delete("cates", $where)) {
                $mes = "分类删除成功!<br/><a href='../admin/listCate.php'>查看分类</a>|<a href='../admin/addCate.php'>添加分类</a>";
            } else {
                $mes = "删除失败！<br/><a href='../admin/listCate.php'>请重新操作</a>";
            }
            return $mes;
        } else {
            alertMes("不能删除分类，请先删除该分类下的商品", "listPro.php");
        }
    }

    /**
     * 得到所有分类
     * @return array
     */
    function getAllCate()
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $sql = "select cateid,cName from cates";
        $rows = $mysql->query($sql)->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }



