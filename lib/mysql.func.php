<?php
    /**
     * 连接数据库
     * @return resource
     */


    function connect()
    {
        $link = @mysql_connect(DB_HOST, DB_USER, DB_PWD) or die("数据库连接失败Error:" . @mysql_errno() . ":" . @mysql_error());
        mysql_query('set names utf8',$link);
        @mysql_set_charset(DB_CHARSET);
        @mysql_select_db(DB_NAME) or die("指定数据库打开失败");
        return $link;
    }

    /**
     * 完成记录插入的操作
     * @param string $table
     * @param array $array
     * @return number
     */
    function insert($table, $array)
    {
        $keys = join(",", array_keys($array));
        $vals = "'" . join("','", array_values($array)) . "'";
        $sql = "insert {$table}($keys) values({$vals})";
        mysql_query($sql);
        return mysql_insert_id();
    }

//update imooc_admin set username='king' where id=1
    /**
     * 记录的更新操作
     * @param string $table
     * @param array $array
     * @param string $where
     * @return number
     */
    function update($table, $array, $where = null)
    {
        $str='';
        foreach ($array as $key => $val) {
            if ($val == null) {
               continue;
            }
            $str .= $key . "='" . $val . "' ,";
        }
        $str=rtrim($str,',');
        $sql = "update {$table} set {$str} " . ($where == null ? null : " where " . $where);
        $result = mysql_query($sql);
        //var_dump($result);
        //var_dump(mysql_affected_rows());exit;
        if ($result) {
            return mysql_affected_rows();
        } else {
            return false;
        }
    }

    /**
     *    删除记录
     * @param string $table
     * @param string $where
     * @return number
     */
    function delete($table, $where = null)
    {
        $where = $where == null ? null : " where " . $where;
        $sql = "delete from {$table} {$where}";
        mysql_query($sql);
        return mysql_affected_rows();
    }

    /**
     *得到指定一条记录
     * @param string $sql
     * @param string $result_type
     * @return multitype:
     */
    function fetchOne($sql)
    {
        $mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        $row = $mysql->getOne($sql);
        return $row;
    }


    /**
     * 得到结果集中所有记录 ...
     * @param string $sql
     * @param string $result_type
     * @return multitype:
     */
    function fetchAll($sql, $result_type = MYSQL_ASSOC)
    {
        $result = mysql_query($sql);
        $rows = array();
        while (@$row = mysql_fetch_array($result, $result_type)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * 得到结果集中的记录条数
     * @param string $sql
     * @return number
     */
    function getResultNum($sql)
    {
        $result = mysql_query($sql);
        return mysql_num_rows($result);
    }

    /**
     * 得到上一步插入记录的ID号
     * @return number
     */
    function getInsertId()
    {
        //$mysql = new ms_new_mysql(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        return mysql_insert_id();
    }


    function showError()
    {
        return mysql_errno().":".mysql_error();
    }

    function dbclose(){
        mysql_close();
    }