<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="formal">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="about">
            <div class="contain">
                <div class="flex_row">
                    <div class="col col1">
                        <div class="fancy_image" style="background-image: url('<?= base_url('assets/images/shape_02.svg') ?>');">
                            <div class="fig"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image1']) ?>" src="" alt="" lazy></div>
                        </div>
                    </div>
                    <div class="col col2">
                        <div class="content">
                            <h1 class="heading"><?= $content['section1_heading'] ?></h1>
                            <?= $content['section1_desc'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about -->


        <section id="provide">
            <div class="contain text-center">
                <div class="content text-left">
                    <h1 class="heading"><?= $content['section2_heading'] ?></h1>
                    <div class="txt">
                        <p><?= $content['section2_desc'] ?></p>
                    </div>
                </div>
                <div class="flex_row full_height">
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image10']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                                <div class="txt">
                                    <h4><?= $content['deal1_heading'] ?></h4>
                                    <p><?= $content['deal1_details'] ?></p>
                                </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image11']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                            <div class="txt">
                                <h4><?= $content['deal2_heading'] ?></h4>
                                <p><?= $content['deal2_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image12']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                            <div class="txt">
                                <h4><?= $content['deal3_heading'] ?></h4>
                                <p><?= $content['deal3_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image13']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                            <div class="txt">
                                <h4><?= $content['deal4_heading'] ?></h4>
                                <p><?= $content['deal4_details'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- provide -->


        <section id="posts">
            <div class="contain">
                <h1 class="heading text-center"><?= $content['last_heading'] ?></em></h1>
                <div class="flex_row">
                <?php foreach($blogs as $blog): ?>
                    <div class="col">
                        <div class="post_blk">
                            <div class="image">
                                <a href="<?= base_url('blog-detail/').doEncode($blog->id).'/'.toSlugUrl($blog->title) ?>">
                                    <img data-original="<?=get_site_image_src("blogs/thumbs", $blog->image)?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy>
                                </a>
                            </div>
                            <div class="txt">
                                <div class="date"><?= format_date($blog->created_date,'M d Y h:i:s A'); ?></div>
                                <h4><a href="<?= base_url('blog-detail/').doEncode($blog->id).'/'.toSlugUrl($blog->title) ?>"><?= short_text($blog->title, 60); ?></a></h4>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- posts -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>