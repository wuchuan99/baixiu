<?php
    require_once '../../static/comment.php';
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $sl = $_POST['sl'];
    $sql = "select count(*) as count from categories where name = '$name'";
    $arr = query($sql);
    $count = $arr[0]['count'];
    $result = array(
        "code" => 0,
        "msg" => "操作失败"
    );
    if($count > 0){
        $result['code'] = 2;
        $result['msg'] = "该分类已存在" ;
    } else if($count == 0){
        $addSql = "insert into categories values(null,'$slug','$name','$sl')";
        $addArr = insert($addSql);
        if($addArr > 0){
            $result['code'] = 1;
            $result['msg'] = "操作成功"; 
            $result['id'] = $addArr;
        } else{
            $result['msg'] = "插入数据失败"; 
        }      
    }
    echo json_encode($result);
?>