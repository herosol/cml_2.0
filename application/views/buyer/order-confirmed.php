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
                <h2 class="heading">Order Confirmed</h2>
                <div class="blk">
                    <h3>Thank You For Your Order</h3>
                    <p>Your Order Number is:</p>
                    <h1><a href="<?= base_url() ?>buyer/order-detail/<?= $order_id ?>">#<?= num_size(doDecode($order_id)) ?></a></h1>
                    <div class="br"></div>
                    <p>If you have any query then contact with <em class="color semi"><?= $vendor->mem_fname . ' ' . $vendor->mem_lname ?></em> on Email <a href="tel:<?= $vendor->mem_email ?>"><?= $vendor->mem_email ?></a> or Phone <a href="mailto:<?= $vendor->mem_company_phone ?>"><?= $vendor->mem_company_phone ?></a>.</p>
                </div>
            </div>
        </section>
        <!-- place -->


    </main>
    <?php $this->load->view('includes/footer'); ?>

</body>



</html>