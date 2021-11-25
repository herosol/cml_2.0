<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="formal">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="contact" style="background-image: url('<?= base_url('assets/images/shape_01.svg') ?>');">
            <div class="contain">
                <div class="main_row flex_row">
                    <div class="col col1">
                        <div class="content">
                            <h4 class="heading"><?= $content['heading'] ?></h4>
                            <p><?= $content['detail'] ?></p>
                        </div>
                        <form action="<?= base_url('ajax/contact') ?>" method="POST" class="frmAjax" id="frmContact">
                            <div class="alertMsg" style="display:none"></div>
                            <h4 class="heading"><?= $content['form_heading'] ?></h4>
                            <div class="form_row row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Full Name <sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" name="name" id="name" class="text_box" placeholder="eg: John Wick">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Phone Number <sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" name="phone" id="phone" class="text_box" placeholder="eg: +92300 0000 000">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Subject <sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" name="subject" id="subject" class="text_box" placeholder="eg: Lorem ipsum dolor sit">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Email Address <sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" name="email" id="email" class="text_box" placeholder="eg: sample@gmail.com">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h6>Comments</h6>
                                    <div class="form_blk">
                                        <textarea name="msg" id="msg" class="text_box" placeholder="Type something here"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn">
                                <button type="submit" class="site_btn"><?= $content['btn_title'] ?> <img src="<?= base_url('assets/images/arrow-right-sm.svg') ?>" alt=""></button>
                            </div>
                        </form>
                    </div>
                    <div class="col col2">
                        <h4 class="heading"><?= $content['right_heading'] ?></h4>
                        <div class="card_row flex_row">
                            <div class="col">
                                <div class="card_blk">
                                    <div class="icon"><img src="<?= base_url('assets/images/icon-phone.svg') ?>" alt=""></div>
                                    <div class="txt">
                                        <h6><?= $content['card1_heading'] ?></h6>
                                        <a href="tel:<?=$site_settings->site_phone?>"><?=$site_settings->site_phone?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card_blk">
                                    <div class="icon"><img src="<?= base_url('assets/images/icon-envelope-fill.svg') ?>" alt=""></div>
                                    <div class="txt">
                                        <h6><?= $content['card2_heading'] ?></h6>
                                        <a href="mailto:<?=$site_settings->site_email?>"><?=$site_settings->site_email?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card_blk">
                                    <div class="icon"><img src="<?= base_url('assets/images/icon-map-marker.svg') ?>" alt=""></div>
                                    <div class="txt">
                                        <h6><?= $content['card3_heading'] ?></h6>
                                        <?=$site_settings->site_address?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>