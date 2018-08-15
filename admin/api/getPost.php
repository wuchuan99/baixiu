<?php
    require_once "../../static/comment.php";
    $categoryId = $_POST['categoryId'];
    $status = $_POST['status'];
    $currentPage = $_POST['currentPage'];
    $pageSize = $_POST['pageSize'];
    $offset = ($currentPage - 1) * $pageSize;
    $where = '1=1 ';
    if($categoryId != 'all'){
        $where .= " and p.category_id=$categoryId ";
    }
    if($status != 'all'){
        $where .= " and p.status='$status'";
    } 
    $sql = "select p.id,p.title,p.created,p.status,u.nickname,c.name from posts p
            left join users as u on u.id=p.user_id
            left join categories as c on c.id=p.category_id
            where $where
            limit $offset,$pageSize";
    $arr = query($sql);
    $x_sql = "select count(*) as count from posts as p where $where";
    $x_arr = query($x_sql)[0]['count'];
    $page = ceil($x_arr / $pageSize);
    if($arr){
        $result['code'] = 1;
        $result['msg'] = "获取成功" ;
        $result['data'] = $arr;
        $result['page'] = $page;
    } else{
        $result['code'] = 0;
        $result['msg'] = "获取失败";
    }

    echo json_encode($result);

?>