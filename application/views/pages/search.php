<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="serve">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <!-- <section id="sBanner">
            <div class="contain">
                <div class="content">
                    <h2 class="heading"><?= $content['heading'] ?></h2>
                    <p><?= $content['header_detail'] ?></p>
                </div>
            </div>
            <div class="image"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image1']) ?>" alt=""></div>
        </section> -->
        <!-- sBanner -->


        <section id="srch">
            <div class="contain text-center">
                <form action="" method="post" id="formPlaceOrder" class="frmAjax" autocomplete="off">
                    <div class="blk">
                        <h2 class="heading">Place your Order</h2>
                        <?php if ($vendor->mem_company_pickdrop == 'yes') : ?>
                            <p class="small">Pickup & Delivery Service Available</p>
                            <div class="toggleBlk">
                                <strong>Use Service</strong>
                                <div class="switchBtn">
                                    <input type="checkbox" name="use_pickdrop" id="usePickAndDropService">
                                    <em></em>
                                </div>
                            </div>
                        <?php else : ?>
                            <p class="small">Pickup & Delivery Service Not Available</p>
                        <?php endif; ?>
                        <div class="">
                            <div class="side">
                                <?php if ($vendor->mem_company_pickdrop == 'yes' && $vendor->mem_company_walkin_facility == 'yes') : ?>
                                    <div class="txtGrp" id="businessAdress">
                                        <p><?= $vendor->mem_business_address ?> <br> <?= $vendor->mem_business_city ?> <br> <?= $vendor->mem_business_zip ?></p>
                                    </div>
                                    <div id="collectionArea" class="hidden">
                                        <h6>Collection</h6>
                                        <div class="formRow row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                                <div class="txtGrp">
                                                    <select name="collection_date" id="collection_date" class="txtBox selectpicker" data-container="body" onchange="fetchTime(this.value, '<?= $mem_id ?>', 'collection_time')">>
                                                        <?= open_days_options($open_days) ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                                <div class="txtGrp">
                                                    <select name="collection_time" id="collection_time" class="txtBox selectpicker" data-container="body">
                                                        <?= $coming_day_times ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="br"></div>
                                    </div>
                                <?php elseif ($vendor->mem_company_pickdrop == 'yes') : ?>
                                    <div id="collectionArea" class="hidden">
                                        <h6>Collection</h6>
                                        <div class="formRow row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                                <div class="txtGrp">
                                                    <select name="collection_date" id="collection_date" class="txtBox selectpicker" data-container="body" onchange="fetchTime(this.value, '<?= $mem_id ?>', 'collection_time')">
                                                        <?= open_days_options($open_days) ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                                <div class="txtGrp">
                                                    <select name="collection_time" id="collection_time" class="txtBox selectpicker" data-container="body">
                                                        <?= $coming_day_times ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="br"></div>
                                    </div>
                                <?php elseif ($vendor->mem_company_walkin_facility == 'yes') : ?>
                                    <div class="txtGrp" id="businessAdress">
                                        <p><?= $vendor->mem_business_address ?> <br> <?= $vendor->mem_business_city ?> <br> <?= $vendor->mem_business_zip ?></p>
                                    </div>
                                <?php endif; ?>
                                <h6 id="drop-delivery">Drop off</h6>
                                <input type="hidden" name="dropoffAddress" value="<?= $vendor->mem_business_address . '@' . $vendor->mem_business_city . '@' . $vendor->mem_business_zip ?>">
                                <div class="formRow row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <select name="delivery_date" id="delivery_date" class="txtBox selectpicker" data-container="body" onchange="fetchTime(this.value, '<?= $mem_id ?>', 'delivery_time')">
                                                <?= open_days_options($open_days) ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <select name="delivery_time" id="delivery_time" class="txtBox selectpicker" data-container="body">
                                                <?= $coming_day_times ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (empty($this->session->mem_id)) : ?>
                            <div class="btn_blk form_btn">
                                <button type="submit" class="site_btn"><i class="spinner hidden"></i>Place Order</button>
                            </div>
                            <?php else : if ($this->session->mem_type == 'buyer') : ?>
                                <div class="btn_blk form_btn">
                                    <button type="submit" class="site_btn"><i class="spinner hidden"></i>Place Order</button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </section>


        <!-- <section id="srch">
            <div class="contain">
                <h2 class="heading text-center">Best Deals in your Area</h2>
                <div class="srchBlk">
                    <form action="" method="post" id="formPlaceOrder" class="frmAjax" autocomplete="off">
                        <div class="inside">
                            <div class="icoBlk">
                                <div class="icon"><img src="<?= get_site_image_src("members", $vendor->mem_image, 'thumb_'); ?>" alt=""></div>
                                <h6><?= $vendor->mem_fname . ' ' . $vendor->mem_lname ?></h6>
                                <div class="rateYo" data-rateyo-rating="<?= get_mem_avg_rating($vendor->mem_id) ?>"></div>
                                <small><?= $miles ?> Miles Away</small>
                                <?php if ($vendor->mem_company_pickdrop == 'yes') : ?>
                                    <div class="fig"><img src="<?= base_url() ?>assets/images/vector-wait.svg" alt=""></div>
                                    <p class="small">Pickup & Delivery Service Available</p>
                                    <div class="toggleBlk">
                                        <strong>Use Service</strong>
                                        <div class="switchBtn">
                                            <input type="checkbox" name="use_pickdrop" id="usePickAndDropService">
                                            <em></em>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="fig"><img src="<?= base_url() ?>assets/images/vector-wait-cross.svg" alt=""></div>
                                    <p class="small">Pickup & Delivery Service Not Available</p>
                                <?php endif; ?>
                            </div>
                            <div class="txt">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Services</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th width="5%">Price</th>
                                        </tr>
                                        <?php
                                        $estimated_amount = 0;
                                        foreach ($services as $index => $value) :
                                            $row = sub_service_price($value->id, $mem_id);
                                            $estimated_amount += $row->price * $qty[$index];
                                        ?>
                                            <tr>
                                                <td><?= $value->name ?></td>
                                                <td>£<?= price_format($row->price) ?></td>
                                                <td><?= $qty[$index] ?></td>
                                                <td>£<?= price_format($row->price * $qty[$index]) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="color">£<?= price_format($estimated_amount) ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="hidden pickdrop_charges">
                                            <td></td>
                                            <td></td>
                                            <td class="color"><small>Pickup & Delivery Charges</small></td>
                                            <td>£<?= ($vendor->mem_charges_per_miles * 2) ?></td>
                                        </tr>
                                        <tr class="hidden">
                                            <td></td>
                                            <td></td>
                                            <td>Minimum Order</td>
                                            <td>£<?= price_format($vendor->mem_charges_min_order) ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <th class="color">Estimated Total</th>
                                            <th id="estimated-total" data-total="<?= price_format($estimated_amount) ?>">£<?= price_format($estimated_amount) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="side">
                                <?php if ($vendor->mem_company_pickdrop == 'yes' && $vendor->mem_company_walkin_facility == 'yes') : ?>
                                    <div class="txtGrp" id="businessAdress">
                                        <p><?= $vendor->mem_business_address ?> <br> <?= $vendor->mem_business_city ?> <br> <?= $vendor->mem_business_zip ?></p>
                                    </div>
                                    <div id="collectionArea" class="hidden">
                                        <h6>Collection</h6>
                                        <div class="formRow row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                                <div class="txtGrp">
                                                    <select name="collection_date" id="collection_date" class="txtBox selectpicker" data-container="body" onchange="fetchTime(this.value, '<?= $mem_id ?>', 'collection_time')">>
                                                        <?= open_days_options($open_days) ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                                <div class="txtGrp">
                                                    <select name="collection_time" id="collection_time" class="txtBox selectpicker" data-container="body">
                                                        <?= $coming_day_times ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="br"></div>
                                    </div>
                                <?php elseif ($vendor->mem_company_pickdrop == 'yes') : ?>
                                    <div id="collectionArea" class="hidden">
                                        <h6>Collection</h6>
                                        <div class="formRow row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                                <div class="txtGrp">
                                                    <select name="collection_date" id="collection_date" class="txtBox selectpicker" data-container="body" onchange="fetchTime(this.value, '<?= $mem_id ?>', 'collection_time')">
                                                        <?= open_days_options($open_days) ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                                <div class="txtGrp">
                                                    <select name="collection_time" id="collection_time" class="txtBox selectpicker" data-container="body">
                                                        <?= $coming_day_times ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="br"></div>
                                    </div>
                                <?php elseif ($vendor->mem_company_walkin_facility == 'yes') : ?>
                                    <div class="txtGrp" id="businessAdress">
                                        <p><?= $vendor->mem_business_address ?> <br> <?= $vendor->mem_business_city ?> <br> <?= $vendor->mem_business_zip ?></p>
                                    </div>
                                <?php endif; ?>
                                <h6 id="drop-delivery">Drop off</h6>
                                <input type="hidden" name="dropoffAddress" value="<?= $vendor->mem_business_address . '@' . $vendor->mem_business_city . '@' . $vendor->mem_business_zip ?>">
                                <div class="formRow row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <select name="delivery_date" id="delivery_date" class="txtBox selectpicker" data-container="body" onchange="fetchTime(this.value, '<?= $mem_id ?>', 'delivery_time')">
                                                <?= open_days_options($open_days) ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <select name="delivery_time" id="delivery_time" class="txtBox selectpicker" data-container="body">
                                                <?= $coming_day_times ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php if (empty($this->session->mem_id)) : ?>
                                    <div class="bTn formBtn">
                                        <button type="submit" class="webBtn blockBtn"><i class="spinner hidden"></i>Place Order</button>
                                    </div>
                                    <?php else : if ($this->session->mem_type == 'buyer') : ?>
                                        <div class="bTn formBtn">
                                            <button type="submit" class="webBtn blockBtn"><i class="spinner hidden"></i>Place Order</button>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <br>
                                <div class="alertMsg" style="display:none"></div>
                            </div>
                        </div>
                        <div class="btm">
                            <small class="red-color">Disclaimer: Price shown is the estimated cost I Hate Ironing has a minimum order value of $20 | $5 no show/cancellation fee.</small>
                        </div>
                    </form>
                </div>
            </div>
        </section> -->
        <!-- srch -->


        <script>
            $(window).on('load', function() {
                let disableDays = <?php echo json_encode($cdays); ?>;
                $('.datepickerWithDisabledDAys').datepicker({
                    startDate: new Date(),
                    format: 'mm-dd-yyyy',
                    todayHighlight: true,
                    multidateSeparator: ',  ',
                    templates: {
                        leftArrow: '<i class="fi-arrow-left"></i>',
                        rightArrow: '<i class="fi-arrow-right"></i>'
                    },
                    daysOfWeekDisabled: disableDays
                });
            });
            $(document).on('click', '#usePickAndDropService', (e) => {
                let pickdrop_charges = $('.pickdrop_charges');
                let services_total = $('#estimated-total').data('total');
                let pcharges = '<?= $vendor->mem_charges_per_miles * 2 ?>';
                if ($(e.target).is(':checked')) {
                    $('#businessAdress').addClass('hidden');
                    $('#collectionArea').removeClass('hidden');
                    pickdrop_charges.removeClass('hidden');
                    $('#estimated-total').text(`£${(parseFloat(services_total)+parseFloat(pcharges)).toFixed(2)}`);
                    $('#drop-delivery').html('Delivery');
                } else {
                    $('#businessAdress').removeClass('hidden');
                    $('#collectionArea').addClass('hidden');
                    pickdrop_charges.addClass('hidden');
                    $('#estimated-total').text(`£${services_total}`);
                    $('#drop-delivery').html('Drop off');
                }
            });
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>