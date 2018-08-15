<?php
    require_once '../../static/comment.php';
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $sl = $_POST['sl'];
    $categoryId = $_POST['categoryId'];
    $x_sql = "select count(*) as count from categories where name = '$name'";
    $x_arr = query($x_sql);
    $count = $x_arr[0]['count'];
    if($count == 0){
        $sql = "update categories set name='$name',slug='$slug',classname='$sl' where id=$categoryId";
        $res = update($sql);
        if($res){
            $result['code'] = 1;
            $result['msg'] = '操作成功';
        } else{
            $result['code'] = 0;
            $result['msg'] = '操作失败';
        }
    } else{
        $result['code'] = 0;
        $result['msg'] = '该分类已存在';
    }
        
    
   
    echo json_encode($result);
?>