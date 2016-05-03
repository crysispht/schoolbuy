<?php
//require_once '../include.php';
//$sql="select * from imooc_admin";
//$totalRows=getResultNum($sql);
////echo $totalRows;
//$pageSize=2;
////得到总页码数
//$totalPage=ceil($totalRows/$pageSize);
//$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
//if($page<1||$page==null||!is_numeric($page)){
//	$page=1;
//}
//if($page>=$totalPage)$page=$totalPage;
//$offset=($page-1)*$pageSize;
//$sql="select * from imooc_admin limit {$offset},{$pageSize}";
////echo $sql;
//$rows=fetchAll($sql);
////print_r($rows);
//foreach($rows as $row){
//	echo "编号：".$row['id'],"<br/>";
//	echo "管理员的名称:".$row['username'],"<hr/>";
//}
//echo showPage($page,$totalPage);
//echo "<hr/>";
//echo showPage($page,$totalPage,"cid=5&pid=6");
    function showPage($page, $totalPage, $where = null, $sep = "&nbsp;")
    {
//        $where = ($where == null) ? null : "&" . $where;
//        $url = $_SERVER ['PHP_SELF'];
//        $index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
//        $last = ($page == $totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
//        $prevPage = ($page >= 1) ? $page - 1 : 1;
//        $nextPage = ($page >= $totalPage) ? $totalPage : $page + 1;
//        $prev = ($page == 1) ? "上一页" : "<a href='{$url}?page={$prevPage}{$where}'>上一页</a>";
//        $next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page={$nextPage}{$where}'>下一页</a>";
//        $str = "总共{$totalPage}页/当前是第{$page}页";
//        for ($i = 1; $i <= $totalPage; $i++) {
//            //当前页无连接
//            if ($page == $i) {
//                $page .= "[{$i}]";
//            } else {
//                $page .= "<a href='{$url}?page={$i}{$where}'>[{$i}]</a>";
//            }
//        }
//        $pageStr = $str . $sep . $index . $sep . $prev . $sep . $page . $sep . $next . $sep . $last;

        global $page;
        if ($page < 1) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }
        //$where = ($where == null) ? null : "&" . $where;
        $url = $_SERVER ['PHP_SELF'];
        $index = ($page == 1) ? 1 : $page;
        $last = $totalPage;
        $prevPage = ($page >= 1) ? $page - 1 : 1;
        $nextPage = ($page >= $totalPage) ? $totalPage : $page + 1;
        //$prev = ($page == 1) ? "上一页" : "<a href='{$url}?page={$prevPage}{$where}'>上一页</a>";
        //$next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page={$nextPage}{$where}'>下一页</a>";
        $pageArr = array('url' => $url, 'index' => $index, 'last' => $last, 'prevPage' => $prevPage, 'nextPage' => $nextPage, 'page' => $page);
        return $pageArr;
    }


    function showPage2($page, $totalPage, $where = null, $sep = "&nbsp;")
    {
        global $page;
        if ($page < 1) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }
        $url = $_SERVER ['PHP_SELF'];
        $index = ($page == 1) ? 1 : $page;
        $last = $totalPage;
        $prevPage = ($page >= 1) ? $page - 1 : 1;
        $nextPage = ($page >= $totalPage) ? $totalPage : $page + 1;
        $pageStr = '';
        $pageStr .= "<li class='disabled'><a href='{$url}?{$where}page=1' aria-label='Previous'><span aria-hidden='true'>首页</span></a></li>";
        if ($page > 1) {
            $pageStr .= "<li><a href='${url}?{$where}page={$prevPage}' aria-label='Previous'><span aria-hidden='true'>«</span></a></li>";
        }
        if ($page > 4) {
            $pageStr .= "<li><a href='{$url}?{$where}page=1'>1...</a></li>";
        }
        for ($i = 2; $i <= $totalPage; $i++) {
            if ($totalPage < 6) {
                $pageStr .= "<li><a href='{$url}?{$where}page={$i}'>{$i} <span class='sr-only'></span></a></li>";
            } else {

                if ($page == $i) {
                    $pageStr .= "<li class='active disabled'><a disabled='disalbed'>{$i} <span class='sr-only'>(current)</span></a></li>";
                    continue;
                }
                if ($page < 4 || $page > $totalPage - 3) {
                    $pageStr .= "<li><a href='{$url}?{$where}page={$i}'>{$i} <span class='sr-only'></span></a></li>";
                } else {

                }
            }
        }
        $pageStr .= "<li class='disabled'><a href='{$url}?{$where}page={$totalPage}' aria-label='Previous'><span aria-hidden='true'>尾页</span></a></li>";
        return $pageStr;
    }

    function getPageHtml($page, $pages, $url)
    {
        //最多显示多少个页码
        $_pageNum = 5;
        //当前页面小于1 则为1
        $page = $page < 1 ? 1 : $page;
        //当前页大于总页数 则为总页数
        $page = $page > $pages ? $pages : $page;
        //页数小当前页 则为当前页
        $pages = $pages < $page ? $page : $pages;

        //计算开始页
        $_start = $page - floor($_pageNum / 2);
        $_start = $_start < 1 ? 1 : $_start;
        //计算结束页
        $_end = $page + floor($_pageNum / 2);
        $_end = $_end > $pages ? $pages : $_end;

        //当前显示的页码个数不够最大页码数，在进行左右调整
        $_curPageNum = $_end - $_start + 1;
        //左调整
        if ($_curPageNum < $_pageNum && $_start > 1) {
            $_start = $_start - ($_pageNum - $_curPageNum);
            $_start = $_start < 1 ? 1 : $_start;
            $_curPageNum = $_end - $_start + 1;
        }
        //右边调整
        if ($_curPageNum < $_pageNum && $_end < $pages) {
            $_end = $_end + ($_pageNum - $_curPageNum);
            $_end = $_end > $pages ? $pages : $_end;
        }

        $_pageHtml = '<ul class="pagination">';
        /*if($_start == 1){
         $_pageHtml .= '<li><a title="第一页">«</a></li>';
        }else{
         $_pageHtml .= '<li><a  title="第一页" href="'.$url.'&page=1">«</a></li>';
        }*/
        if ($page > 1) {
            $_pageHtml .= '<li><a  title="上一页" href="' . $url . '&page=' . ($page - 1) . '">«</a></li>';
        }
        for ($i = $_start; $i <= $_end; $i++) {
            if ($i == $page) {
                $_pageHtml .= '<li class="active"><a>' . $i . '</a></li>';
            } else {
                $_pageHtml .= '<li><a href="' . $url . '&page=' . $i . '">' . $i . '</a></li>';
            }
        }
        /*if($_end == $pages){
         $_pageHtml .= '<li><a title="最后一页">»</a></li>';
        }else{
         $_pageHtml .= '<li><a  title="最后一页" href="'.$url.'&page='.$pages.'">»</a></li>';
        }*/
        if ($page < $_end) {
            $_pageHtml .= '<li><a  title="下一页" href="' . $url . '&page=' . ($page + 1) . '">»</a></li>';
        }
        $_pageHtml .= '</ul>';
        echo $_pageHtml;
    }
    /**
     * 解析条件
     * @param $where
     * @return string
     */
    function parseSearchWhere($where)
    {
        $whereStr = '';
        if (is_array($where)) {
            foreach ($where as $key => $val) {
                if (!empty($val)) {
                    $whereStr .= $key . "=" . $val . '&';
                }
            }
        } elseif (is_string($where) && !empty($where)) {
            $whereStr = $where;
        }
        return empty($whereStr) ? '' : $whereStr;
    }


    /**
     * 显示自定义样式翻页
     * @param $page
     * @param $totalPage
     * @param null $where
     * @param string $sep
     * @return string
     */
    function showPage3($page, $totalPage, $where = null, $sep = "&nbsp;")
    {
        $where = ($where == null) ? null : "&" . $where;
        $url = $_SERVER ['PHP_SELF'];
        $index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
        $last = ($page == $totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
        $prevPage = ($page >= 1) ? $page - 1 : 1;
        $nextPage = ($page >= $totalPage) ? $totalPage : $page + 1;
        $prev = ($page == 1) ? "上一页" : "<a href='{$url}?page={$prevPage}{$where}'>上一页</a>";
        $next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page={$nextPage}{$where}'>下一页</a>";
        $str = "总共{$totalPage}页/当前是第{$page}页";
        for ($i = 1; $i <= $totalPage; $i++) {
            //当前页无连接
            if ($page == $i) {
                $page .= "[{$i}]";
            } else {
                $page .= "<a href='{$url}?page={$i}{$where}'>[{$i}]</a>";
            }
        }
        $pageStr = $str . $sep . $index . $sep . $prev . $sep . $page . $sep . $next . $sep . $last;
        return $pageStr;
    }
