<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blog Posts — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="formal">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="blog">
            <div class="contain">
                <h4 class="heading">Blog Posts</h4>
                <div class="flex_row" id="blogsList">
                <?php foreach($blogs as $blog): $blog = (object)$blog; ?>
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
                    <?php endforeach; ?>
                </div>
                <div class="load-more" lastID="<?= $blog->id; ?>" style="display: none;">
                    Loading More...
                </div>
            </div>
        </section>
        <!-- blog -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $(window).scroll(function(){
                var lastID = $('.load-more').attr('lastID');
                if(Math.ceil($(window).scrollTop()) == Math.ceil(($(document).height() - $(window).height()))) {
                    $.ajax({
                        type:'POST',
                        url:'<?php echo base_url('blogs/load_more_data'); ?>',
                        data:'id='+lastID,
                        beforeSend:function(){
                            $('.load-more').show();
                        },
                        success:function(html){
                            setTimeout(() => {
                                $('.load-more').remove();
                                $('#blogsList').append(html);
                                $("img[lazy]").lazyload();
                            }, 500);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>