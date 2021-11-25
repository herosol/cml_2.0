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
                                        if (in_array($order->order_status, ['New'])) : ?>
                                            <tr class="<?= order_log($order->order_id) ?>">
                                                <td>
                                                    <div class="ico_blk">
                                                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                                                        <div class="txt">
                                                            <div class="head">
                                                                <h5>OTP: <?= num_size($order->order_id) ?></h5>
                                                                <span class="badge blue"><?= ($order->order_status) ?></span>
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
                                                <td class="qty"><strong>Items:</strong> 05</td>
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
                                    <?php
                                        endif;
                                    }
                                    ?>
                                    <?php foreach ($orders as $order) {
                                        $services = $order->services;
                                        if (in_array($order->order_status, ['In Progress'])) : ?>
                                            <tr class="<?= order_log($order->order_id) ?>">
                                                <td>
                                                    <div class="ico_blk">
                                                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                                                        <div class="txt">
                                                            <div class="head">
                                                                <h5>OTP: <?= num_size($order->order_id) ?></h5>
                                                                <span class="badge yellow"><?= ($order->order_status) ?></span>
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
                                                <td class="qty"><strong>Items:</strong> 05</td>
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
                                    <?php
                                        endif;
                                    }
                                    ?>
                                    <?php foreach ($orders as $order) {
                                        $services = $order->services;
                                        if (in_array($order->order_status, ['Delivered'])) : ?>
                                            <tr class="<?= order_log($order->order_id) ?>">
                                                <td>
                                                    <div class="ico_blk">
                                                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                                                        <div class="txt">
                                                            <div class="head">
                                                                <h5>OTP: <?= num_size($order->order_id) ?></h5>
                                                                <span class="badge green"><?= ($order->order_status) ?></span>
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
                                                <td class="qty"><strong>Items:</strong> 05</td>
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
                                    <?php
                                        endif;
                                    }
                                    ?>
                                    <?php foreach ($orders as $order) {
                                        $services = $order->services;
                                        if (in_array($order->order_status, ['Completed'])) : ?>
                                            <tr class="<?= order_log($order->order_id) ?>">
                                                <td>
                                                    <div class="ico_blk">
                                                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                                                        <div class="txt">
                                                            <div class="head">
                                                                <h5>OTP: <?= num_size($order->order_id) ?></h5>
                                                                <span class="badge green"><?= ($order->order_status) ?></span>
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
                                                <td class="qty"><strong>Items:</strong> 05</td>
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
                                    <?php
                                        endif;
                                    }
                                    ?>
                                    <?php foreach ($orders as $order) {
                                        $services = $order->services;
                                        if (in_array($order->order_status, ['Cancelled'])) : ?>
                                            <tr class="<?= order_log($order->order_id) ?>">
                                                <td>
                                                    <div class="ico_blk">
                                                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                                                        <div class="txt">
                                                            <div class="head">
                                                                <h5>OTP: <?= num_size($order->order_id) ?></h5>
                                                                <span class="badge red"><?= ($order->order_status) ?></span>
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
                                                <td class="qty"><strong>Items:</strong> 05</td>
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
                                    <?php
                                        endif;
                                    }
                                    ?>
                                <?php
                                } else {
                                ?>
                                    <tr>
                                        <td>No order yet.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="Delivered" class="job_tbl tab-pane fade"></div>
                    <div id="Cancelled" class="job_tbl tab-pane fade"></div>
                </div>
            </div>
        </section>
        <!-- orders -->


        <section id="orders" style="display: none !important;">
            <div class="contain">
                <?php if (!empty($orders)) { ?>
                    <?php foreach ($orders as $order) {
                        $services = $order->services;
                        if (in_array($order->order_status, ['New'])) : ?>
                            <div class="flex_row">
                                <div class="col col1">
                                    <div class="orderBlk blk <?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'expire' : '' ?>">
                                        <div class="inside">
                                            <div class="lSide">
                                                <div class="_header">
                                                    <h3 class="odr_heading <?= order_log($order->order_id) ?>">
                                                        <em><?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'Previous Order' : 'Current Order' ?></em>
                                                    </h3>
                                                    <div class="cmpnyLogo icon"><img src="<?= get_site_image_src("members", $order->mem_image, 'thumb_'); ?>" alt=""></div>
                                                </div>
                                                <h5>Quantity</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div class="progressbar" data-animate="false">
                                                                <div class="circle" data-percent="<?= $service->quantity ?>0">
                                                                    <strong><?= $service->quantity ?></strong>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="br"></div>
                                                <h5>Items</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <span class="badge"><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></span>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </div>
                                            <div class="rSide">
                                                <ul class="list">
                                                    <li class="semi">
                                                        <div>Service</div>
                                                        <div>Price</div>
                                                    </li>
                                                    <?php
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></div>
                                                            <div>£<?= $service->sub_service_price * $service->quantity ?></div>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <?php if ($order->pick_and_drop_service == '1') : ?>
                                                        <?php if ($order->free_pick_and_drop_service == '0') : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>£<?= price_format($order->pick_and_drop_charges) ?></div>
                                                            </li>
                                                        <?php else : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>Free</div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if ($order->buyer_get_credit == '1') : ?>
                                                        <li>
                                                            <div>Total Price</div>
                                                            <div>£<?= price_format($order->order_total_price + $order->buyer_credit_discount) ?></div>
                                                        </li>
                                                        <li>
                                                            <div>Discount</div>
                                                            <div>£<?= price_format($order->buyer_credit_discount) ?></div>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <li class="semi">
                                                        <div>Grand Total</div>
                                                        <div>£<?= order_total_price($order->order_id) ?></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="btm">
                                            <div class="status processed">Order <?= ($order->order_status) ?></div>
                                            <span>Order placed: <?= format_date($order->order_date) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col2">
                                    <div class="otpBlk blk">
                                        <h3>OTP: <?= num_size($order->order_id) ?></h3>
                                        <ul class="pickDrop">
                                            <?php if ($order->address_type == 'office') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-briefcase.svg" alt=""></div>
                                                        <span>Office</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'home') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-home.svg" alt=""></div>
                                                        <span>Home</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'hotel') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-hotel.svg" alt=""></div>
                                                        <span>Hotel</span>
                                                    </div>
                                                </li>
                                            <?php } else { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Walk-in Address</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/icon-map-marker.svg" alt=""></div>
                                                        <span>
                                                            <?php
                                                            foreach (explode('@', $order->address) as $val) :
                                                                echo $val;
                                                                echo '<br>';
                                                            endforeach;
                                                            ?>
                                                        </span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <h6>Contact No. <em class="regular"><?= $order->buyer_phone ?></em></h6>
                                        <?php if ($order->pick_and_drop_service == '1') : ?>
                                            <h6>Delivery Option. <em class="regular"><?= $order->drop_type ?></em></h6>
                                        <?php endif; ?>
                                        <div class="btm">
                                            <!-- <div class="icon"><img src="<?= base_url() ?>assets/images/vector-wait.svg" alt=""></div> -->
                                            <div class="bTn text-center">
                                                <a href="<?= base_url('buyer/order-detail/') . doEncode($order->order_id) ?>" class="webBtn mdBtn blankBtn borderBtn">More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endif;
                    }
                    ?>
                    <?php foreach ($orders as $order) {
                        $services = $order->services;
                        if (in_array($order->order_status, ['In Progress'])) : ?>
                            <div class="flex_row">
                                <div class="col col1">
                                    <div class="orderBlk blk <?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'expire' : '' ?>">
                                        <div class="inside">
                                            <div class="lSide">
                                                <div class="_header">
                                                    <h3 class="odr_heading <?= order_log($order->order_id) ?>"><em><?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'Previous Order' : 'Current Order' ?></em></h3>
                                                    <div class="cmpnyLogo icon"><img src="<?= get_site_image_src("members", $order->mem_image, 'thumb_'); ?>" alt=""></div>
                                                </div>
                                                <h5>Quantity</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div class="progressbar" data-animate="false">
                                                                <div class="circle" data-percent="<?= $service->quantity ?>0">
                                                                    <strong><?= $service->quantity ?></strong>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="br"></div>
                                                <h5>Items</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <span class="badge"><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></span>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </div>
                                            <div class="rSide">
                                                <ul class="list">
                                                    <li class="semi">
                                                        <div>Service</div>
                                                        <div>Price</div>
                                                    </li>
                                                    <?php
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></div>
                                                            <div>£<?= $service->sub_service_price * $service->quantity ?></div>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <?php if ($order->pick_and_drop_service == '1') : ?>
                                                        <?php if ($order->free_pick_and_drop_service == '0') : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>£<?= price_format($order->pick_and_drop_charges) ?></div>
                                                            </li>
                                                        <?php else : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>Free</div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if ($order->buyer_get_credit == '1') : ?>
                                                        <li>
                                                            <div>Total Price</div>
                                                            <div>£<?= price_format($order->order_total_price + $order->buyer_credit_discount) ?></div>
                                                        </li>
                                                        <li>
                                                            <div>Discount</div>
                                                            <div>£<?= price_format($order->buyer_credit_discount) ?></div>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <li class="semi">
                                                        <div>Grand Total</div>
                                                        <div>£<?= order_total_price($order->order_id) ?></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="btm">
                                            <div class="status processed">Order <?= ($order->order_status) ?></div>
                                            <span>Order placed: <?= format_date($order->order_date) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col2">
                                    <div class="otpBlk blk">
                                        <h3>OTP: <?= num_size($order->order_id) ?></h3>
                                        <ul class="pickDrop">
                                            <?php if ($order->address_type == 'office') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-briefcase.svg" alt=""></div>
                                                        <span>Office</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'home') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-home.svg" alt=""></div>
                                                        <span>Home</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'hotel') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-hotel.svg" alt=""></div>
                                                        <span>Hotel</span>
                                                    </div>
                                                </li>
                                            <?php } else { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Walk-in Address</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/icon-map-marker.svg" alt=""></div>
                                                        <span>
                                                            <?php
                                                            foreach (explode('@', $order->address) as $val) :
                                                                echo $val;
                                                                echo '<br>';
                                                            endforeach;
                                                            ?>
                                                        </span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <h6>Contact No. <em class="regular"><?= $order->buyer_phone ?></em></h6>
                                        <?php if ($order->pick_and_drop_service == '1') : ?>
                                            <h6>Delivery Option. <em class="regular"><?= $order->drop_type ?></em></h6>
                                        <?php endif; ?>
                                        <div class="btm">
                                            <!-- <div class="icon"><img src="<?= base_url() ?>assets/images/vector-wait.svg" alt=""></div> -->
                                            <div class="bTn text-center">
                                                <a href="<?= base_url('buyer/order-detail/') . doEncode($order->order_id) ?>" class="webBtn mdBtn blankBtn borderBtn">More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endif;
                    }
                    ?>
                    <?php foreach ($orders as $order) {
                        $services = $order->services;
                        if (in_array($order->order_status, ['Delivered'])) : ?>
                            <div class="flex_row">
                                <div class="col col1">
                                    <div class="orderBlk blk <?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'expire' : '' ?>">
                                        <div class="inside">
                                            <div class="lSide">
                                                <div class="_header">
                                                    <h3 class="odr_heading <?= order_log($order->order_id) ?>"><em><?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'Previous Order' : 'Current Order' ?></em></h3>
                                                    <div class="cmpnyLogo icon"><img src="<?= get_site_image_src("members", $order->mem_image, 'thumb_'); ?>" alt=""></div>
                                                </div>
                                                <h5>Quantity</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div class="progressbar" data-animate="false">
                                                                <div class="circle" data-percent="<?= $service->quantity ?>0">
                                                                    <strong><?= $service->quantity ?></strong>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="br"></div>
                                                <h5>Items</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <span class="badge"><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></span>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </div>
                                            <div class="rSide">
                                                <ul class="list">
                                                    <li class="semi">
                                                        <div>Service</div>
                                                        <div>Price</div>
                                                    </li>
                                                    <?php
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></div>
                                                            <div>£<?= $service->sub_service_price * $service->quantity ?></div>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <?php if ($order->pick_and_drop_service == '1') : ?>
                                                        <?php if ($order->free_pick_and_drop_service == '0') : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>£<?= price_format($order->pick_and_drop_charges) ?></div>
                                                            </li>
                                                        <?php else : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>Free</div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if ($order->buyer_get_credit == '1') : ?>
                                                        <li>
                                                            <div>Total Price</div>
                                                            <div>£<?= price_format($order->order_total_price + $order->buyer_credit_discount) ?></div>
                                                        </li>
                                                        <li>
                                                            <div>Discount</div>
                                                            <div>£<?= price_format($order->buyer_credit_discount) ?></div>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <li class="semi">
                                                        <div>Grand Total</div>
                                                        <div>£<?= order_total_price($order->order_id) ?></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="btm">
                                            <div class="status processed">Order <?= ($order->order_status) ?></div>
                                            <span>Order placed: <?= format_date($order->order_date) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col2">
                                    <div class="otpBlk blk">
                                        <h3>OTP: <?= num_size($order->order_id) ?></h3>
                                        <ul class="pickDrop">
                                            <?php if ($order->address_type == 'office') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-briefcase.svg" alt=""></div>
                                                        <span>Office</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'home') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-home.svg" alt=""></div>
                                                        <span>Home</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'hotel') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-hotel.svg" alt=""></div>
                                                        <span>Hotel</span>
                                                    </div>
                                                </li>
                                            <?php } else { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Walk-in Address</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/icon-map-marker.svg" alt=""></div>
                                                        <span>
                                                            <?php
                                                            foreach (explode('@', $order->address) as $val) :
                                                                echo $val;
                                                                echo '<br>';
                                                            endforeach;
                                                            ?>
                                                        </span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <h6>Contact No. <em class="regular"><?= $order->buyer_phone ?></em></h6>
                                        <?php if ($order->pick_and_drop_service == '1') : ?>
                                            <h6>Delivery Option. <em class="regular"><?= $order->drop_type ?></em></h6>
                                        <?php endif; ?>
                                        <div class="btm">
                                            <!-- <div class="icon"><img src="<?= base_url() ?>assets/images/vector-wait.svg" alt=""></div> -->
                                            <div class="bTn text-center">
                                                <a href="<?= base_url('buyer/order-detail/') . doEncode($order->order_id) ?>" class="webBtn mdBtn blankBtn borderBtn">More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endif;
                    }
                    ?>
                    <?php foreach ($orders as $order) {
                        $services = $order->services;
                        if (in_array($order->order_status, ['Completed'])) : ?>
                            <div class="flex_row">
                                <div class="col col1">
                                    <div class="orderBlk blk <?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'expire' : '' ?>">
                                        <div class="inside">
                                            <div class="lSide">
                                                <div class="_header">
                                                    <h3 class="odr_heading <?= order_log($order->order_id) ?>"><em><?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'Previous Order' : 'Current Order' ?></em></h3>
                                                    <div class="cmpnyLogo icon"><img src="<?= get_site_image_src("members", $order->mem_image, 'thumb_'); ?>" alt=""></div>
                                                </div>
                                                <h5>Quantity</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div class="progressbar" data-animate="false">
                                                                <div class="circle" data-percent="<?= $service->quantity ?>0">
                                                                    <strong><?= $service->quantity ?></strong>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="br"></div>
                                                <h5>Items</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <span class="badge"><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></span>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </div>
                                            <div class="rSide">
                                                <ul class="list">
                                                    <li class="semi">
                                                        <div>Service</div>
                                                        <div>Price</div>
                                                    </li>
                                                    <?php
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></div>
                                                            <div>£<?= $service->sub_service_price * $service->quantity ?></div>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <?php if ($order->pick_and_drop_service == '1') : ?>
                                                        <?php if ($order->free_pick_and_drop_service == '0') : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>£<?= price_format($order->pick_and_drop_charges) ?></div>
                                                            </li>
                                                        <?php else : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>Free</div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if ($order->buyer_get_credit == '1') : ?>
                                                        <li>
                                                            <div>Total Price</div>
                                                            <div>£<?= price_format($order->order_total_price + $order->buyer_credit_discount) ?></div>
                                                        </li>
                                                        <li>
                                                            <div>Discount</div>
                                                            <div>£<?= price_format($order->buyer_credit_discount) ?></div>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <li class="semi">
                                                        <div>Grand Total</div>
                                                        <div>£<?= order_total_price($order->order_id) ?></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="btm">
                                            <div class="status processed">Order <?= ($order->order_status) ?></div>
                                            <span>Order placed: <?= format_date($order->order_date) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col2">
                                    <div class="otpBlk blk">
                                        <h3>OTP: <?= num_size($order->order_id) ?></h3>
                                        <ul class="pickDrop">
                                            <?php if ($order->address_type == 'office') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-briefcase.svg" alt=""></div>
                                                        <span>Office</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'home') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-home.svg" alt=""></div>
                                                        <span>Home</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'hotel') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-hotel.svg" alt=""></div>
                                                        <span>Hotel</span>
                                                    </div>
                                                </li>
                                            <?php } else { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Walk-in Address</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/icon-map-marker.svg" alt=""></div>
                                                        <span>
                                                            <?php
                                                            foreach (explode('@', $order->address) as $val) :
                                                                echo $val;
                                                                echo '<br>';
                                                            endforeach;
                                                            ?>
                                                        </span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <h6>Contact No. <em class="regular"><?= $order->buyer_phone ?></em></h6>
                                        <?php if ($order->pick_and_drop_service == '1') : ?>
                                            <h6>Delivery Option. <em class="regular"><?= $order->drop_type ?></em></h6>
                                        <?php endif; ?>
                                        <div class="btm">
                                            <!-- <div class="icon"><img src="<?= base_url() ?>assets/images/vector-wait.svg" alt=""></div> -->
                                            <div class="bTn text-center">
                                                <a href="<?= base_url('buyer/order-detail/') . doEncode($order->order_id) ?>" class="webBtn mdBtn blankBtn borderBtn">More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endif;
                    }
                    ?>
                    <?php foreach ($orders as $order) {
                        $services = $order->services;
                        if (in_array($order->order_status, ['Cancelled'])) : ?>
                            <div class="flex_row">
                                <div class="col col1">
                                    <div class="orderBlk blk <?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'expire' : '' ?>">
                                        <div class="inside">
                                            <div class="lSide">
                                                <div class="_header">
                                                    <h3 class="odr_heading <?= order_log($order->order_id) ?>"><em><?= $order->order_status == 'Completed' || $order->order_status == 'Cancelled' ? 'Previous Order' : 'Current Order' ?></em></h3>
                                                    <div class="cmpnyLogo icon"><img src="<?= get_site_image_src("members", $order->mem_image, 'thumb_'); ?>" alt=""></div>
                                                </div>
                                                <h5>Quantity</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div class="progressbar" data-animate="false">
                                                                <div class="circle" data-percent="<?= $service->quantity ?>0">
                                                                    <strong><?= $service->quantity ?></strong>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="br"></div>
                                                <h5>Items</h5>
                                                <ul class="itmLst flex">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <span class="badge"><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></span>
                                                        </li>
                                                    <?php
                                                        if (++$count == 4) {
                                                            break;
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </div>
                                            <div class="rSide">
                                                <ul class="list">
                                                    <li class="semi">
                                                        <div>Service</div>
                                                        <div>Price</div>
                                                    </li>
                                                    <?php
                                                    foreach ($services as $service) {
                                                    ?>
                                                        <li>
                                                            <div><?= ($service->sub_service_id) ? get_sub_service_name($service->sub_service_id) :  $service->sub_service_name ?></div>
                                                            <div>£<?= $service->sub_service_price * $service->quantity ?></div>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <?php if ($order->pick_and_drop_service == '1') : ?>
                                                        <?php if ($order->free_pick_and_drop_service == '0') : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>£<?= price_format($order->pick_and_drop_charges) ?></div>
                                                            </li>
                                                        <?php else : ?>
                                                            <li>
                                                                <div>Collection & Delivery Charges</div>
                                                                <div>Free</div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if ($order->buyer_get_credit == '1') : ?>
                                                        <li>
                                                            <div>Total Price</div>
                                                            <div>£<?= price_format($order->order_total_price + $order->buyer_credit_discount) ?></div>
                                                        </li>
                                                        <li>
                                                            <div>Discount</div>
                                                            <div>£<?= price_format($order->buyer_credit_discount) ?></div>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <hr>
                                                    </li>
                                                    <li class="semi">
                                                        <div>Grand Total</div>
                                                        <div>£<?= order_total_price($order->order_id) ?></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="btm">
                                            <div class="status processed">Order <?= ($order->order_status) ?></div>
                                            <span>Order placed: <?= format_date($order->order_date) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col2">
                                    <div class="otpBlk blk">
                                        <h3>OTP: <?= num_size($order->order_id) ?></h3>
                                        <ul class="pickDrop">
                                            <?php if ($order->address_type == 'office') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-briefcase.svg" alt=""></div>
                                                        <span>Office</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'home') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-home.svg" alt=""></div>
                                                        <span>Home</span>
                                                    </div>
                                                </li>
                                            <?php } else if ($order->address_type == 'hotel') { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Pick Up & Drop Off</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/vector-hotel.svg" alt=""></div>
                                                        <span>Hotel</span>
                                                    </div>
                                                </li>
                                            <?php } else { ?>
                                                <li>
                                                    <div class="inner">
                                                        <h5>Walk-in Address</h5>
                                                        <div class="icon"><img src="<?= base_url() ?>assets/images/icon-map-marker.svg" alt=""></div>
                                                        <span>
                                                            <?php
                                                            foreach (explode('@', $order->address) as $val) :
                                                                echo $val;
                                                                echo '<br>';
                                                            endforeach;
                                                            ?>
                                                        </span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <h6>Contact No. <em class="regular"><?= $order->buyer_phone ?></em></h6>
                                        <?php if ($order->pick_and_drop_service == '1') : ?>
                                            <h6>Delivery Option. <em class="regular"><?= $order->drop_type ?></em></h6>
                                        <?php endif; ?>
                                        <div class="btm">
                                            <!-- <div class="icon"><img src="<?= base_url() ?>assets/images/vector-wait.svg" alt=""></div> -->
                                            <div class="bTn text-center">
                                                <a href="<?= base_url('buyer/order-detail/') . doEncode($order->order_id) ?>" class="webBtn mdBtn blankBtn borderBtn">More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endif;
                    }
                    ?>
                <?php
                } else {
                ?>
                    <div class="row">
                        <div class="alert alert-info alert-sm text-white">No order yet.</div>
                    </div>
                <?php } ?>
            </div>
        </section>
        <!-- orders -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>