<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password — <?= $site_settings->site_name ?></title>
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
                        <form action="" method="post" id="frmReset" class="frmAjax">
                            <div class="alertMsg" style="display:none"></div>
                            <h2 class="heading">Reset Password</h2>
                            <p>Enter a new password for your account.</p>
                            <div class="logBlk">
                                <div class="form_row row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <h6>Password <sup>*</sup></h6>
                                        <div class="form_blk pass_blk">
                                            <input type="password" name="pswd" id="password" class="text_box pr-password" placeholder="eg: PassLogin%7">
                                            <i class="icon-eye" id="eye"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <h6>Confirm Password <sup>*</sup></h6>
                                        <div class="form_blk pass_blk">
                                            <input type="password" name="cpswd" id="cpassword" class="text_box" placeholder="eg: PassLogin%7">
                                            <i class="icon-eye" id="eye"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn_blk form_btn">
                                    <button type="submit" class="site_btn block"><i class="spinner hidden"></i>Change my Password</button>
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