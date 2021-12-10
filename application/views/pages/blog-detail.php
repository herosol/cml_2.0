<!DOCTYPE html>
<html lang="en">

<head>
    <title><?=$row->title?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="formal">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="blog">
            <div class="contain">
                <div class="post_blk post_blk_dtl">
                    <a href="<?=get_site_image_src("blogs", $row->image)?>" class="image" data-fancybox="blog">
                        <img src="<?=get_site_image_src("blogs", $row->image)?>" alt="">
                    </a>
                    <div class="txt">
                        <div class="date"><?= format_date($row->created_date,'M d Y h:i:s A'); ?></div>
                        <h4><a><?= $row->title?></a></h4>
                        <?=html_entity_decode($row->description)?>
                    </div>
                </div>
            </div>
        </section>
        <!-- blog -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>