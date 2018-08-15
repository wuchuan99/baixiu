<?php
    function conn(){
        $conn = mysqli_connect('localhost','root','root','baixiu');
        return $conn;
    }
    function query($sql){
        $conn = conn();
        $res = mysqli_query($conn,$sql);
        $arr = [];
        while($row = mysqli_fetch_assoc($res)){
            $arr[] = $row;
        }
        return $arr;
    }
    function insert($sql){
        $conn = mysqli_connect('localhost','root','root','baixiu');
        $res = mysqli_query($conn,$sql);
        if($res){
            $result = mysqli_insert_id($conn);
            return $result;
        } else{
            return 0;  
        }
    }
    function update($sql){
        $conn = mysqli_connect('localhost','root','root','baixiu');
        $res = mysqli_query($conn,$sql);
        return $res;
    }



?>