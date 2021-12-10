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
                <div class="flex_row flex">
                    <div class="col col1">
                        <!-- <div class="content">
                            <h2 class="heading"><?= $content['heading'] ?></h2>
                            <p><?= $content['detail'] ?></p>
                        </div> -->
                        <div class="fancy_image" style="background-image: url('<?= base_url('assets/images/shape_02.svg') ?>');">
                            <div class="fig"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image1']) ?>" alt=""></div>
                        </div>
                    </div>
                    <div class="col col2">
                        <form action="" method="POST" id="frmSignup" class="frmAjax" autocomplete="off">
                            <div class="alertMsg" style="display:none"></div>
                            <h2 class="heading"> <?= $as == 'Vendor' ?  $content['form_heading2'] :  $content['form_heading1']; ?></h2>
                            <p>Already have an account? <a href="<?= base_url('signin') ?>" class="semi">Sign in</a></p>
                            <div class="social_btn">
                                <button type="button" onclick="location.href = '<?= site_url('google-login'); ?>'" class="site_btn gm_btn"><img src="<?= base_url('assets/images/google-icon.svg') ?>" alt=""> Sign up with google</button>
                                <button type="button" onclick="location.href = '<?= site_url('facebook-login'); ?>'" class="site_btn fb_btn"><img src="<?= base_url('assets/images/facebook-icon.svg') ?>" alt=""> Sign up with facebook</button>
                            </div>
                            <div class="or">or</div>
                            <div class="logBlk">
                                <div class="form_row row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h6>Your Name <sup>*</sup></h6>
                                        <div class="form_row row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <div class="form_blk">
                                                    <input type="text" name="mem_fname" id="mem_fname" class="text_box" placeholder="eg: John">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <div class="form_blk">
                                                    <input type="text" name="mem_lname" id="mem_lname" class="text_box" placeholder="eg: Wick">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <h6>Email Address <sup>*</sup></h6>
                                        <div class="form_blk">
                                            <input type="text" name="mem_email" id="mem_email" class="text_box" placeholder="eg: sample@gmail.com">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <h6>Phone Number <sup>*</sup></h6>
                                        <div class="form_blk">
                                            <input type="text" name="mem_phone" id="mem_phone" class="text_box" placeholder="+44 0000 000000">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <h6>Password <sup>*</sup></h6>
                                        <div class="form_blk pass_blk">
                                            <input type="password" name="password" id="password" class="text_box pr-password" placeholder="eg: PassLogin%7">
                                            <i class="icon-eye" id="eye"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <h6>Confirm Password <sup>*</sup></h6>
                                        <div class="form_blk pass_blk">
                                            <input type="password" name="cpassword" id="cpassword" class="text_box" placeholder="eg: PassLogin%7">
                                            <i class="icon-eye" id="eye"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form_blk">
                                            <div class="lbl_btn">
                                                <input type="checkbox" name="confirm" id="confirm">
                                                <label for="confirm">
                                                    I agree to CML's
                                                    <a target="_blank" href="<?= base_url() ?>terms-conditions">Terms & Conditions</a>
                                                    and
                                                    <a target="_blank" href="<?= base_url() ?>privacy-policy">Privacy Policy.</a>
                                                </label>
                                                <span id="confirm-error" class="validation-error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn_blk form_btn">
                                    <button type="submit" class="site_btn block"><i class="spinner hidden"></i>Sign up</button>
                                </div>
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