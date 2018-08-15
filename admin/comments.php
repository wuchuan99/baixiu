<?php
  require_once 'common/session.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once 'common/navbar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover" id="tt">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody> 
        </tbody>
      </table>
    </div>
  </div>

  <?php include 'common/asides.php' ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/jquery/template-web.js"></script>
  <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script src="../static/assets/vendors/require/require.js" data-main="../static/assets/js/comments.js"></script>
  <script type="text/template" id="temp">
  {{each data}}
  <tr>
    <td class="text-center" width="40"><input type="checkbox"></td>
    <td>{{$value.author}}</td>
    <td width="600">{{$value.content}}</td>
    <td width=>{{$value.title}}</td>
    <td width=>{{$value.created}}</td>
    {{if($value.status == 'held')}}
    <td>待审核</td>
    {{/if}}
    {{if($value.status == 'approved')}}
    <td>准许</td>
    {{/if}}
    {{if($value.status == 'rejected')}}
    <td>拒绝</td>
    {{/if}}
    {{if($value.status == 'trashed')}}
    <td>回收站</td>
    {{/if}}
    <td class="text-center" width="100">
      <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
      <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
    </td>
  </tr>
  {{/each}}
  </script>
  <script>NProgress.done()</script>
</body>
</html>
