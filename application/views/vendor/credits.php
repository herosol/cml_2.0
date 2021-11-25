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
                <h4 class="subheading">My Credits</h4>
                <div class="flex_row card_row full_height">
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>Today's sales</span>
                                    <div class="price">£<?= price_format($today_sales) ?></div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-money.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>This week's sales</span>
                                    <div class="price">£<?= price_format($week_sales->total) ?></div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-chart.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>This month's sales</span>
                                    <div class="price">£<?= price_format($month_sales->total) ?></div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-chart-calendar.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="br"></div>
                <h4 class="subheading">Latest Orders</h4>
                <div class="job_tbl">
                    <table>
                        <tbody>
                            <?php if (empty($latest_order)) : ?>
                                <tr>
                                    <td>No order yet.</td>
                                </tr>
                            <?php else : ?>
                                <tr class="<?= order_log($latest_order->order_id) ?>">
                                    <td>
                                        <div class="ico_blk">
                                            <div class="icon ico"><img src="<?= base_url('assets/images/users/2.jpg') ?>" alt=""></div>
                                            <div class="txt">
                                                <div class="head">
                                                    <h5>OTP: <?= num_size($latest_order->order_id); ?></h5>
                                                    <span class="badge <?= get_order_status($latest_order->order_status); ?>"><?= $latest_order->order_status ?></span>
                                                </div>
                                                <!-- <?= $latest_order->mem_fname . ' ' . $latest_order->mem_lname ?> -->
                                                <p>
                                                    <?= implode(' • ', $latest_order->services); ?>
                                                </p>
                                            </div>
                                            <a href="<?= base_url() ?>vendor/order-detail/<?= doEncode($latest_order->order_id) ?>" class="more_btn"></a>
                                        </div>
                                    </td>
                                    <td class="qty"><strong>Items</strong> 05</td>
                                    <?php if ($latest_order->pick_and_drop_service == '1') : ?>
                                        <td class="date">
                                            <strong>Collection</strong>
                                            <span><?= date_picker_format_date($latest_order->collection_date, 'D, d M Y', false) ?> - <?= $latest_order->collection_time ?></espan>
                                        </td>
                                        <td class="date">
                                            <strong>Delivery</strong>
                                            <span><?= date_picker_format_date($latest_order->delivery_date, 'D, d M Y', false) ?> - <?= $latest_order->delivery_time ?></span>
                                        </td>
                                    <?php else : ?>
                                        <td class="date">
                                            <strong>Address</strong>
                                            <span>
                                                <?php foreach (explode('@', $latest_order->address) as $val) :
                                                    echo $val;
                                                    echo '<br>';
                                                endforeach; ?>
                                            </span>
                                        </td>
                                        <td class="date">
                                            <strong>Drop Off Date:</strong>
                                            <span><?= date_picker_format_date($latest_order->delivery_date, 'D, d M Y', false) ?> - <?= $latest_order->delivery_time ?></span>
                                        </td>
                                    <?php endif; ?>
                                    <td class="price">£<?= order_total_price($latest_order->order_id) ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- credits -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>