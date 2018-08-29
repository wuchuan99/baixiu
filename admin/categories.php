<?php
  require_once 'common/session.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong> <span class="error"></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form>
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            </div>
            <div class="form-group">
              <label for="sl">类名</label>
              <input id="sl" class="form-control" name="sl" type="text" placeholder="类名"> 
            </div>
            <div class="form-group">
              <input class="btn btn-primary" type="button" value="添加" id="add-btn">
              <input class="btn btn-primary" type="button" value="修改" id="update-btn" style="display: none">
              <input class="btn btn-primary" type="button" value="取消修改" id="cancel-btn" style="display: none">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <!-- <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none" id='delAll'>批量删除</a> -->
            <button class="btn btn-danger btn-sm" id="delAll" style="display: none">批量删除</button>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox" id="inp"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include 'common/asides.php' ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function(){
      $.ajax({
        type: 'get',
        url: 'api/getCategories.php',
        dataType: 'json',
        success: function(res){
          console.log(res);
          if(res.code == 1){
            var data = res.data;
            var html = '';
            $(data).each(function(index,value){
              html += `<tr>
                  <td class="text-center"><input type="checkbox" value=${value.id}></td>
                  <td>${value.name}</td>
                  <td>${value.slug}</td>
                  <td>${value.classname}</td>
                  <td class="text-center">
                    <a href="javascript:;" data-categoryId=${value.id} class="btn btn-info btn-xs edit">编辑</a>
                    <a href="javascript:;" class="btn btn-danger btn-xs del" data-categoryId=${value.id}>删除</a>
                  </td>
                </tr>`
            });
            $('tbody').html(html);
          }
        }
      })
      //新增
      $('#add-btn').on('click',function(){
        var name = $('#name').val();
        var slug = $('#slug').val();
        var sl = $('#sl').val();
        $.ajax({
          type: 'post',
          url: 'api/addCategories.php',
          data: $('form').serialize(),
          dataType: 'json',
          beforeSend: function(){
            if(name.trim() == '' || slug.trim() == '' || sl.trim() == '' ){
              $('.alert').fadeIn(1000).delay(2000).fadeOut(1000);
              $('.error').text('信息不能为空');
              return false;
            }
          },
          success: function(res){
            if(res.code == 1){
              $('.alert').hide();
              $('#name').val('');
              $('#slug').val('');
              $('#sl').val('');
              var data = res.data;
              var html = `<tr>
                <td class="text-center"><input type="checkbox" value=${res.id}></td>
                <td>${name}</td>
                <td>${slug}</td>
                <td>${sl}</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs edit" data-categoryId=${res.id}>编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs del" data-categoryId=${res.id}>删除</a>
                </td>
              </tr>`
              $('tbody').append(html);
            }
            if(res.code == 2){
              $('.alert').fadeIn(1000).delay(2000).fadeOut(1000);
              $('.error').text(res.msg);
            }
          }
        })
      })
      //编辑
      var courrent;
      $('tbody').on('click','.edit',function(){
        courrent = $(this);
        $('#add-btn').hide();
        $('#update-btn').show();
        $('#cancel-btn').show();
        var categoryId = $(this).attr('data-categoryId');
        $('#update-btn').attr('data-categoryId',categoryId);
        var name = $(this).parent().parent().children().eq(1).text();
        var slug = $(this).parent().parent().children().eq(2).text();
        var sl = $(this).parent().parent().children().eq(3).text();
        $('#name').val(name);
        $('#slug').val(slug);
        $('#sl').val(sl);
      })
      //修改
      $('#update-btn').on('click',function(){
        var name = $('#name').val();
        var slug = $('#slug').val();
        var sl = $('#sl').val();
        var categoryId = $(this).attr('data-categoryId');
        $.ajax({
          type: 'post',
          url: 'api/updateCategories.php',
          data: {
            name: name,
            slug: slug,
            sl: sl,
            categoryId: categoryId
          },
          dataType: 'json',
          beforeSend: function(){
            if(name.trim() == '' || slug.trim() == '' || sl.trim() == '' ){
              $('.alert').fadeIn(1000).delay(2000).fadeOut(1000);
              $('.error').text('信息不能为空');
              return false;
            }
          },
          success: function(res){
            if(res.code == 1){
              courrent.parent().parent().children().eq(1).text(name);
              courrent.parent().parent().children().eq(2).text(slug);
              courrent.parent().parent().children().eq(3).text(sl);
              $('#name').val('');
              $('#slug').val('');
              $('#sl').val('');
            }
            if(res.code == 0){
              $('.alert').fadeIn(1000).delay(2000).fadeOut(1000);
              $('.error').text(res.msg);
            }
          }
        })
      })
      //取消修改
      $('#cancel-btn').on('click',function(){
        $('#name').val('');
        $('#slug').val('');
        $('#sl').val('');
        $('#add-btn').show();
        $('#update-btn').hide();
        $('#cancel-btn').hide();

      })
      //删除单一
      $('tbody').on('click','.del',function(){
        var that = $(this);
        var categoryId = $(this).attr('data-categoryId');
        $.ajax({
          type: 'get',
          url: 'api/delCategories.php',
          data: {
            categoryId: categoryId
          },
          dataType: 'json',
          success: function(res){
            if(res.code == 1){
              that.parent().parent().remove();
              gt();
            }
          }
        })
      })
      //删除多项
      $('#delAll').on('click',function(){
        var arr = [];
        $('tbody :checkbox:checked').each(function(index,dom){
          arr.push(dom.value);
        })
        var ids = arr.join();
        $.ajax({
          type: 'get',
          url: 'api/delAll.php',
          data: {ids: ids},
          dataType: 'json',
          success: function(res){
            if(res.code == 1){
              $('tbody :checkbox:checked').each(function(index,dom){
                $(dom).parent().parent().remove();
                $('#delAll').fadeOut(1000);
              })
            }
          }
        })
      })

      $('#inp').on('click',function(){
        var checked = this.checked;
        $('tbody :checkbox').each(function(index,value){
          value.checked = checked;
        })
        if(checked){
          $('#delAll').stop().fadeIn(1000);
        } else{
          $('#delAll').stop().fadeOut(1000);
        }
      })

      $('tbody').on('click',':checkbox',gt);
      function gt(){
        var flag = true;
        var kk = false;
        $('tbody :checkbox').each(function(index,value){
          if(!value.checked){
            flag = false;
            $('#inp').prop('checked',flag);
          } else{
            kk = true;
          }
        })
        if(flag){
          $('#inp')[0].checked = flag;
        }
        if(kk){
          $('#delAll').stop().fadeIn(1000);
        } else{
          $('#delAll').stop().fadeOut(1000);
        }
      }
    })

    
  </script>
</body>
</html>
