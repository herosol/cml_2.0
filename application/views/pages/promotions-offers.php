<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="formal">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="promo">
            <div class="layer" style="background-image: url('<?= base_url('assets/images/shape_05.svg') ?>');">
                <div class="contain">
                    <div class="content text-center">
                        <h2><?= $content['heading'] ?></h2>
                        <p><?= $content['detail'] ?></p>
                        <form action="" method="post" class="frm_promo">
                            <div class="flex_blk">
                                <div class="form_blk">
                                    <input type="text" name="zip_promo" id="zip_promo" class="text_box" placeholder="Enter Postcode">
                                </div>
                                <button type="submit" class="site_btn lg"><?= $content['banner_button_text'] ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="contain text-center">
                <?php if (!empty($promos)) { ?>
                    <h3 class="heading color"><?= $content['second_heading'] ?></h3>
                    <div class="flex_row full_height filter_promos">
                        <?php $count = 0;
                        foreach ($promos as $promo) { ?>
                            <div class="col">
                                <div class="promo_blk">
                                    <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "promos/", $promo->image) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                                    <div class="txt">
                                        <h4><?= $promo->name ?></h4>
                                        <p><?= $promo->tagline ?></p>
                                        <p>This offer will expire on <span class="red-color"><?= $promo->expiry_date ?></span></p>
                                    </div>
                                    <div class="btm">
                                        <div class="price">£<?= $promo->price ?></div>
                                        <div class="btn_blk"><a href="<?= base_url() ?>" class="site_btn md block">Order Now</a></div>
                                        <div class="by small"><strong>Added By: </strong><?= $promo->added_by ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            if (++$count == 5) {
                                break;
                            }
                        } ?>
                    </div>
                <?php } else { ?>
                    <div class="col full">
                        <p>No Promotions Found</p>
                    </div>
                <?php } ?>
            </div>
        </section>
        <!-- promo -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>