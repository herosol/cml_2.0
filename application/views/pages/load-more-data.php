    <?php if(!empty($posts)){
        foreach($posts as $blog){
            $blog = (object)$blog; 
    ?>
            <div class="col">
                <div class="post_blk">
                    <div class="image">
                        <a href="<?= base_url('blog-detail/').doEncode($blog->id).'/'.toSlugUrl($blog->title) ?>">
                            <img data-original="<?=get_site_image_src("blogs/thumbs", $blog->image)?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy>
                        </a>
                    </div>
                    <div class="txt">
                        <div class="date"><?= format_date($blog->created_date,'M d Y h:i:s A'); ?></div>
                        <h4><a href="<?= base_url('blog-detail/').doEncode($blog->id).'/'.toSlugUrl($blog->title) ?>"><?= short_text($blog->title, 80); ?></a></h4>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php if($postNum > $postLimit){ ?>
        <div class="load-more" lastID="<?= $blog->id; ?>" style="display: none;">
            Loading More...
        </div>
    <?php }else{ ?>
        <div class="load-more text-center" lastID="0">
            All blogs are showing.
        </div>
    <?php } ?>    
<?php }else{ ?>    
    <div class="load-more text-center" lastID="0">
            All blogs are showing.
    </div>    
<?php } ?>