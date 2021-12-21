<footer style="background-image: url('<?= base_url('assets/images/shape_03.svg') ?>');">
    <div class="contain">
        <div class="flex_row">
            <div class="col">
                <div class="logo">
                    <a href="<?= base_url() ?>">
                        <img src="<?= getImageSrc(UPLOADIMAGE . 'images/', $site_settings->site_footer_logo) ?>" alt="">
                    </a>
                </div>
                <p>Molestiae nisi consequuntur, provident, tempora numquam vero, rerum aperiam atis asperiores fuga.</p>
                <form action="<?= base_url('newsletter')?>" method="post" autocomplete="off" class="frmAjax" id="newsletterFrm">
                    <div class="alertMsg" style="display:none"></div>
                    <div class="inside">
                        <div class="form_blk">
                            <label for="email">@ Email address</label>
                            <input type="email" name="email" id="email" class="text_box">
                        </div>
                        <div class="btn_blk">
                            <button type="submit" class="site_btn"><i class="spinner hidden"></i>Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col">
                <h4>Business</h4>
                <ul class="lst">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= base_url('about-us') ?>">About us</a></li>
                    <li><a href="<?= base_url('promotions-offers') ?>">Promotions & Offers</a></li>
                    <li><a href="<?= base_url('blogs') ?>">Blog Posts</a></li>
                    <li><a href="<?= base_url('impact') ?>">Impact</a></li>
                </ul>
            </div>
            <div class="col">
                <h4>Quick Links</h4>
                <ul class="lst">
                    <li><a href="<?= base_url('contact') ?>">Contact</a></li>
                    <li><a href="<?= base_url('faq') ?>">FAQ's</a></li>
                </ul>
                <ul class="social_links">
                    <?php if ($site_settings->site_facebook) : ?>
                        <li><a href="<?= makeExternalUrl($site_settings->site_facebook) ?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-facebook.svg" alt=""></a></li>
                    <?php endif ?>
                    <?php if ($site_settings->site_twitter) : ?>
                        <li><a href="<?= makeExternalUrl($site_settings->site_twitter) ?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-twitter.svg" alt=""></a></li>
                    <?php endif ?>
                    <?php if ($site_settings->site_instagram) : ?>
                        <li><a href="<?= makeExternalUrl($site_settings->site_instagram) ?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-instagram.svg" alt=""></a></li>
                    <?php endif ?>
                    <?php if ($site_settings->site_youtube) : ?>
                        <li><a href="<?= makeExternalUrl($site_settings->site_youtube) ?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-youtube.svg" alt=""></a></li>
                    <?php endif ?>
                </ul>
            </div>
            <div class="col">
                <h4>App</h4>
                <p>Coming Soon</p>
                <ul class="playStore">
                    <li><img src="<?= base_url('assets/images/google-play-store.svg') ?>" alt=""></li>
                    <li><img src="<?= base_url('assets/images/apple-app-store.svg') ?>" alt=""></li>
                </ul>
            </div>
        </div>
        <div class="copyright relative">
            <div class="inner">
                <ul class="smLst flex">
                    <li><a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a></li>
                    <li><a href="<?= base_url('terms-conditions') ?>">Terms & Condition</a></li>
                </ul>
                <p><?= $site_settings->site_copyright ?></p>
            </div>
        </div>
    </div>
</footer>
<!-- footer -->


<!-- Main Js -->
<script type="text/javascript" src="<?= base_url('assets/js/main.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/custom-validation.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/custom.js') ?>"></script>