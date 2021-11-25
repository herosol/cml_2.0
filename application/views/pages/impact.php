<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="formal">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="terms">
            <div class="contain">
                <h4 class="heading"><?= $content['heading'] ?></h4>
                <div class="ck_editor blk">
                    <?= $details ?>
                </div>
            </div>
        </section>
        <!-- terms -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>