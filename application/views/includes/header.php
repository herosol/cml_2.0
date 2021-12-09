<?php $slug = $this->uri->segment(1); ?>
<header class="ease">
    <div class="contain">
        <div class="logo">
            <a href="<?= base_url() ?>">
                <img src="<?= getImageSrc(UPLOADIMAGE . 'images/', $site_settings->site_logo) ?>" alt="">
            </a>
        </div>
        <button type="button" class="toggle"></button>
        <nav class="ease">
            <div id="nav">
                <?php if ($this->session->mem_type == 'vendor') : ?>
                    <ul id="lnk">
                        <li class="<?php if ($this->uri->segment(2) == "dashboard") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>vendor/dashboard">Dashboard</a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == "orders" || $this->uri->segment(2) == "order-detail") {
                                        echo 'active';
                                    } ?> <?= order_log() ?>">
                            <a href="<?= base_url() ?>vendor/orders">My Orders</a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == "credits") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>vendor/credits">Credits</a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == "wallet") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>vendor/wallet">Wallet</a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == "price-list") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>vendor/price-list">Price List</a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == "bank-accounts") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>vendor/bank-accounts">Bank Accounts</a>
                        </li>
                    </ul>
                <?php elseif ($this->session->mem_type == 'buyer') : ?>
                    <ul id="lnk">
                        <li class="<?php if ($this->uri->segment(2) == "dashboard") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>buyer/dashboard">Dashboard</a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == "orders" || $this->uri->segment(2) == "order-detail") {
                                        echo 'active';
                                    } ?> <?= order_log() ?>">
                            <a href="<?= base_url() ?>buyer/orders">My Orders</a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == "credits") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>buyer/credits">Credits</a>
                        </li>
                        <li class="<?php if ($this->uri->segment(2) == "transactions") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>buyer/transactions">Wallet</a>
                        </li>
                    </ul>
                    <ul id="cta">
                        <li class="<?php if ($page == "place-order") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>" class="site_btn blank border">Place an Order <img src="<?= base_url('assets/images/arrow-right-sm.svg') ?>" alt=""></a>
                        </li>
                    </ul>
                <?php else : ?>
                    <ul id="lnk">
                        <li class="<?php if ($slug == "") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url() ?>">Home</a>
                        </li>
                        <li class="<?php if ($slug == "promotions-offers") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url('promotions-offers') ?>">Promotions & Offers</a>
                        </li>
                        <li class="<?php if ($slug == "contact") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url('contact') ?>">Contact us</a>
                        </li>
                    </ul>
                <?php endif; ?>
                <?php if (empty($this->session->mem_id)) : ?>
                    <ul id="cta">
                        <li class="<?php if ($slug == "signin") {
                                        echo 'active';
                                    } ?>">
                            <?php if ($slug == 'order-booking') : ?>
                                <a href="javascript:void(0)" class="pop_btn" data-popup="signin">Sign in</a>
                            <?php else : ?>
                                <a href="<?= base_url('signin') ?>">Sign in</a>
                            <?php endif; ?>
                        </li>
                        <li class="<?php if ($slug == "signup") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url('signup-as') ?>" class="site_btn blank border">Sign up <img src="<?= base_url('assets/images/arrow-right-sm.svg') ?>" alt=""></a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
            <?php if ($this->session->mem_id) : ?>
                <ul id="icon_btn">
                    <li id="noti">
                        <a href="<?= base_url() . $this->session->mem_type ?>/notifications">
                            <img src="<?= base_url('assets/images/icon-bell.svg') ?>" alt="">
                            <span><?=new_notifs()?></span>
                        </a>
                    </li>
                </ul>
                <div id="pro_btn" class="drop_down">
                    <div class="ico drop_btn <?php if ($this->session->mem_type == 'vendor') : ?>icon<?php endif; ?>">
                        <img src="<?= get_site_image_src("members", $mem_data->mem_image, 'thumb_'); ?>" alt="">
                    </div>
                    <div class="drop_cnt">
                        <ul class="drop_lst">
                            <li><a href="<?= base_url() . $this->session->mem_type ?>/dashboard">Dashboard</a></li>
                            <li><a href="<?= base_url() . $this->session->mem_type ?>/orders">My Orders</a></li>
                            <?php if ($this->session->mem_type == 'vendor') : ?>
                                <li><a href="<?= base_url('vendor/wallet') ?>">My Earnings</a></li>
                            <?php else : ?>
                                <li><a href="<?= base_url('buyer/transactions') ?>">My Wallet</a></li>
                            <?php endif; ?>
                            <li><a href="<?= base_url('index/logout') ?>">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </nav>
        <div class="clearfix"></div>
    </div>
</header>
<!-- header -->