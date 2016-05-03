<?php
    /**
     * 检查管理员是否存在
     * @param unknown_type $sql
     * @return Ambigous <multitype:, multitype:>
     */
    function checkAdmin($sql)
    {
        return fetchOne($sql);
    }

    /**
     * 检测是否有管理员登陆.
     */
    function checkLogined()
    {
        if ($_SESSION['adminId'] == "" && $_COOKIE['adminId'] == "") {
            alertMes("请先登陆", "login.php");
        }
    }

    /**
     * 添加管理员
     * @return string
     */
    function addAdmin()
    {
        $arr = $_POST;
        $arr['account']=addslashes($_POST['account']);
        $arr['apwd'] = md5($_POST['apwd']);
        connect();
        if (insert("admins", $arr)) {
            $mes = "添加成功!<br/><a href='../admin/addAdmin.php'>继续添加</a>|<a href='../admin/listAdmin.php'>查看管理员列表</a>";
        } else {
            $mes = "添加失败!<br/><a href='../admin/addAdmin.php'>重新添加</a>";
        }
        return $mes;
    }

    /**
     * 得到所有的管理员
     * @return array
     */
    function getAllAdmin()
    {

        $sql = "select aid,account,apwd,email from admins ";
        $rows = fetchAll($sql);
        return $rows;
    }

    function getAdminByPage($page, $pageSize = 2)
    {
        $sql = "select * from admins";
        global $totalRows;
        $totalRows = getResultNum($sql);
        global $totalPage;
        $totalPage = ceil($totalRows / $pageSize);
        if ($page < 1 || $page == null || !is_numeric($page)) {
            $page = 1;
        }
        if ($page >= $totalPage) $page = $totalPage;
        $offset = ($page - 1) * $pageSize;
        $sql = "select aid,account,email from admins limit {$offset},{$pageSize}";
        $rows = fetchAll($sql);
        return $rows;
    }

    /**
     * 编辑管理员
     * @param int $id
     * @return string
     */
    function editAdmin($id)
    {
        connect();
        $arr = $_POST;
        $arr['apwd'] = md5($_POST['apwd']);
        if (update("admins", $arr, "aid={$id}")) {
            $mes = "编辑成功!<br/><a href='../admin/listAdmin.php'>查看管理员列表</a>";
        } else {
            $mes = "编辑失败!<br/><a href='../admin/listAdmin.php'>请重新修改</a>";
        }
        return $mes;
    }

    /**
     * 删除管理员的操作
     * @param int $id
     * @return string
     */
    function delAdmin($id)
    {
        connect();
        if (delete("admins", "aid={$id}")) {
            $mes = "删除成功!<br/><a href='../admin/listAdmin.php'>查看管理员列表</a>";
        } else {
            $mes = "删除失败!<br/><a href='../admin/listAdmin.php'>请重新删除</a>";
        }
        return $mes;
    }

    /**
     * 注销管理员
     */
    function logout()
    {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time() - 1);
        }
        if (isset($_COOKIE['adminId'])) {
            setcookie("adminId", "", time() - 1);
        }
        if (isset($_COOKIE['adminName'])) {
            setcookie("adminName", "", time() - 1);
        }
        session_destroy();
        header("location:login.php");
    }

    /**
     * 添加用户的操作
     * @return string
     */
    function addUser()
    {
        $arr = $_POST;
        $arr['uaccount']=addslashes($_POST['uaccount']);
        $arr['upwd'] = md5($_POST['upwd']);
        $arr['uregtime'] = time();
        $uploadFile = uploadFile("../uploads/face");
        if ($uploadFile && is_array($uploadFile)) {
            $arr['face'] = $uploadFile[0]['name'];
        } else {
            return "添加失败<a href='../admin/addUser.php'>重新添加</a>";
        }
        $arr['utoken']=1;
        $arr['utoken_exptime']=1;
        $arr['udelete']=1;
        connect();
        if (insert("users", $arr)) {
            $mes = "添加成功!<br/><a href='../admin/addUser.php'>继续添加</a>|<a href='../admin/listUser.php'>查看列表</a>";
        } else {
            $filename = "../uploads/" . $uploadFile[0]['name'];
            if (file_exists($filename)) {
                unlink($filename);
            }
            $mes = "添加失败!<br/><a href='../admin/addUser.php'>重新添加</a>|<a href='../admin/listUser.php'>查看列表</a>";
        }
        return $mes;
    }

    /**
     * 删除用户的操作
     * @param int $id
     * @return string
     */
    function delUser($id)
    {
        connect();
        $sql = "select face from users where uid=" . $id;
        $row = fetchOne($sql);
        $face = $row['face'];
        if (file_exists("../uploads/face/" . $face)) {
            unlink("../uploads/face" . $face);
        }
        if (delete("users", "uid={$id}")) {
            $mes = "删除成功!<br/><a href='../admin/listUser.php'>查看用户列表</a>";
        } else {
            $mes = "删除失败!<br/><a href='../admin/listUser.php'>请重新删除</a>";
        }
        return $mes;
    }

    /**
     * 编辑用户的操作
     * @param int $id
     * @return string
     */
    function editUser($id)
    {
        connect();
        $arr = $_POST;
        $arr['upwd'] = md5($_POST['upwd']);
        if (update("users", $arr, "uid={$id}")) {
            $mes = "编辑成功!<br/><a href='../admin/listUser.php'>查看用户列表</a>";
        } else {
            echo showError();
            $mes = "编辑失败!<br/><a href='../admin/listUser.php'>请重新修改</a>";
        }
        return $mes;
    }