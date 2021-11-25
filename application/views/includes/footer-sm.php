<footer>
    <div class="contain">
        <div class="topBlk">
            <div class="logo">
            <a href="<?= base_url() ?>">
                    <img src="<?= getImageSrc(UPLOADIMAGE.'images/',$site_settings->site_footer_logo) ?>" alt="">
                </a>
            </div>
            <ul class="social">
                <?php if ($site_settings->site_facebook): ?>
                    <li><a href="<?=makeExternalUrl($site_settings->site_facebook)?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-facebook.svg" alt=""></a></li>
                <?php endif ?>
                <?php if ($site_settings->site_twitter): ?>
                    <li><a href="<?=makeExternalUrl($site_settings->site_twitter)?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-twitter.svg" alt=""></a></li>
                <?php endif ?>
                <?php if ($site_settings->site_instagram): ?>
                    <li><a href="<?=makeExternalUrl($site_settings->site_instagram)?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-instagram.svg" alt=""></a></li>
                <?php endif ?>
                <?php if ($site_settings->site_youtube): ?>
                    <li><a href="<?=makeExternalUrl($site_settings->site_youtube)?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-youtube.svg" alt=""></a></li>
                <?php endif ?>
            </ul>
        </div>
        <div class="copyright">
            <p><?= $site_settings->site_copyright ?></p>
            <ul>
                <li>Email: <a href="mailto:<?= $site_settings->site_email ?>"><?= $site_settings->site_email ?></a></li>
            </ul>
        </div>
    </div>
</footer>
<!-- footer -->


<!-- Main Js -->
<script type="text/javascript" src="<?= base_url() ?>assets/js/main.js"></script>
<script type="text/javascript" src="<?= base_url('assets/js/custom-validation.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/custom.js') ?>"></script>