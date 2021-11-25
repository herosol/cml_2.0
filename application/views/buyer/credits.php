<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Credits — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="credits">
            <div class="contain">
                <?php $count = count($orders); ?>
                <h4 class="subheading">My Account Credit</h4>
                <div class="blk credit_blk">
                    <div class="icon"><img src="<?= base_url('assets/images/vector-deal.svg') ?>" alt=""></div>
                    <div class="txt">
                        <h5 class="color"><?= ($count == '9') ? 'Congratulations!' :  9 - $count . ' More Orders to go' ?></h5>
                        <h3>You will have a <strong class="color"><?= $site_settings->site_buyer_credit_percentage ?>% off </strong> on every 10th order.</h3>
                        <?php if ($count == '9') { ?>
                            <h3>Your <strong class="color"><?= $site_settings->site_buyer_credit_percentage ?>% off </strong> automatically be applied at checkout.</h3>
                        <?php } ?>
                    </div>
                </div>
                <h4 class="subheading">My Orders</h4>
                <?php if (!empty($orders)) { ?>
                    <div class="flex_row order_row full_height">
                        <?php foreach ($orders as $order) { ?>
                            <div class="col">
                                <div class="mini_job_blk">
                                    <h4 class="color">OTP: <?= num_size($order->order_id) ?></h4>
                                    <ul>
                                        <?php if ($order->pick_and_drop_service == '1') { ?>
                                            <li>
                                                <strong>Collection</strong>
                                                <span><?= date_picker_format_date($order->collection_date, 'D, d M Y', false) ?> - <?= $order->collection_time ?></span>
                                            </li>
                                            <li>
                                                <strong>Delivery</strong>
                                                <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                            </li>
                                        <?php } else if ($order->pick_and_drop_service == '0') { ?>
                                            <li>
                                                <strong>Drop Off</strong>
                                                <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <p class="price">You Paid: <strong class="color">£<?= order_total_price($order->order_id) ?></strong></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="blk">
                        <h2 class="heading">No Orders Yet</h2>
                    </div>
                <?php } ?>
            </div>
        </section>
        <!-- credits -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>