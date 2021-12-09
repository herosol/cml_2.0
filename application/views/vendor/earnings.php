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
                <!-- <div class="blk blans_blk">
                    <ul class="blans">
                        <li>Deliveries: <span><?= $deliveries ?></span></li>
                        <li>Payouts: <span class="price">£<?= price_format($payouts) ?></span></li>
                        <li>Current Balance: <span class="price">£<?= price_format($availBalance) ?></span></li>
                        <li>Requested Balance: <span class="price">£<?= price_format($requested) ?></span></li>
                        <?php if (price_format($availBalance) >= 1) : ?>
                            <li><button type="button" class="webBtn smBtn simpleBtn popBtn" data-popup="withdraw-funds">Withdraw Funds</button></li>
                        <?php endif; ?>
                    </ul>
                </div> -->
                <div class="top_head">
                    <h4>Information on payment methods</h4>
                    <div class="btn_blk">
                        <?php if (price_format($availBalance) >= 1) : ?>
                            <button type="button" class="site_btn sm pop_btn" data-popup="withdraw-funds">Withdraw Funds</button>
                        <?php endif; ?>
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
                                    <span>Deliveries</span>
                                    <div class="price"><?= $deliveries ?></div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-handover.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>Payouts</span>
                                    <div class="price">£<?= price_format($payouts) ?></div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-payouts.svg') ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>Current balance</span>
                                    <div class="price">£<?= price_format($availBalance) ?></div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-wallet.svg') ?>" alt=""></div>
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
                                    <th>Customer Name</th>
                                    <th width="140">Amount</th>
                                    <th>Date</th>
                                    <th width="80">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($earnings)) : ?>
                                    <tr>
                                        <td>No earning yet.</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                else :
                                    foreach ($earnings as $key => $value) : ?>
                                        <tr>
                                            <td><?= $value->cfname . ' ' . $value->clname ?></td>
                                            <td class="price">$<?= price_format($value->amount) ?></td>
                                            <td><?= date_picker_format_date($value->date, 'D, d M Y', false) ?></td>
                                            <td><span class="badge <?= earning_status_badge($value->status) ?>"><?= earning_status($value->status) ?></span></td>
                                        </tr>
                                <?php
                                    endforeach;
                                endif;
                                ?>
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
                                <form action="<?= base_url() ?>earnings/withdraw_request" method="post" id="withdrawForm" class="withdrawForm">
                                    <div class="alertMsg" style="display:none"></div>
                                    <input type="hidden" name="bank_check" id="bank_check" value="0" />
                                    <div data-payment="wallet">
                                        <div class="lbl_btn">
                                            <input type="radio" name="payment_method" id="bank" class="tglBlk" value="bank-account" checked="">
                                            <label for="bank">Bank Account</label>
                                        </div>
                                        <div class="inside_blk active">
                                            <div class="flex_blk form_blk">
                                                <div class="form_blk">
                                                    <label for="selected_bank" class="move">Bank Account</label>
                                                    <select name="selected_bank" id="selected_bank" class="text_box">
                                                        <option value="">Select</option>
                                                        <?php foreach ($bank_accounts as $key => $bank) : ?>
                                                            <option value="<?= $bank->id ?>"><?= $bank->bank_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="btn_blk">
                                                    <button type="button" id="addOrCancelBank" class="site_btn light">Add Bank</button>
                                                </div>
                                            </div>
                                            <div class="blk hidden addFormBlk">
                                                <div class="inside">
                                                    <div class="alertMsg" style="display:none"></div>
                                                    <h5>Bank Account Detail</h5>
                                                    <div id="form-bank-account">
                                                        <?= mem_bank_form() ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lbl_btn">
                                            <input type="radio" name="payment_method" id="paypal" class="tglBlk" value="paypal">
                                            <label for="paypal">Paypal</label>
                                        </div>
                                        <div class="inside_blk">
                                            <div class="form_blk">
                                                <label for="paypal_address">PayPal Address</label>
                                                <input type="paypal_address" name="paypal_address" id="paypal_address" class="text_box">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_blk form_btn text-center">
                                        <button type="submit" class="site_btn long"><i class="spinner hidden"></i>Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- trans -->


        <script type="text/javascript">
            $(document).on("click", "#addOrCancelBank", function(e) {
                e.preventDefault();
                let btn = $(this);
                let blk = $('.addFormBlk');
                if (blk.hasClass('hidden')) {
                    blk.removeClass('hidden');
                    btn.text('Cancel');
                    $('#bank_check').val(1);
                } else {
                    blk.addClass('hidden');
                    btn.text('Add Bank');
                    $('#bank_check').val(0);
                }
            });
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>