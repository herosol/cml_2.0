<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="logon">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="logon">
            <div class="contain">
                <div class="flex_row">
                    <div class="col col1">
                        <!-- <div class="content">
                            <h2 class="heading">Welcome</h2>
                            <p>Debitis rem architecto veniam itaque, atque officia minima obcaecati numquam.</p>
                        </div> -->
                        <div class="fancy_image" style="background-image: url('<?= base_url('assets/images/shape_02.svg') ?>');">
                            <div class="fig"><img src="<?= base_url('assets/images/illustration_logon.svg') ?>" alt=""></div>
                        </div>
                    </div>
                    <div class="col col2">
                        <form action="" method="POST" id="frmSignin" class="frmAjax">
                            <div class="alertMsg" style="display:none"></div>
                            <h2 class="heading">Forgot Password</h2>
                            <p>Don’t worry. Just enter the email address you registered with and we’ll email you instructions to reset your password.</p>
                            <div class="logBlk">
                                <div class="form_row row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h6>Email Address <sup>*</sup></h6>
                                        <div class="form_blk">
                                            <input type="text" name="email" id="email" class="text_box" placeholder="eg: sample@gmail.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="btn_blk form_btn">
                                    <button type="submit" class="site_btn block"><i class="spinner hidden"></i>Reset Password</button>
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