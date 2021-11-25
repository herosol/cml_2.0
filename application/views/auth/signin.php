<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="logon">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="logon">
            <div class="contain">
                <div class="flex_row">
                    <div class="col col1">
                        <div class="fancy_image" style="background-image: url('<?= base_url('assets/images/shape_02.svg') ?>');">
                            <div class="fig"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image1']) ?>" alt=""></div>
                        </div>
                    </div>
                    <div class="col col2">
                        <form action="" method="POST" id="frmSignin" class="frmAjax" autocomplete="off">
                            <div class="alertMsg" style="display:none"></div>
                            <h2 class="heading"><?= $content['form_heading'] ?></h2>
                            <p>Don’t have an account? <a href="<?= base_url('signup-as') ?>" class="semi">Sign up</a></p>
                            <div class="social_btn">
                                <button type="button" class="site_btn gm_btn"><img src="<?= base_url('assets/images/google-icon.svg') ?>" alt=""> Sign in with google</button>
                                <button type="button" class="site_btn fb_btn"><img src="<?= base_url('assets/images/facebook-icon.svg') ?>" alt=""> Sign in with facebook</button>
                            </div>
                            <div class="or">or</div>
                            <div class="logBlk">
                                <div class="form_row row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h6>Email Address <sup>*</sup></h6>
                                        <div class="form_blk">
                                            <input type="text" name="email" id="email" class="text_box" placeholder="eg: sample@gmail.com">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h6>Password <sup>*</sup></h6>
                                        <div class="form_blk pass_blk">
                                            <input type="password" name="password" id="password" class="text_box" placeholder="eg: PassLogin%7" autocomplete="new-password">
                                            <i class="icon-eye" id="eye"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form_blk">
                                            <div class="lbl_btn">
                                                <input type="checkbox" name="remember" id="remember">
                                                <label for="remember">Remember me</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn">
                                <button type="submit" class="site_btn block"><i class="spinner hidden"></i><?= $content['btn_title'] ?></button>
                            </div>
                            <div class="forgot text-center">
                                <a href="<?= base_url() ?>forgot-password" id="pass">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- logon -->


        <!-- Main Js -->
        <script type="text/javascript" src="<?= base_url() ?>assets/js/main.js"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/custom-validation.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/custom.js') ?>"></script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>