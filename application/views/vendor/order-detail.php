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
                                <div class="status_btn_blk" id="order-status-dropdown">
                                    <?php echo order_status_dropdown($order->order_status, $order->order_id) ?>
                                </div>
                            </div>
                            <ul class="list">
                                <li>
                                    <strong>Customer Name:</strong>
                                    <span><?= $order->mem_fname . ' ' . $order->mem_lname ?></span>
                                </li>
                                <li>
                                    <strong>Phone Number:</strong>
                                    <span><?= $order->mem_phone ?></span>
                                </li>
                                <li>
                                    <strong>Email Address:</strong>
                                    <span><?= $order->mem_email ?></span>
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
                                    <?php if (!empty($order->collection_or_delivery_notes)) : ?>
                                        <li>
                                            <strong>Collection or delivery instructions:</strong>
                                            <span><?= $order->collection_or_delivery_notes ?></span>
                                        </li>
                                    <?php endif; ?>
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
                                    <?php if (!empty($order->extra_address_detail)) : ?>
                                        <li>
                                            <strong>Extra Address:</strong>
                                            <span><?= $order->extra_address_detail ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <strong>Customer Notes:</strong>
                                        <span>
                                            <textarea name="customer_notes" id="customer_notes" class="text_box form_blk" placeholder="Type Notes"><?= $order->order_note ?></textarea>
                                            <button type="button" class="site_btn md" id="save-notes" data-o-id="<?= doEncode($order->order_id) ?>">Save Notes</button>
                                        </span>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="top_head">
                    <h4>Order Summary - Invoice</h4>
                    <?php if (($order->order_status == 'New' || $order->order_status == 'In Progress')) : ?>
                        <div class="btn_blk" id="amend-invoice-div">
                            <button type="button" class="site_btn md light pop_btn" data-popup="amend-invoice"><img src="<?= base_url() ?>assets/images/icon-price-list.svg" alt=""> Amend Invoice</button>
                        </div>
                    <?php endif; ?>
                </div>
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
                                <?php else : ?>
                                <?php endif; ?>
                            </tfoot>
                        </table>
                        <div id="amended-invoice">
                            <?php echo amended_invoice($order->order_id, $amended); ?>
                        </div>
                    </div>
                </div>
                <?php echo get_delivey_proof($order->order_id) ?>
                <?php if ($delivery_proof && ($order->order_status == 'Delivered' || $order->order_status == 'In Progress')) : ?>
                    <div class="blk text-center" id="order-completion-section">
                        <h4>When you have completed the job, please mark it as done.</h4>
                        <div class="btn_blk form_btn">
                            <button type="button" class="site_btn pop_btn" data-popup="mark-complete" data-status="<?= $order->order_status ?>">Yes it's Done</button>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($review)) : ?>
                    <div class="review_blk blk">
                        <div class="review">
                            <div class="ico"><img src="<?= get_site_image_src("members", $review->mem_image, 'thumb_'); ?>" alt=""></div>
                            <div class="txt">
                                <div class="ico_txt">
                                    <div class="title">
                                        <h5><?= $review->mem_fname . ' ' . $review->mem_lname ?></h5>
                                        <div class="rateYo" data-rateyo-rating="<?= $review->rating ?>"></div>
                                    </div>
                                    <div class="date"><?= date_picker_format_date($review->review_date, 'D, d M Y', false) ?></div>
                                </div>
                                <p><?= $review->review_comment ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="popup sm" data-popup="amend-invoice">
                <div class="table_dv">
                    <div class="table_cell">
                        <div class="contain">
                            <div class="_inner">
                                <div class="cross_btn"></div>
                                <h3>Amend Invoice</h3>
                                <form action="<?= base_url() ?>vendor/amend_invoice" method="post" id="frmAmendInvoice" class="frmAmendInvoice">
                                    <div class="alertMsg" style="display:none"></div>
                                    <input type="hidden" name="order_id" value="<?= doEncode($order->order_id) ?>" />
                                    <div class="form_row row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h6>Title <sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="text" name="sub_service_name" id="sub_service_name" class="text_box" placeholder="eg: Lorem ipsum dollar site">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h6>Quantity <sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="text" name="quantity" id="quantity" class="text_box" placeholder="eg: 50">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h6>Unit Price <sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="text" name="sub_service_price" id="sub_service_price" class="text_box" placeholder="eg: 250">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_blk form_btn text-center">
                                        <button type="submit" class="site_btn block"><i class="spinner hidden"></i>Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup" data-popup="mark-complete">
                <div class="table_dv">
                    <div class="table_cell">
                        <div class="contain">
                            <div class="_inner">
                                <div class="cross_btn"></div>
                                <h3>You have complete the job</h3>
                                <form action="<?= base_url() ?>vendor/complete_order" method="post" class="frmCompleteOrder">
                                    <div class="alertMsg" style="display:none"></div>
                                    <input type="hidden" name="order_id" value="<?= doEncode($order->order_id) ?>" />
                                    <div class="form_row row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h6>Order Photo <sup>*</sup></h6>
                                            <div class="form_blk">
                                                <button type="button" class="text_box uploadImg" data-upload="bag_pic" data-text="Choose file"></button>
                                                <a class="image-proof">
                                                    <img src="" alt="" data-src="" id="uploadProofImage">
                                                </a>
                                                <input type="file" name="proof_image" id="proof_image" class="uploadFile" data-upload="bag_pic" onchange="PreviewImage();">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h6>Comments</h6>
                                            <div class="form_blk">
                                                <textarea name="proof_comment" id="proof_comment" class="text_box" placeholder="Type something here"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_blk form_btn text-center"><button type="submit" class="site_btn long"><i class="spinner hidden"></i>Submit</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- orders -->


        <script>
            function PreviewImage() {
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("proof_image").files[0]);
                oFReader.onload = function(oFREvent) {
                    document.getElementById("uploadProofImage").src = oFREvent.target.result;
                    $("#uploadProofImage").attr('data-src', oFREvent.target.result);
                };
            };

            $(function() {
                $(document).on('click', '.order-status', function(e) {
                    e.preventDefault();
                    var current = $(this);
                    let statusToChange = current.data('status');
                    let order_id = current.data('order-id');
                    $.ajax({
                        url: base_url + 'vendor/change_order_status',
                        data: {
                            'statusToChange': statusToChange,
                            'order_id': order_id
                        },
                        dataType: 'JSON',
                        method: 'POST',
                        success: function(rs) {
                            if (rs.status == 'success')
                                location.reload();
                        },
                        complete: function() {}
                    })
                })
            });

            $(function() {
                $(document).on('click', '#save-notes', function(e) {
                    e.preventDefault();
                    var current = $(this);
                    let order_id = current.data('o-id');
                    let notes = $('#customer_notes').val();
                    $.ajax({
                        url: base_url + 'vendor/save_notes',
                        data: {
                            'notes': notes,
                            'order_id': order_id
                        },
                        dataType: 'JSON',
                        method: 'POST',
                        success: function(rs) {
                            if (rs.status == 'success')
                                toastr.success("Notes saved successfully.", "Success");
                        },
                        complete: function() {}
                    })
                })
            });
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>