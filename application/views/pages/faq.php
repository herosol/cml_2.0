<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="common">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="faq" style="background-image: url('<?= base_url('assets/images/shape_02.svg') ?>');">
            <div class="contain">
                <div class="flex_row">
                    <div class="col col1">
                        <div class="image"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image1']) ?>" alt=""></div>
                    </div>
                    <div class="col col2">
                        <?php if (!empty($general_faqs)) { ?>
                            <h5 class="heading"><?= $content['left_heading'] ?></h5>
                            <div class="faq_lst">
                                <?php foreach ($general_faqs as $faq) { ?>
                                    <div class="faq_blk">
                                        <h5><?= $faq->question ?></h5>
                                        <div class="txt">
                                            <p><?= $faq->answer ?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php
                        }
                        if (!empty($most_faqs)) {
                        ?>
                            <h5 class="heading"><?= $content['right_heading'] ?></h5>
                            <div class="faq_lst">
                                <?php foreach ($most_faqs as $faq) { ?>
                                    <div class="faq_blk">
                                        <h5><?= $faq->question ?></h5>
                                        <div class="txt">
                                            <p><?= $faq->answer ?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <form action="<?= base_url('ajax/contact') ?>" class="frmAjax" method="post" id="frmContact">
                    <div class="alertMsg" style="display:none"></div>
                    <h3 class="heading text-center"><?= $content['form_heading'] ?></h3>
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
                    <div class="btn_blk form_btn text-center"><button type="submit" class="site_btn"><i class="spinner hidden"></i><?= $content['form_btn_title'] ?></button></div>
                </form>
            </div>
        </section>
        <!-- faq -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>