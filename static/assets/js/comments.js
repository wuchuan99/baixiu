require.config({
    paths: {
        "jquery": "../vendors/jquery/jquery",
        "template": "../vendors/jquery/template-web",
        "bootstrap": "../vendors/bootstrap/js/bootstrap",
        "Pagination": "../vendors/twbs-pagination/jquery.twbsPagination"
    },
    shim: {
        "bootstrap" :{
            deps: ['jquery']
        },
        "Pagination": {
            deps: ['jquery']
        }
    }
})

require(["jquery","template","bootstrap","Pagination"],function($,template,bootstrap,Pagination){
    var currentPage = 1;
    var pageSize = 10;
    function getComments(page,pageSize){
      $.ajax({
        type: 'post',
        url: 'api/getComments.php',
        data: {
          currentPage: page,
          pageSize: pageSize
        },
        dataType: 'json',
        success: function(res){
          if(res.code == 1){
            var html = template('temp',res);
            $('tbody').html(html);
            $('.pagination').twbsPagination({
              totalPages: res.count,
              visiblePages: 5,
              onPageClick: function(even,page){
              currentPage = page;
              getComments(currentPage,pageSize);
              }
            })
          }
        }
      })
    }
    getComments(currentPage,pageSize);
})