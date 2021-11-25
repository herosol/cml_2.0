<!DOCTYPE html>
<html lang="en">

<head>
    <title>Place Order — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body id="home-page">
    <?php $this->load->view('includes/header-buyer'); ?>
    <main common place>


        <section id="sBanner">
            <div class="contain">
                <div class="content">
                    <h2 class="heading">Place your Order</h2>
                    <p>Deleniti iste earum sed est distinctio corporis dolore autem, omnis facere amet blanditiis velit!</p>
                </div>
            </div>
            <div class="image"><img src="<?= $base_url ?>images/illustration_step3.svg" alt=""></div>
        </section>
        <!-- sBanner -->


        <section id="place">
            <div class="contain">
                <ul class="numLst semi">
                    <li class="active"><a href="<?= $base_url ?>buyer/place-order.php">1</a></li>
                    <li class="active"><a href="<?= $base_url ?>buyer/place-order-instruction.php">2</a></li>
                    <li class="active"><a href="<?= $base_url ?>buyer/place-order-confirmation.php">3</a></li>
                </ul>
                <h2 class="heading text-center">Step 3</h2>
                <div class="orderBlk blk">
                    <div class="_header">
                        <h3>Order Summary</h3>
                        <div class="cmpnyLogo icon"><img src="<?= $base_url ?>images/iron_logo.svg" alt=""></div>
                    </div>
                    <ul class="list">
                        <li class="semi">
                            <div>Service</div>
                            <div>Price</div>
                        </li>
                        <li>
                            <div>Iron Only</div>
                            <div>£3.20</div>
                        </li>
                        <li>
                            <div>Duvets &amp; Bulky Items</div>
                            <div>£5.20</div>
                        </li>
                        <li>
                            <div>Wash &amp; Dry - Mixed</div>
                            <div>£9.20</div>
                        </li>
                        <li>
                            <hr>
                        </li>
                        <li>
                            <div>Collection &amp; Delivery Charges</div>
                            <div>Free</div>
                        </li>
                        <li>
                            <div>Minimum Order</div>
                            <div>£20.00</div>
                        </li>
                        <li>
                            <div>Minimum Order Fee</div>
                            <div>£0.00</div>
                        </li>
                        <li>
                            <hr>
                        </li>
                        <li class="semi">
                            <div>Estimated Total</div>
                            <div>£40.20</div>
                        </li>
                    </ul>
                </div>
                <div class="blk">
                    <div class="_header">
                        <h3>Collection & Delivery Address</h3>
                    </div>
                    <ul class="icoLst flex">
                        <li>
                            <div class="inner">
                                <div class="icon"><img src="<?= $base_url ?>images/icon-map-marker.svg" alt=""></div>
                                <div class="txt">
                                    <h6>Home</h6>
                                    <p>Flat 4 parkview house hurts Street herne hill london sec24 Oeh.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="inner">
                                <div class="icon"><img src="<?= $base_url ?>images/icon-phone.svg" alt=""></div>
                                <div class="txt">
                                    <h6>Contact Number</h6>
                                    <p>074029845392</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="txtGrp">
                        <label for="">Order Note:</label>
                        <textarea name="" id="" class="txtBox"></textarea>
                    </div>
                </div>
                <div class="blk">
                    <div class="formRow row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-xx-12">
                            <div class="pdBlk">
                                <div class="icon"><img src="<?= $base_url ?>images/vector-collection.svg" alt=""></div>
                                <div class="txt">
                                    <h4>Collection</h4>
                                    <p>Friday, 25 Jun 2021, 9am - 11am</p>
                                </div>
                            </div>
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
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-xx-12">
                            <div class="pdBlk">
                                <div class="icon"><img src="<?= $base_url ?>images/vector-delivery.svg" alt=""></div>
                                <div class="txt">
                                    <h4>Delivery</h4>
                                    <p>Saturday, 25 Jun 2021, 9am - 11am</p>
                                </div>
                            </div>
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
                        </div>
                    </div>
                </div>
                <div class="blk">
                    <h4>Payment</h4>
                    <p>All transactions are secure and encrypted.</p>
                    <div class="payBlk">
                        <div class="image"><img src="<?= $base_url ?>images/credit-card.svg" alt=""></div>
                        <div data-payment="wallet">
                            <div class="lblBtn">
                                <input type="radio" name="payment" id="credit" class="tglBlk" value="credit-card" checked="">
                                <label for="credit">Credit card</label>
                            </div>
                            <div class="insideBlk active">
                                <div class="row formRow">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <label for="">Card Number</label>
                                            <input type="text" name="" id="" class="txtBox">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <label for="">Card Holder</label>
                                            <input type="text" name="" id="" class="txtBox">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-xx-4">
                                        <div class="txtGrp">
                                            <label for="" class="move">Month</label>
                                            <select name="" id="" class="txtBox">
                                                <option value="">Select</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-xx-4">
                                        <div class="txtGrp">
                                            <label for="" class="move">Year</label>
                                            <select name="" id="" class="txtBox">
                                                <option value="">Select</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-xx-4">
                                        <div class="txtGrp">
                                            <label for="">CVC?</label>
                                            <input type="text" name="" id="" class="txtBox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="lblBtn">
                                <input type="radio" name="payment" id="paypal" class="tglBlk" value="paypal">
                                <label for="paypal">Paypal</label>
                            </div>
                            <div class="insideBlk">
                                <div class="txtGrp">
                                    <label for="">PayPal Address</label>
                                    <input type="email" name="" id="" class="txtBox">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="txtGrp lblBtn">
                    <input type="checkbox" name="" id="confirm">
                    <label for="confirm">I agree to CPL's
                        <a href="<?= $base_url ?>terms-and-conditions.php">Terms & Conditions</a>
                        and
                        <a href="<?= $base_url ?>privacy-policy.php">Privacy Policy.</a>
                    </label>
                </div>
                <div class="bTn formBtn text-center">
                    <!-- <button type="submit" class="webBtn">Place Order</button> -->
                    <a href="<?= $base_url ?>buyer/order-confirmed.php" class="webBtn">Place Order</a>
                </div>
            </div>
        </section>
        <!-- place -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>