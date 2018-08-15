<?php
  require_once 'common/session.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select id="category" name="" class="form-control input-sm">
            <option value="all">所有分类</option>
          </select>
          <select id="status" name="" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">已作废</option>
          </select>
          <input type="button" class="btn btn-default btn-sm" value="筛选" id="btn-sx">
          <!-- <button class="btn btn-default btn-sm">筛选</button> -->
        </form>
        <ul class="pagination pagination-sm pull-right">
          
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
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
  <script>NProgress.done()</script>
  <script type="text/template" id="temp">
    <li data-cate=1><a href="javascript:;">首页</a></li>
    <li {{if(currentPage == 1)}}style="display:none"{{/if}} data-cate={{currentPage-1}}><a href="javascript:;">上一页</a></li>
    <li {{if(currentPage - 2 < 1)}}style="display:none"{{/if}} data-cate={{currentPage-2}}><a href="javascript:;">{{currentPage-2}}</a></li>
    <li {{if(currentPage - 1 < 1)}}style="display:none"{{/if}} data-cate={{currentPage-1}}><a href="javascript:;">{{currentPage-1}}</a></li>
    <li class="active" data-cate={{currentPage}}><a href="javascript:;">{{currentPage}}</a></li>
    <li {{if(currentPage + 1 > page)}}style="display:none"{{/if}} data-cate={{currentPage+1}}><a href="javascript:;">{{currentPage+1}}</a></li>
    <li {{if(currentPage + 2 > page)}}style="display:none"{{/if}} data-cate={{currentPage+2}}><a href="javascript:;">{{currentPage+2}}</a></li>
    <li {{if(currentPage==page)}}style="display:none"{{/if}} data-cate={{currentPage+1}}><a href="javascript:;">下一页</a></li>
    <li data-cate={{page}}><a href="javascript:;">尾页</a></li>
  </script>
  <script>
    $(function(){
      var currentPage = 1;
      var pageSize = 20;
      var categoryId = 'all';
      var status = 'all';
      //发送ajax的函数封装
      function getPosts(currentPage,pageSize,categoryId,status) {
        $.ajax({
          type: "post",
          url: "api/getPost.php",
          data: {
            currentPage :currentPage,
            pageSize:  pageSize,
            categoryId: categoryId,
            status: status
          },
          dataType: 'json',
          success: function(res){
            if(res.code == 1){
              var data = res.data;
              var html = "";
              $(data).each(function(index,value){
                html += `<tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>${value.title}</td>
                <td>${value.nickname}</td>
                <td>${value.name}</td>
                <td class="text-center">${value.created}</td>
                <td class="text-center">${value.status}</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
                </tr>`
              })
              $('tbody').html(html);
              var pageHtml = template('temp',{currentPage:currentPage, page:res.page});
              $('.pagination').html(pageHtml);
            }
          }
        })
      }
      //第一次动态生成文章
      getPosts(currentPage,pageSize,categoryId,status);
      //动态生成分类选项
      $.ajax({
        type: "post",
        url: "api/getCategories.php",
        dataType: "json",
        success: function(res){
          if(res.code == 1){
            var html = "";
            var data = res.data;
            $(data).each(function(index,value){
              html += "<option value="+value.id+">"+value.name+"</option>";
            })
            $('#category').append($(html));
          }
        }
      })
      //分页功能
      $('.pagination').on('click','li',function(){
        currentPage = parseInt($(this).attr('data-cate'));
        getPosts(currentPage,pageSize,categoryId,status);
      })
      //筛选功能
      $('#btn-sx').on('click',function(){
        currentPage = 1;
        categoryId = $('#category').val();
        status = $('#status').val();
        getPosts(currentPage,pageSize,categoryId,status);
      })    
    })
    
  </script>
</body>
</html>
