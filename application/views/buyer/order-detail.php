<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Detail — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="orders">
            <div class="contain">
                <div class="blk">
                    <div class="order_blk">
                        <div class="icon"><img src="<?= base_url('assets/images/partners/1.png') ?>" alt=""></div>
                        <div class="txt">
                            <div class="top_head">
                                <h4>Order No: <span>#<?= num_size($order->order_id) ?></span></h4>
                                <div class="status_btn_blk" id="btn_order_status">
                                    <span class="status_btn <?= get_order_status($order->order_status) ?>"><?= ucfirst($order->order_status) ?></span>
                                </div>
                            </div>
                            <ul class="list">
                                <li>
                                    <strong>Name:</strong>
                                    <span><?= $order->buyer_fname . ' ' . $order->buyer_lname ?></span>
                                </li>
                                <li>
                                    <strong>Phone Number:</strong>
                                    <span><?= $order->buyer_phone ?></span>
                                </li>
                                <li>
                                    <strong>Email Address:</strong>
                                    <span><?= $order->buyer_email ?></span>
                                </li>
                                <?php if ($order->pick_and_drop_service == '1') : ?>
                                    <li>
                                        <strong>Collection Address:</strong>
                                        <span><?= $order->collection_from ?></span>
                                    </li>
                                    <li>
                                        <strong>Collection Date & Time:</strong>
                                        <span><?= date_picker_format_date($order->collection_date, 'D, d M Y', false) ?> - <?= $order->collection_time ?></span>
                                    </li>
                                    <li>
                                        <strong>Delivery Address:</strong>
                                        <span><?= $order->delivery_to ?></span>
                                    </li>
                                    <li>
                                        <strong>Delivery Date & Time:</strong>
                                        <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                    </li>
                                    <li>
                                        <strong>Drop Off Type:</strong>
                                        <span><?= $order->drop_type ?></span>
                                    </li>
                                <?php else : ?>
                                    <li>
                                        <strong>Walk-in Address:</strong>
                                        <span>
                                            <?php
                                            foreach (explode('@', $order->address) as $val) :
                                                echo $val;
                                                echo '<br>';
                                            endforeach;
                                            ?>
                                        </span>
                                    </li>
                                    <li>
                                        <strong>Drop Off Date & Time:</strong>
                                        <span><?= date_picker_format_date($order->delivery_date, 'D, d M Y', false) ?> - <?= $order->delivery_time ?></span>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <strong>Vendor Notes:</strong>
                                    <span><?= $order->order_note ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <h4 class="subheading">Order Summary - Invoice</h4>
                <div class="blk">
                    <div class="tbl_blk">
                        <table>
                            <thead>
                                <tr>
                                    <th width="40%">Items</th>
                                    <th width="20%">Service</th>
                                    <th width="15%" class="text-center">Qty</th>
                                    <th width="10%" class="price">Unit Price</th>
                                    <th width="10%" class="price">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $services_total = 0;
                                foreach ($order_detail as $key => $row) :
                                    $service = get_sub_service($row->sub_service_id, $order->vendor_id);
                                    $services_total += $row->sub_service_price * $row->quantity;
                                ?>
                                    <tr>
                                        <td><?= $service->name ?></td>
                                        <td><?= $service->service_name ?></td>
                                        <td class="text-center"><?= $row->quantity ?></td>
                                        <td class="price">£<?= price_format($row->sub_service_price) ?></td>
                                        <td class="price">£<?= price_format($row->sub_service_price * $row->quantity) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <th class="price">£<?= order_total_price($order->order_id, 'SERVICES') ?></th>
                                </tr>
                                <?php if ($order->pick_and_drop_service == '1') : ?>
                                    <?php if ($order->free_pick_and_drop_service == '0') : ?>
                                        <tr>
                                            <td colspan="4" class="color">Pickup & Delivery Charges</td>
                                            <td class="price color">£<?= price_format($order->pick_and_drop_charges) ?></td>
                                        </tr>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" class="color">Pickup & Delivery Charges</td>
                                            <td class="price color">Free</td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($order->buyer_get_credit == '1') : ?>
                                    <tr>
                                        <td colspan="4" class="color">Get Discount <?= $order->buyer_credit_percentage ?>%</td>
                                        <td class="price">£<?= order_total_price($order->order_id, 'DISCOUNT') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="color">After Discount</td>
                                        <td class="price">£<?= order_total_price($order->order_id, 'AFTER_DISCOUNT') ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tfoot>
                        </table>
                        <div id="amended-invoice">
                            <?php echo amended_invoice($order->order_id, $amended); ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($delivery_proof)) { ?>
                    <h4 class="subheading">Delivery Proof</h4>
                    <div class="blk proof_blk" id="delivery_proof">
                        <div class="done_blk">
                            <a href="<?= get_site_image_src("orders", $delivery_proof->proof_image); ?>" class="image" data-fancybox="proof"><img src="<?= get_site_image_src("orders", $delivery_proof->proof_image); ?>" data-src="<?= get_site_image_src("orders", $delivery_proof->proof_image); ?>" alt=""></a>
                            <div class="txt">
                                <h6>Comments</h6>
                                <p><?= $delivery_proof->proof_comment ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="blk text-center" id="deliveryProofRequest">
                        <h4>You've received your order, please accept or decline.</h4>
                        <div class="btn_blk form_btn">
                            <button type="button" class="site_btn light pop_btn" data-popup="reject-proof">Decline</button>
                            <button type="button" class="site_btn pop_btn" data-popup="leave-review">Accept</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="popup sm" data-popup="reject-proof">
                <div class="table_dv">
                    <div class="table_cell">
                        <div class="contain">
                            <div class="_inner">
                                <div class="cross_btn"></div>
                                <h4 class="text-center">Are You Sure you want to Reject it ? </h4>
                                <form action="<?= base_url('buyer/reject_proof_delivery/'); ?>" method="post" id="rejectDeliveryAndRating" class="rejectDeliveryAndRating">
                                    <div class="alertMsg" style="display:none"></div>
                                    <input type="hidden" name="proof_id" value="<?= doEncode($delivery_proof->proof_id) ?>" />
                                    <div class="btn_blk text-center">
                                        <button type="submit" class="site_btn long"><i class="spinner hidden"></i>Yes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup" data-popup="leave-review">
                <div class="table_dv">
                    <div class="table_cell">
                        <div class="contain">
                            <div class="_inner">
                                <div class="cross_btn"></div>
                                <h4>Leave Review</h4>
                                <form action="<?= base_url() ?>buyer/accept_proof_delivery" method="post" id="acceptDeliveryAndRating" class="acceptDeliveryAndRating">
                                    <div class="alertMsg" style="display:none"></div>
                                    <input type="hidden" name="rating" value="4" />
                                    <input type="hidden" name="proof_id" value="<?= doEncode($delivery_proof->proof_id) ?>" />
                                    <div class="form_blk">
                                        <div class="rateYo" id="rating" data-rateyo-rating="1" data-rateyo-star-width="20px" data-rateyo-read-only="false"></div>
                                    </div>
                                    <div class="form_blk">
                                        <h6>Comment</h6>
                                        <textarea name="review_comment" id="review_comment" class="text_box" placeholder="Write a little description"></textarea>
                                    </div>
                                    <div class="btn_blk text-center"><button type="submit" class="site_btn long"><i class="spinner hidden"></i>Submit</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup" data-popup="pay-amend-invoice">
                <div class="table_dv">
                    <div class="table_cell">
                        <div class="contain">
                            <div class="_inner">
                                <div class="cross_btn"></div>
                                <h3>Pay Amended Amount</h3>
                                <form action="<?= base_url() ?>buyer/pay_amend_invoice" method="post" id="payment-form">
                                    <p>All transactions are secure and encrypted.</p>
                                    <div class="alertMsg" style="display:none"></div>
                                    <div data-payment="wallet">
                                        <div class="lbl_btn">
                                            <input type="radio" name="payment_type" id="credit" class="tglBlk" value="credit-card" checked="">
                                            <label for="credit">Credit card</label>
                                        </div>
                                        <div class="inside_blk">
                                            <div class="form_row row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form_blk">
                                                        <label for="cardnumber">Card Number</label>
                                                        <input type="text" name="cardnumber" id="cardnumber" class="text_box">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form_blk">
                                                        <label for="card_holder_name">Card Holder</label>
                                                        <input type="text" name="card_holder_name" id="card_holder_name" class="text_box">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form_blk">
                                                        <label for="exp_month" class="move">Month</label>
                                                        <select name="exp_month" id="exp_month" class="text_box">
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
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form_blk">
                                                        <label for="exp_year" class="move">Year</label>
                                                        <select name="exp_year" id="exp_year" class="text_box">
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
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form_blk">
                                                        <label for="cvc">CVC?</label>
                                                        <input type="text" name="cvc" id="cvc" class="text_box">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lbl_btn">
                                            <input type="radio" name="payment_type" id="paypal" class="tglBlk" value="paypal">
                                            <label for="paypal">Paypal</label>
                                        </div>
                                    </div>
                                    <div class="btn_blk form_btn text-center">
                                        <button type="submit" class="site_btn long"><i class="spinner hidden"></i>Pay</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- orders -->


        <script src="https://js.stripe.com/v2/"></script>
        <script>
            $(document).on('submit', '#payment-form', function(e) {
                e.preventDefault();
                let sbtn = $('#payment-form').find("button[type='submit']");
                sbtn.attr('disabled', true);
                $(this).find('button[type="submit"] i.spinner').removeClass('hidden');
                let form$ = $("#payment-form");
                let frmIcon = form$.find("button[type='submit'] i.spinner");
                let frmData = new FormData(form$[0]);
                let frmMsg = $('.alertMsg-form');
                sbtn.attr("disabled", true);
                if ($('input[name="payment_type"]:checked').val() == 'paypal') {
                    needToConfirm = true;
                    $.ajax({
                        url: form$.attr('action'),
                        data: frmData,
                        dataType: 'JSON',
                        method: 'POST',
                        processData: false,
                        contentType: false,
                        success: function(rs) {
                            $("html, body").animate({
                                scrollTop: 100
                            }, "slow");
                            frmMsg.html(rs.msg).slideDown(500);
                            if (rs.status == 1) {
                                toastr.success(rs.msg, "Success");
                                setTimeout(function() {
                                    frmIcon.addClass("hidden");
                                    form$[0].reset();
                                    window.location.href = rs.redirect_url;
                                }, 3000);
                            } else {
                                toastr.error(rs.msg, "Error");
                                setTimeout(function() {
                                    frmIcon.addClass("hidden");
                                    sbtn.attr("disabled", false);
                                }, 3000);
                            }
                        },
                        error: function(rs) {
                            // console.log(rs);
                            sbtn.attr("disabled", false);
                            toastr.error('Please try again or refresh your page.Error occur due to sever response!', "Error");
                        },
                        complete: function(rs) {
                            needToConfirm = false;
                        }
                    });
                } else if ($('input[name="payment_type"]:checked').val() == 'credit-card') {
                    object = $(this);
                    Stripe.card.createToken({
                        number: $('#cardnumber').val(),
                        cvc: $('#cvc').val(),
                        exp_month: $('#exp_month').val(),
                        exp_year: $('#exp_year').val(),
                        name: $('#card_holder_name').val()
                    }, stripeResponseHandler);
                    return false;
                }
            })
            Stripe.setPublishableKey('<?= API_PUBLIC_KEY; ?>');

            function stripeResponseHandler(status, response) {
                let form$ = $("#payment-form");
                let sbtn = form$.find("button[type='submit']");
                let frmIcon = form$.find("button[type='submit'] i.spinner");
                if (response.error) {
                    console.log(response.error.message)
                    toastr.error('<strong>Error:</strong> ' + response.error.message + '', "Error");
                    $('button[type="submit"]').prop('disabled', false);
                    frmIcon.addClass('hidden');
                } else {
                    let nonce = response['id'];
                    let frmData = new FormData(form$[0]);
                    let frmMsg = $('.alertMsg-form');
                    frmData.append('nonce', nonce);
                    object.append("<input type='hidden' name='nonce' value='" + nonce + "' />");
                    object.append("<input type='hidden' name='order_id' value='<?= doEncode($order->order_id) ?>' />");
                    $('.card_payment').prop('disabled', true);
                    $('.card_payment').parent().hide();
                    $.ajax({
                        url: form$.attr('action'),
                        data: object.serialize(),
                        dataType: 'JSON',
                        method: 'POST',
                        error: function(er) {
                            toastr.error('<div>Please try again or refresh your page.Error occur due to sever response!</div>', "Error");
                        },
                        success: function(rs) {
                            if (rs.scroll_top)
                                $("html, body").animate({
                                    scrollTop: 0
                                }, "slow");
                            if (rs.status == 1) {
                                toastr.success(rs.msg, "Success");
                                setTimeout(function() {
                                    $(".popup").fadeOut();
                                    $("html").removeClass("flow");
                                    $('#amended-invoice').empty().append(rs.html);
                                    if (rs.hide_msg)
                                        $('.alertMsg').slideUp(500);
                                    if (rs.redirect_url)
                                        window.location.href = rs.redirect_url;
                                }, 3000)
                            } else {
                                toastr.error(rs.msg, "Error");
                            }
                        },
                        complete: function() {
                            sbtn.attr("disabled", false);
                            frmIcon.addClass('hidden');
                        }
                    })
                }
            }
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>