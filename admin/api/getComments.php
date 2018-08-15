<?php
    require_once "../../static/comment.php";
    $currentPage = $_POST['currentPage'];
    $pageSize = $_POST['pageSize'];
    $offset = ($currentPage - 1) * $pageSize;
    $sql = "select c.id,c.author,c.created,c.content,c.status,p.title from comments as c
            left join posts as p on p.id=c.post_id
            limit $offset,$pageSize";
    $arr = query($sql);
    $x_sql = "select count(*) as count from comments";
    $x_arr = query($x_sql);
    $count = ceil($x_arr[0]['count'] / $pageSize);
    if($arr){
        $result['code'] = 1;
        $result['msg'] = "获取成功" ;
        $result['data'] = $arr;
        $result['count'] = $count;
    } else{
        $result['code'] = 0;
        $result['msg'] = "获取失败";
    }

    echo json_encode($result);
?>