<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Confirmed — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="success">
            <div class="contain text-center">
                <!-- <div class="image"><img src="<?= base_url() ?>assets/images/illustration_terms.svg" alt=""></div> -->
                <h2 class="heading">Order Cancelled</h2>
                <div class="blk">
                    <h3>Your order has been cancelled successfully.</h3>
                </div>
            </div>
        </section>
        <!-- place -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>