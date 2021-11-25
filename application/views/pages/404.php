<!DOCTYPE html>
<html lang="en">

<head>
    <title>404 Page not found — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="common">
    <main>


        <section id="oops">
            <div class="table_dv">
                <div class="table_cell">
                    <div class="logo">
                        <a href="<?= site_url() ?>"><img src="<?= getImageSrc(UPLOADIMAGE . 'images/', $site_settings->site_logo) ?>" alt="<?= $site_settings->site_name ?>"></a>
                    </div>
                    <div class="contain text-center">
                        <div class="icon">404</div>
                        <div class="inner">
                            <h4>Page not found</h4>
                            <p>Let's pretend ..... !! You never saw that. Go back to the Homepage to find out more.</p>
                            <div class="btn_blk"><a href="<?= site_url() ?>" class="site_btn">Back to the website</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- oops -->


    </main>
</body>

</html>