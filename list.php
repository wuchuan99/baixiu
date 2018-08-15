<?php
  include_once "static/comment.php";
  $categoryId = $_GET['categoryId'];
  $sql = "
  select p.id,p.title,p.feature,p.created,p.content,p.views,p.likes,u.nickname,d.name,
  (select count(*) from comments as c where p.id=c.post_id)as count
  from posts as p
  left join users as u on u.id=p.user_id
  left join categories as d on d.id=p.category_id
  where d.id=$categoryId
  order by created desc
  limit 0,5";
  $arr = query($sql);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
  <?php include_once 'public.php'?>
    <div class="content">
      <div class="panel new">
        <h3><?= $arr[0]['name']?></h3>
        <?php foreach($arr as $value): ?>
        <div class="entry">
          <div class="head">
            <span class="sort"><?=$value['name'] ?></span>
            <a href="detail.php?postId=<?= $value['id']?>"><?= $value['title']?></a>
          </div>
          <div class="main">
            <p class="info"><?= $value['nickname']?> 发表于 <?= $value['created']?></p>
            <p class="brief"><?= $value['content']?></p>
            <p class="extra">
              <span class="reading">阅读(<?= $value['views']?>)</span>
              <span class="comment">评论(<?= $value['count']?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?= $value['likes']?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?= $value['name']?></span>
              </a>
            </p>
            <a href="detail.php?postId=<?=$value['id']?>" class="thumb">
              <img src="<?= $value['feature']?>" alt="">
            </a>
          </div>
        </div>
        <?php endforeach;?>
        <div class="loadmore">
          <span class="btn">加载更多</span>
        </div>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="static/assets/vendors/jquery/jquery.js"></script>
  <script>
      $(function(){
        var page = 1;
        $('.loadmore').on('click', function(){
          page++;
          $.ajax({
            type: "post",
            url: "api.php",
            data: {
              page: page,
              categoryId: location.search.split("=")[1],
              size: 100
            },
            dataType: "json",
            success: function(info){
              if(info.code == 1){
                var data = info.data;
                html = "";
                data.forEach(function(value,index){
                html +=  `<div class="entry">
                  <div class="head">
                  <span class="sort">${value['name']}</span>
                  <a href="detail.php?postId=${value['id']}">${value['title']}</a>
                  </div>
                  <div class="main">
                  <p class="info">${value['nickname']} 发表于 ${value['created']}</p>
                  <p class="brief">${value['content']}</p>
                  <p class="extra">
                    <span class="reading">阅读(${value['count']})</span>
                    <span class="comment">评论(${value['views']})</span>
                    <a href="javascript:;" class="like">
                      <i class="fa fa-thumbs-up"></i>
                      <span>赞(${value['likes']})</span>
                    </a>
                    <a href="javascript:;" class="tags">
                      分类：<span>${value['name']}</span>
                    </a>
                  </p>
                  <a href="detail.php?postId=${value['id']}" class="thumb">
                    <img src="${value['feature']}" alt="">
                  </a>
                  </div>
                  </div>`
                }); 
                $(html).insertBefore($('.loadmore'));
                var pageCount = info.pageCount;
                var pages = Math.ceil(pageCount / 100);
                if(page == pages){
                 $('.loadmore').hide();
                }
              }
            }
          })
        })
      })
  </script>
</body>
</html>