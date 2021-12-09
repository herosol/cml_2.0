<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Orders — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="orders">
            <div class="contain">
                <div class="top_head">
                    <h4>My Orders</h4>
                    <ul class="tab_list flex">
                        <li class="active"><a data-toggle="tab" href="#All">All</a></li>
                        <li><a data-toggle="tab" href="#Delivered">Delivered</a></li>
                        <li><a data-toggle="tab" href="#Cancelled">Cancelled</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="All" class="job_tbl tab-pane fade in active">
                        <table>
                            <tbody>
                                <?php if (!empty($orders)) { ?>
                                    <?php foreach ($orders as $order) {
                                        $services = $order->services;
                                    ?>
                                            <tr class="<?= order_log($order->order_id) ?>">
                                                <td>
                                                    <div class="ico_blk">
                                                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                                                        <div class="txt">
                                                            <div class="head">
                                                                <h5>OTP: <?= num_size($order->order_id) ?></h5>
                                                                <span class="badge <?= get_order_status($order->order_status); ?>"><?= $order->order_status ?></span>
                                                            </div>
                                                            <p>
                                                                <?php
                                                                $count = 0;
                                                                foreach ($services as $service) {
                                                                ?>
                                                                    <span><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></span>
                                                                <?php
                                                                    if (++$count == 4) {
                                                                        break;
                                                                    }
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <a href="<?= base_url('buyer/order-detail/') . doEncode($order->order_id) ?>" class="more_btn"></a>
                                                    </div>
                                                </td>
                                                <td class="qty"><strong>Items:</strong> <?=count($services)?></td>
                                                <?php if ($order->pick_and_drop_service == '1') : ?>
                                                    <td class="date">
                                                        <strong>Collection</strong>
                                                        <span><?= date_picker_format_date($order->collection_date, 'D, d M Y', false) ?> - <?= $order->collection_time ?></span>
                                                    </td>
                                                    <td class="date">
                                                        <strong>Delivery</strong>
                                                        <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                                    </td>
                                                <?php else : ?>
                                                    <td class="date">
                                                        <strong>Address</strong>
                                                        <span>
                                                            <?php foreach (explode('@', $order->address) as $val) : echo $val;
                                                                echo '<br>';
                                                            endforeach; ?>
                                                        </span>
                                                    </td>
                                                    <td class="date">
                                                        <strong>Drop off</strong>
                                                        <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                                    </td>
                                                <?php endif; ?>
                                                <td class="price">£<?= order_total_price($order->order_id) ?></td>
                                            </tr>
                                    <?php } ?>
                                <?php
                                } 
                                else
                                {
                                ?>
                                    <tr>
                                        <td>No order yet.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="Delivered" class="job_tbl tab-pane fade">
                    <table>
                            <tbody>
                                <?php if (!empty($delivered_orders)) { ?>
                                    <?php foreach ($delivered_orders as $order) {
                                        $services = $order->services;
                                    ?>
                                            <tr class="<?= order_log($order->order_id) ?>">
                                                <td>
                                                    <div class="ico_blk">
                                                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                                                        <div class="txt">
                                                            <div class="head">
                                                                <h5>OTP: <?= num_size($order->order_id) ?></h5>
                                                                <span class="badge <?= get_order_status($order->order_status); ?>"><?= $order->order_status ?></span>
                                                            </div>
                                                            <p>
                                                                <?php
                                                                $count = 0;
                                                                foreach ($services as $service) {
                                                                ?>
                                                                    <span><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></span>
                                                                <?php
                                                                    if (++$count == 4) {
                                                                        break;
                                                                    }
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <a href="<?= base_url('buyer/order-detail/') . doEncode($order->order_id) ?>" class="more_btn"></a>
                                                    </div>
                                                </td>
                                                <td class="qty"><strong>Items:</strong> <?=count($services)?></td>
                                                <?php if ($order->pick_and_drop_service == '1') : ?>
                                                    <td class="date">
                                                        <strong>Collection</strong>
                                                        <span><?= date_picker_format_date($order->collection_date, 'D, d M Y', false) ?> - <?= $order->collection_time ?></span>
                                                    </td>
                                                    <td class="date">
                                                        <strong>Delivery</strong>
                                                        <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                                    </td>
                                                <?php else : ?>
                                                    <td class="date">
                                                        <strong>Address</strong>
                                                        <span>
                                                            <?php foreach (explode('@', $order->address) as $val) : echo $val;
                                                                echo '<br>';
                                                            endforeach; ?>
                                                        </span>
                                                    </td>
                                                    <td class="date">
                                                        <strong>Drop off</strong>
                                                        <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                                    </td>
                                                <?php endif; ?>
                                                <td class="price">£<?= order_total_price($order->order_id) ?></td>
                                            </tr>
                                    <?php } ?>
                                <?php
                                } 
                                else
                                {
                                ?>
                                    <tr>
                                        <td>No order delivered yet.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="Cancelled" class="job_tbl tab-pane fade">
                    <table>
                            <tbody>
                                <?php if (!empty($canceled_orders)) { ?>
                                    <?php foreach ($canceled_orders as $order) {
                                        $services = $order->services;
                                    ?>
                                            <tr class="<?= order_log($order->order_id) ?>">
                                                <td>
                                                    <div class="ico_blk">
                                                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                                                        <div class="txt">
                                                            <div class="head">
                                                                <h5>OTP: <?= num_size($order->order_id) ?></h5>
                                                                <span class="badge <?= get_order_status($order->order_status); ?>"><?= $order->order_status ?></span>
                                                            </div>
                                                            <p>
                                                                <?php
                                                                $count = 0;
                                                                foreach ($services as $service) {
                                                                ?>
                                                                    <span><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></span>
                                                                <?php
                                                                    if (++$count == 4) {
                                                                        break;
                                                                    }
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <a href="<?= base_url('buyer/order-detail/') . doEncode($order->order_id) ?>" class="more_btn"></a>
                                                    </div>
                                                </td>
                                                <td class="qty"><strong>Items:</strong> <?=count($services)?></td>
                                                <?php if ($order->pick_and_drop_service == '1') : ?>
                                                    <td class="date">
                                                        <strong>Collection</strong>
                                                        <span><?= date_picker_format_date($order->collection_date, 'D, d M Y', false) ?> - <?= $order->collection_time ?></span>
                                                    </td>
                                                    <td class="date">
                                                        <strong>Delivery</strong>
                                                        <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                                    </td>
                                                <?php else : ?>
                                                    <td class="date">
                                                        <strong>Address</strong>
                                                        <span>
                                                            <?php foreach (explode('@', $order->address) as $val) : echo $val;
                                                                echo '<br>';
                                                            endforeach; ?>
                                                        </span>
                                                    </td>
                                                    <td class="date">
                                                        <strong>Drop off</strong>
                                                        <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                                    </td>
                                                <?php endif; ?>
                                                <td class="price">£<?= order_total_price($order->order_id) ?></td>
                                            </tr>
                                    <?php } ?>
                                <?php
                                } 
                                else
                                {
                                ?>
                                    <tr>
                                        <td>No canceled order yet.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- orders -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>