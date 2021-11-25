<!DOCTYPE html>
<html lang="en">

<head>
    <title>Notifications — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="notify">
            <div class="contain">
                <div class="blk noti_blk">
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/users/2.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>New Comment</h6>
                                <p>Jannifer Kem commented on your order <a href="?">click here</a> to view comment.</p>
                            </div>
                            <span class="time">2 hours ago</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/b_01.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>Washing Request</h6>
                                <p>You have a new washing request from Samira Jones <a href="?">Accept</a> or <a href="?">Decline</a></p>
                            </div>
                            <span class="time">7 hours ago</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/b_04.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>New Order</h6>
                                <p>You have created a new order for Jennifer Kem <a href="?">click here</a> to view detail.</p>
                            </div>
                            <span class="time">Yesterday at 5:32 am</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/b_02.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>Amend Invoice</h6>
                                <p>You have to make a new amend invoice <a href="?">click here</a> to view detail.</p>
                            </div>
                            <span class="time">Yesterday at 5:32 am</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/b_04.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>New Order</h6>
                                <p>John Wick send a new order to you <a href="?">click here</a> to view detail.</p>
                            </div>
                            <span class="time">Yesterday at 5:32 am</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/users/3.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>Leave a Review</h6>
                                <p>Leave a review on your experience with Jennifer Kem <a href="?">click here</a></p>
                            </div>
                            <span class="time">March 18 at 8:22 p.m.</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/users/2.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>Rated a Review</h6>
                                <p>You rated Jennifer Kem with 5 stars.</p>
                            </div>
                            <span class="time">Yesterday at 5:32 am</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/b_01.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>Check Notification</h6>
                                <p>You have a new notification. You're welcome <a href="?">click here</a> to view them</p>
                            </div>
                            <span class="time">7 hours ago</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/b_02.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>Order Rated</h6>
                                <p>John wick rated your order with 5 stars.</p>
                            </div>
                            <span class="time">Yesterday at 5:32 am</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/b_03.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>Remove Order</h6>
                                <p>You had removed a order.</p>
                            </div>
                            <span class="time">Yesterday at 5:32 am</span>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="ico">
                            <a href="?"><img src="<?= base_url('assets/images/users/1.jpg') ?>" alt=""></a>
                        </div>
                        <div class="txt">
                            <div class="cnt">
                                <h6>Washing Request</h6>
                                <p>You have a new washing request from Sasha Smith <a href="?">Accept</a> or <a href="?">Decline</a></p>
                            </div>
                            <span class="time">Yesterday at 1:05 am</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- notify -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>