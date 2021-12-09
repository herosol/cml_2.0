<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Wallet — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="trans">
            <div class="contain">
                <div class="top_head hidden">
                    <h4>Information on payment methods</h4>
                    <div class="btn_blk">
                        <button type="button" class="site_btn sm pop_btn" data-popup="withdraw-funds">Add New Pay Method</button>
                    </div>
                </div>
                <div class="flex_row info_row full_height hidden">
                    <div class="col">
                        <div class="pay_blk">
                            <div class="inr">
                                <div class="txt">
                                    <div class="head">
                                        <div class="icon"><img src="<?= base_url('assets/images/paypal.svg') ?>" alt=""></div>
                                    </div>
                                    <div class="cvc">cml@paypal-demo.com</div>
                                    <div class="date">Added on 10/09/2021</div>
                                </div>
                            </div>
                            <div class="btm">
                                <ul class="action_btn">
                                    <li><a href="?"><img src="<?= base_url('assets/images/icon-edit.svg') ?>" alt=""> Edit</a></li>
                                    <li><a href="?"><img src="<?= base_url('assets/images/icon-trash.svg') ?>" alt=""> Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="pay_blk">
                            <div class="inr">
                                <div class="txt">
                                    <div class="head">
                                        <div class="icon"><img src="<?= base_url('assets/images/visa.svg') ?>" alt=""></div>
                                    </div>
                                    <div class="cvc">*** *** *** 4242</div>
                                    <div class="date">Added on 10/09/2021</div>
                                </div>
                            </div>
                            <div class="btm">
                                <ul class="action_btn">
                                    <li><a href="?"><img src="<?= base_url('assets/images/icon-edit.svg') ?>" alt=""> Edit</a></li>
                                    <li><a href="?"><img src="<?= base_url('assets/images/icon-trash.svg') ?>" alt=""> Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="pay_blk">
                            <div class="inr">
                                <div class="txt">
                                    <div class="head">
                                        <div class="icon"><img src="<?= base_url('assets/images/bank.svg') ?>" alt=""></div>
                                    </div>
                                    <div class="cvc">*************AS33F</div>
                                    <div class="date">Added on 10/09/2021</div>
                                </div>
                            </div>
                            <div class="btm">
                                <ul class="action_btn">
                                    <li><a href="?"><img src="<?= base_url('assets/images/icon-edit.svg') ?>" alt=""> Edit</a></li>
                                    <li><a href="?"><img src="<?= base_url('assets/images/icon-trash.svg') ?>" alt=""> Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="br"></div>
                <div class="flex_row card_row full_height">
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>Total Transactions</span>
                                    <div class="price"><?=count((array)$transactions)?></div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-wallet.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>Used balance</span>
                                    <div class="price">£<?=price_format($used_balance)?></div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-money.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="br"></div>
                <h4 class="subheading">Wallet summary</h4>
                <div class="blk">
                    <div class="tbl_blk">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order No.</th>
                                    <th>Customer Name</th>
                                    <th width="140">Amount</th>
                                    <th>Date</th>
                                    <th width="80">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count((array)$transactions) == 0) : ?>
                                    <tr>
                                        <td>No transaction yet.</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                else :
                                    foreach ($transactions as $index => $transaction) :
                                    ?>
                                        <tr>
                                            <td><a href="<?= base_url() ?>buyer/order-detail/<?= doEncode($transaction->order_id) ?>"><?= num_size($transaction->order_id) ?></a></td>
                                            <td><?= $transaction->vendor_name ?></td>
                                            <td class="price">£<?= $transaction->amount ?></td>
                                            <td><?= $transaction->date ?></td>
                                            <td><span class="badge green">Completed</span></td>
                                        </tr>
                                <?php
                                    endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="popup" data-popup="withdraw-funds">
                <div class="table_dv">
                    <div class="table_cell">
                        <div class="contain">
                            <div class="_inner">
                                <div class="cross_btn"></div>
                                <h3>Add Payment method</h3>
                                <form action="" method="post">
                                    <div data-payment="wallet">
                                        <div class="lbl_btn">
                                            <input type="radio" name="payment" id="bank" class="tglBlk" value="bank-account" checked="">
                                            <label for="bank">Bank Account</label>
                                        </div>
                                        <div class="inside_blk active">
                                            <div class="form_blk">
                                                <label for="" class="move">Bank Account</label>
                                                <select name="" id="" class="text_box">
                                                    <option value="">Select</option>
                                                    <option value="">Wells Fargo Checking Account</option>
                                                    <option value="">SunTrust Checking Account</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="lbl_btn">
                                            <input type="radio" name="payment" id="paypal" class="tglBlk" value="paypal">
                                            <label for="paypal">Paypal</label>
                                        </div>
                                        <div class="inside_blk">
                                            <div class="form_blk">
                                                <label for="">PayPal Address</label>
                                                <input type="email" name="" id="" class="text_box">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_blk form_btn text-center">
                                        <button type="submit" class="site_btn long">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- trans -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>