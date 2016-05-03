<?php
    /**
     * 添加商品
     * @return string
     */

    function addPro()
    {
        mysqli_report(MYSQLI_REPORT_STRICT);
        $arr = $_POST;
        $arr['pubTime'] = time();
        $path = "../uploads/elecpro";
        $uploadFiles = uploadFile($path);
        if (is_array($uploadFiles) && $uploadFiles) {
            foreach ($uploadFiles as $key => $uploadFile) {
                thumb($path . "/" . $uploadFile['name'], "../image_50/" . $uploadFile['name'], 50, 50);
            }
        }
        //$pid = getInsertId();
        $arr['albumPath'] = '';
        foreach ($uploadFiles as $uploadFile) {
            $arr['albumPath'] .= $uploadFile['name'] . ',';
        }
        $arr['albumPath'] = rtrim($arr['albumPath'], ',');
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $mysqli->autocommit(false);
        $keys = join(",", array_keys($arr));
        $vals = "'" . join("','", array_values($arr)) . "'";
        $sql = "insert elecpro($keys) values({$vals})";
        if (!$mysqli->errno) {
            $mysqli->query($sql);
            $mysqli->commit();
            $mes = "<p>添加成功!</p><a href='../admin/addPro.php' target='mainFrame'>继续添加</a>|<a href='../admin/listPro.php' target='mainFrame'>查看商品列表</a>";
        } else {
            foreach ($uploadFiles as $uploadFile) {
                if (file_exists("../image_50/" . $uploadFile['name'])) {
                    unlink("../image_50/" . $uploadFile['name']);
                }
            }
            $mysqli->rollback();
            $mes = "<p>添加失败!</p><a href='../admin/addPro.php' target='mainFrame'>重新添加</a>";
        }
        $mysqli->autocommit(true);
        $mysqli->close();

        return $mes;
    }

    /**
     *编辑商品
     * @param int $id
     * @return string
     */
    function editPro($id)
    {
        $arr = $_POST;
        $path = "./uploads";
        $uploadFiles = uploadFile($path);
        if (is_array($uploadFiles) && $uploadFiles) {
            foreach ($uploadFiles as $key => $uploadFile) {
                thumb($path . "/" . $uploadFile['name'], "../image_50/" . $uploadFile['name'], 50, 50);
            }
        }
        if(!empty($arr['albumPath'])){
            if ($uploadFiles && is_array($uploadFiles)) {
                foreach ($uploadFiles as $uploadFile) {
                    $arr['albumPath'] = $uploadFile['name'];
                }
            }
        }
        connect();
        $where = "id={$id}";
        $res = update("elecpro", $arr, $where);
        if ($res) {
            $mes = "<p>编辑成功!</p><a href='../admin/listPro.php' target='mainFrame'>查看商品列表</a>";
        } else {
            if (is_array($uploadFiles) && $uploadFiles) {
                foreach ($uploadFiles as $uploadFile) {
                    if (file_exists("../image_50/" . $uploadFile['name'])) {
                        unlink("../image_50/" . $uploadFile['name']);
                    }
                }
            }
            $mes = "<p>编辑失败!</p><a href='../admin/listPro.php' target='mainFrame'>重新编辑</a>";

        }
        dbclose();
        return $mes;
    }

    function delPro($id)
    {
        connect();
        $where = "id=$id";
        $res = delete("elecpro", $where);
        $proImgs = getAllImgByProId($id);
        if ($proImgs && is_array($proImgs)) {
            foreach ($proImgs as $proImg) {
                if (file_exists("../uploads/elecpro" . $proImg['albumPath'])) {
                    unlink("uploads/" . $proImg['albumPath']);
                }
                if (file_exists("../image_50/" . $proImg['albumPath'])) {
                    unlink("../image_50/" . $proImg['albumPath']);
                }
            }
        }
        if ($res) {
            $mes = "删除成功!<br/><a href='../admin/listPro.php' target='mainFrame'>查看商品列表</a>";
        } else {
            $mes = "删除失败!<br/><a href='../admin/listPro.php' target='mainFrame'>重新删除</a>";
        }
        return $mes;
    }

    /**
     * 根据用户获取所有商品
     * @param $sql
     * @return array|null
     */
    function getAllProByUser($sql)
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        if ($mysql->errno()) {
            die('数据库错误: ' . $mysql->error());
        } else {
            $query = $mysql->query($sql);
            return $mysql->fetchAll($query);
        }
    }

    /**
     * 得到商品的所有信息
     * @return array
     */
    function getAllProByAdmin()
    {
        $sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.albumPath, p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from elecpro as p join cates c on p.cId=c.cateid";
        $rows = fetchAll($sql);
        return $rows;
    }

    /**
     *根据商品id得到商品图片
     * @param int $id
     * @return array
     */
    function getAllImgByProId($id)
    {
        $sql = "select e.albumPath from elecpro e where id={$id}";
        $rows = fetchOne($sql);
        return $rows;
    }

    /**
     * 根据id得到商品的详细信息
     * @param int $sid
     * @return array|null
     */
    function getProById($sid)
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $sql = " select s.sid,s.sname,s.sprices,s.sdiscount,s.sgender,s.scolor,s.sinfo,s.simage,s.sdetail,b.bname,t.tname from shoes s LEFT JOIN brands b  on s.sbid=b.bid LEFT JOIN types t on s.stid=t.tid LEFT JOIN shoesizes ss on s.sid=ss.s_sid where s.sdelete=0 and b.bstate=1 and t.tdelete=0 and s.sid='{$sid}'";
        $row = $mysql->getOne($sql);
        if ($row) {
            $arr['products'] = $mysql->getOne($sql);
        } else {
            $arr['error'] = '没有商品具体信息';
        }
        $sql = "SELECT u.uaccount,c.sccomments,c.scscore,c.sctime from comments c,users u where u.uid=c.c_uid and c.c_sid='{$sid}'";
        $query = $mysql->query($sql);
        if ($query->num_rows > 0) {
            $arr['comments'] = $mysql->fetchAll($query);
        }
        $sql = "SELECT se.sizenum from shoesizes ss,sizes se where ss.s_sid = '{$sid}' and ss.s_sizeid = se.sizeid";
        $query = $mysql->query($sql);
        if ($query->num_rows > 0) {
            $arr['sizenum'] = $mysql->fetchAll($query);
        } else {
            $arr['sizenum'] = '没有尺码';
        }
        $arr['fields'] = $mysql->getFieldsInfo('shoes');
        return $arr;
    }


    /**
     * 根据id得到电子商品的详细信息
     * @param int $id
     * @return array
     */
    function getElecProById($id){
        $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.albumPath,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from elecpro as p join cates c on p.cId=c.cateid where p.id={$id}";
        $row=fetchOne($sql);
        return $row;
    }


    /**
     * 检查分类下是否有产品
     * @param int $cid
     * @return array
     */
    function checkProExist($cid)
    {
        $sql = "select * from elecpro where cId ={$cid}";
        $rows = fetchAll($sql);
        return $rows;
    }

    /**
     * 得到所有商品
     * @return array
     */
    function getAllPros()
    {
        $sql = "select p . id,p . pName,p . pSn,p . pNum,p . mPrice,p . iPrice,p . pDesc,p . pubTime,p . isShow,p . isHot,c . cName,p . cId from imooc_pro as p join imooc_cate c on p . cId = c . id ";
        $rows = fetchAll($sql);
        return $rows;
    }

    /**
     *根据cid得到4条产品
     * @param int $cid
     * @return Array
     */
    function getProsByCid($cid)
    {
        $sql = "select p . id,p . pName,p . pSn,p . pNum,p . mPrice,p . iPrice,p . pDesc,p . pubTime,p . isShow,p . isHot,c . cName,p . cId from imooc_pro as p join imooc_cate c on p . cId = c . id where p . cId ={
        $cid} limit 4";
        $rows = fetchAll($sql);
        return $rows;
    }

    /**
     * 得到下4条产品
     * @param int $cid
     * @return array
     */
    function getSmallProsByCid($cid)
    {
        $sql = "select p . id,p . pName,p . pSn,p . pNum,p . mPrice,p . iPrice,p . pDesc,p . pubTime,p . isShow,p . isHot,c . cName,p . cId from imooc_pro as p join imooc_cate c on p . cId = c . id where p . cId ={
        $cid} limit 4,4";
        $rows = fetchAll($sql);
        return $rows;
    }

    /**
     *得到商品ID和商品名称
     * @return array
     */
    function getProInfo()
    {
        connect();
        $sql = "select id,pName from elecpro order by id asc";
        $rows = fetchAll($sql);
        return $rows;
    }


    function getTypesByCateId($cateid)
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $sql = "select t . tname from types t where cateid = '{$cateid}'";
        $query = $mysql->query($sql);
        if ($query->num_rows > 0) {
            $types = $mysql->fetchAll($query);
        } else {
            $types = '没有物品分类';
        }
        return $types;
    }

    /**
     *中文时间转换
     * @param string $time
     * @return bool|string
     */
    function timeToString($time)
    {
        $date = date_create($time);
        return date_format($date, 'Y年m月d日 H:i:s');
    }

    /**
     * 获取所有品牌
     * @return array
     */
    function getBrands()
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $sql = "select bname from brands where bstate=1";
        $query = $mysql->query($sql);
        $brands = $mysql->fetchAll($query);
        return $brands;
    }


    function getBrandsBySex($gender)
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $sql = "select DISTINCT b.bname,b.bid from brands b,shoes s where s.sbid=b.bid and s.sgender='{$gender}'";
        $query = $mysql->query($sql);
        $brands = $mysql->fetchAll($query);
        return $brands;
    }


    /**
     * 随机取出num条数据
     * @param $num
     * @return array|null
     */
    function getProByRands($num)
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $sql = "SELECT sid,sname,sdiscount,simage FROM shoes  WHERE sid >= ((SELECT MAX(sid) FROM shoes) - (SELECT MIN(sid) FROM shoes)) * RAND() + (SELECT MIN(sid) FROM shoes)LIMIT {$num}";
        $query = $mysql->query($sql);
        $brands = $mysql->fetchAll($query);
        return $brands;
    }


    /**
     * 分页
     * @param $page
     * @param int $pageSize
     * @param null $where
     * @return mixed
     */
    function getProByPage($page = 1, $pageSize = 2, $where = null)
    {
        $sql = "select count(*) cou from `shoes` s,`brands` b,`types` t " .
            ms_new_mysql::parseWhere($where) .
            " s.sbid=b.bid and s.stid=t.tid and b.bstate=1 and t.tdelete=0 and s.sdelete=0";
        global $totalRows;
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $res = $mysql->getOne($sql);
        $totalRows = $res['cou'];
        global $totalPage;
        $totalPage = ceil($totalRows / $pageSize);
        if ($page < 1 || $page == null || !is_numeric($page)) {
            $page = 1;
        }
        if ($page >= $totalPage) $page = $totalPage;
        $offset = ($page - 1) * $pageSize;
        $sql = "select sid,sname,simage,sdiscount from `shoes` s,`brands` b,`types` t " .
            ms_new_mysql::parseWhere($where) .
            " s.sbid=b.bid and s.stid=t.tid and b.bstate=1 and t.tdelete=0 and s.sdelete=0 limit {$offset},{$pageSize}";
        $res = $mysql->query($sql);
        $rows=$mysql->fetchAll($res);
        return $rows;
    }

    /**
     * 获取鞋子类别
     * @return array|null
     */
    function getTypes()
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $sql = "select tid,tname from types ";
        $query = $mysql->query($sql);
        return $mysql->fetchAll($query);
    }