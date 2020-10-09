<div id="postList">
    <?php if(!empty($posts)){ foreach($posts as $post){ ?>
        <div class="list-item">
            <h2><?php echo $post['title']; ?></h2>
            <p><?php echo $post['content']; ?></p>
        </div>
    <?php } ?>
    <?php if($postNum > $postLimit){ ?>
        <div class="load-more" lastID="<?php echo $post['id']; ?>" style="display: none;">
            <img src="<?php echo base_url('assets/images/loading.gif'); ?>"/> Loading more posts...
        </div>
    <?php }else{ ?>
        <div class="load-more" lastID="0">
            That's All!
        </div>
    <?php } ?>    
<?php }else{ ?>    
    <div class="load-more" lastID="0">
            That's All!
    </div>    
<?php } ?>