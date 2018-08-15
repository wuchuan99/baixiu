<?php
    $page = $_POST['page'];
    $categoryId = $_POST['categoryId'];
    $size = $_POST['size'];
    $offset = ($page - 1) * $size;
    include_once "static/comment.php";
    $sql = "
    select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,u.nickname,d.name,
    (select count(*) from comments as c where p.id=c.post_id)as count
    from posts as p
    left join users as u on u.id=p.user_id
    left join categories as d on d.id=p.category_id
    where d.id=$categoryId
    order by created desc
    limit $offset,5";
    $arr = query($sql);
    $cont_sql = "select count(*) as pageCount from posts where category_id=$categoryId";
    $cont_arr = query($cont_sql);
    $result = array(
        "code"=>0,
        "msg"=>"加载成功"
    );
    if($arr){
        $result['code'] = 1;
        $result['msg'] = '加载失败';
        $result['data'] = $arr;
        $result['pageCount'] = $cont_arr[0]['pageCount'];
    }
    echo json_encode($result);
?>