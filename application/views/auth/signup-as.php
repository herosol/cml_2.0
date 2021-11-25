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
                        <form action="" method="POST">
                            <h2 class="heading">Sign up as</h2>
                            <p>Already have an account? <a href="<?= base_url('signin') ?>" class="semi">Sign in</a></p>
                            <div class="logBlk">
                                <div class="btn_blk">
                                    <a href="<?= base_url() ?>buyer/signup" class="site_btn block">Individual</a>
                                </div>
                                <div class="or">or</div>
                                <div class="btn_blk">
                                    <a href="<?= base_url() ?>vendor/signup" class="site_btn block">Vendor</a>
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
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>