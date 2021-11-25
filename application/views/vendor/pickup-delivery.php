<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pickup & Delivery Time — <?= $site_settings->site_name ?></title>
    <?php require_once('../includes/site-master.php'); ?>
</head>

<body id="home-page">
    <?php require_once('../includes/header-vendor.php'); ?>
    <main dash account>
        <?php require_once('../includes/sidebar-vendor.php'); ?>


        <section id="account">
            <div class="contain-fluid">
                <div class="blk topBlk">
                    <div class="ico"><img src="<?= $base_url ?>images/users/7.jpg" alt=""></div>
                    <div class="txt">
                        <h3><span class="regular">Welcome,</span> Dear, Jennifer Kem!<span class="regular">Nice to see you again.</span></h3>
                    </div>
                    <div class="toggleBlk">
                        <div class="switchBtn">
                            <input type="checkbox" name="" id="" checked>
                            <em></em>
                            <small></small>
                        </div>
                    </div>
                </div>
                <div class="blk">
                    <form action="" method="post">
                        <div class="inside">
                            <h5>Collection</h5>
                            <div class="formRow row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                    <div class="txtGrp">
                                        <label for="">Date</label>
                                        <input type="text" name="" id="" class="txtBox datepicker">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                    <div class="txtGrp">
                                        <label for="" class="move">Time</label>
                                        <select name="" id="" class="txtBox">
                                            <option value="">Select</option>
                                            <option value="">13:00 - 16:00</option>
                                            <option value="">14:00 - 17:00</option>
                                            <option value="">17:00 - 20:00</option>
                                            <option value="">18:00 - 21:00</option>
                                            <option value="">19:00 - 22:00</option>
                                            <option value="">13:00 - 15:00</option>
                                            <option value="">14:00 - 16:00</option>
                                            <option value="">15:00 - 17:00</option>
                                            <option value="">17:00 - 19:00</option>
                                            <option value="">18:00 - 20:00</option>
                                            <option value="">19:00 - 21:00</option>
                                            <option value="">20:00 - 22:00</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xx-12">
                                    <div class="txtGrp">
                                        <label for="" class="move">Collects From</label>
                                        <select name="" id="" class="txtBox">
                                            <option value="">Select</option>
                                            <option value="">Driver collects from you</option>
                                            <option value="">Driver collects from outside</option>
                                            <option value="">Driver collects from reception/porter</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5>Drop off</h5>
                            <div class="formRow row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                    <div class="txtGrp">
                                        <label for="">Date</label>
                                        <input type="text" name="" id="" class="txtBox datepicker">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                    <div class="txtGrp">
                                        <label for="" class="move">Time</label>
                                        <select name="" id="" class="txtBox">
                                            <option value="">Select</option>
                                            <option value="">13:00 - 16:00</option>
                                            <option value="">14:00 - 17:00</option>
                                            <option value="">17:00 - 20:00</option>
                                            <option value="">18:00 - 21:00</option>
                                            <option value="">19:00 - 22:00</option>
                                            <option value="">13:00 - 15:00</option>
                                            <option value="">14:00 - 16:00</option>
                                            <option value="">15:00 - 17:00</option>
                                            <option value="">17:00 - 19:00</option>
                                            <option value="">18:00 - 20:00</option>
                                            <option value="">19:00 - 21:00</option>
                                            <option value="">20:00 - 22:00</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xx-12">
                                    <div class="txtGrp">
                                        <label for="" class="move">Collects Drops</label>
                                        <select name="" id="" class="txtBox">
                                            <option value="">Select</option>
                                            <option value="">Driver drops, rings & waits</option>
                                            <option value="">Driver drops, rings and goes</option>
                                            <option value="">Driver leaves bags at reception/porter</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="bTn formBtn text-center">
                                <button type="submit" class="webBtn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- account -->


    </main>
    <?php require_once('../includes/footer.php'); ?>
</body>

</html>