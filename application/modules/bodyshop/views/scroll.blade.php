<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
    <div id="postList">
        @if(count($posts)>0)
        @foreach($posts as $post)
            <div class="list-item">
                <h2>{{ $post['title']; }}</h2>
                <p>{{ $post['content']; }}</p>
            </div>
        @endforeach
            <div class="load-more" lastID="<?php echo $post['id']; ?>" style="display: none;">
                <img src="<?php echo base_url('assets/images/loading.gif'); ?>"/> Loading more posts...
            </div>
        @else
            <p>Post(s) not available.</p>
        @endif
    </div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
    var site_url = "{{site_url()}}"
    //alert($('.load-more').attr('lastID'));
    $(window).scroll(function(){
        var lastID = $('.load-more').attr('lastID');
        
        if(($(window).scrollTop() == $(document).height() - $(window).height()) && (lastID != 0)){
            $.ajax({
                type:'POST',
                url:site_url+'/bodyshop/tablero/loadMoreData',
                data:'id='+lastID,
                beforeSend:function(){
                    $('.load-more').show();
                },
                success:function(html){
                    $('.load-more').remove();
                    $('#postList').append(html);
                }
            });
        }
    });
});
</script>
