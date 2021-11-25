<?php if ($this->uri->segment(3) == 'detail'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Product Orders Management')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="fa fa-bars"></i> Order <strong>Detail</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/orders'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Order Number</th>
                        <td><?= num_size($row->order_id);?></td>
                        
                        <th>Status</th>
                        <td><?= get_order_status_label($row->order_status);?></td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td><b><?= ($row->buyer_fname) ?></b></td>
                        <th>Last Name</th>
                        <td><?= ($row->buyer_lname);?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><b><?= ($row->buyer_phone) ?></b></td>
                        <th>Date</th>
                        <td><?= format_date($row->order_date, 'M d, Y h:i:s a');?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= ($row->buyer_email )?></td>
                        <?php if($row->order_status == 'Completed'){ ?>
                            <th>Delivered Date</th>
                            <td><?= format_date($row->delivery_date, 'M d, Y h:i:s a');?></td>
                        <?php } ?>
                        <?php if($row->order_status == 'Delivered' || $row->order_status == 'New' || $row->order_status == 'InProgress'){ ?>
                            <th>Cancelled Request</th>
                            <td><?= ($row->cancel_request);?></td>
                        <?php } ?>
                        <?php if($row->order_status == 'Cancelled' ){ ?>
                            <th>Cancelled ON</th>
                            <td><?= format_date($row->cancelled_on, 'M d, Y h:i:s a');?></td>
                        <?php } ?>
                    <tr>
                    <?php if($row->cancel_request){ ?>
                    <tr>
                        <th>Cancel Request By</th>
                        <td><?= $row->cancel_request ?></td>
                        <th>Cancel Request By</th>
                        <td><?= $row->cancel_request_by ?></td>
                    <tr>
                        <th>Cancel Request Reason</th>
                        <td colspan="3"><?= $row->city?></td>
                    </tr>
                    <?php } ?>
                    
                </tbody>
            </table>

            <hr>
            <h3><i class="fa fa-shopping-cart"></i> Order Products</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Sub Service</th>
                        <th>price</th>
                        <th>Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $gtotal = 0?>
                    <?php foreach ($row->products as $key => $pro): ?>
                        <?php
                        $total = floatval($pro->quantity*$pro->sub_service_price);
                        $gtotal += $total;
                        ?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td>
                                 <a href="<?= site_url(ADMIN.'/services/manage/'.$pro->service_id); ?>" target="_blank"><b><?= get_servicename($pro->service_id); ?></b></a>
                            </td>
                            <td>
                                 <a href="<?= site_url(ADMIN.'/sub_services/manage/'.$pro->id); ?>" target="_blank"><b><?= $pro->name; ?></b></a>
                            </td>
                            <td><?= $pro->sub_service_price?></td>
                            <td><?= $pro->quantity?></td>
                            <td class="text-right"><?= format_amount($total)?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right bold"> Services Total</th>
                        <td class="text-right"><b>£<?=order_total_price($row->order_id, 'SERVICES')?></b></td>
                    </tr>
                    <?php if (!empty($row->pick_and_drop_charges)): ?>
                        <tr>
                            <th colspan="5" class="text-right bold">Pick and Drop Charges </th>
                            <td class="text-right"><b><?= format_amount($row->pick_and_drop_charges)?></b></td>
                        </tr>
                    <?php endif ?>
                    <?php if (!empty($row->buyer_credit_discount)): ?>
                        <tr>
                            <th colspan="5" class="text-right bold"> Discount</th>
                            <td class="text-right">£<?=price_format($row->buyer_credit_discount)?></td>
                        </tr>
                    <?php endif ?>
                    <!-- <tr>
                        <th colspan="5" class="text-right bold">Shipping Fee</th>
                        <td class="text-right"><b><?= empty($adminsite_setting->site_shipping_fee) ? "Free" : format_amount( $adminsite_setting->site_shipping_fee)?></b></td>
                    </tr> -->
                    <tr>
                        <th colspan="5" class="text-right bold">Grand Total</th>
                        <td class="text-right"><b>£<?= order_total_price($row->order_id)?></b></td>
                    </tr>
                </tfoot>
            </table>
            <?php if($row->pick_and_drop_service){ ?>
            <h2 class="no-margin"><i class="fa fa-bars"></i> Pick and Drop <strong>Details</strong></h2>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Pick and Drop Off Services</th>
                        <td><?= ($row->pick_and_drop_service) ? 'Yes' : 'No' ?></td>
                        <th>Delivery Charges</th>
                        <td><b><?= format_amount($row->pick_and_drop_charges) ?></b></td>
                    </tr>
                    <tr>
                        <th>Collection Date</th>
                        <td><?=  format_date($row->collection_date) ?></td>
                        <th>Delivery Date</th>
                        <td><?=  format_date($row->delivery_date) ?></td>
                    </tr>
                    <tr>
                        <th>Collection Time</th>
                        <td><b><?= $row->collection_time ?></b></td>
                        <th>Delivery Time</th>
                        <td><?= $row->delivery_time ?></td>
                    <tr>
                    <tr>
                        <th>Collection Address</th>
                        <td><?= $row->collection_from ?></td>
                        <th>Delivery Address</th>
                        <td><?= $row->delivery_to ?></td>
                    <tr>
                </tbody>
            </table>
            <?php }else{ ?>
            <h2 class="no-margin"><i class="fa fa-bars"></i> Pick and Drop <strong>Details</strong></h2>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Pick and Drop Off Services</th>
                        <td><?= ($row->pick_and_drop_service) ? 'Yes' : 'No' ?></td>
                        <th>Address</th>
                        <td><b><?= ($row->address) ?></b></td>
                    </tr>
                    <tr>
                        <th>Drop Off Date</th>
                        <td><?= format_date($row->delivery_date) ?></td>
                        <th>Drop Off Time</th>
                        <td><b><?= ($row->delivery_time) ?></b></td>
                    </tr>
                </tbody>
            </table>
            <?php } ?>

            <hr>
            <h3><i class="fa fa-truck"></i> Vendor Detail</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><?= $vendor->mem_fname.' '.$vendor->mem_lname?></td>
                        <th> Email</th>
                        <td><?= $vendor->mem_email ?></td>
                        <th>Company Name</th>
                        <td><?= $vendor->mem_company_name ?></td>
                        <th>Company Phone</th>
                        <td><?= $vendor->mem_company_phone ?></td>
                    </tr>
                    <tr>
                        <th>Company Email</th>
                        <td><?= $vendor->mem_company_email ?></td>
                        <th>Company Order Email</th>
                        <td><?= $vendor->mem_order_email ?></td>
                        <th>City</th>
                        <td><?= $vendor->mem_business_city ?></td>
                        <th>State</th>
                        <td><?= get_state_name($vendor->mem_business_state) ?></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><?= get_country_name($vendor->mem_business_country) ?></td>
                        <th>Zip Code</th>
                        <td><?= $vendor->mem_business_zip?></td>
                        <th colspan="2">Address</th>
                        <td colspan="2"><?= $vendor->mem_business_address?></td>
                    </tr>
                </tbody>
            </table>
            
            <hr>
            <h3><i class="fa fa-truck"></i> Buyer Detail</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><?= $buyer->bmem_fname.' '.$buyer->mem_lname ?></td>
                        <th> Phone</th>
                        <td><?= $buyer->mem_phone?></td>
                        <th>Email</th>
                        <td><?= $buyer->memr_email?></td>
                        <th>Address Type</th>
                        <td><?= $row->address_type ?></td>
                    </tr>
                    <?php if($row->address_type == 'home'){ ?>
                        <tr>
                            <th>City</th>
                            <td><?= $buyer->mem_city ?></td>
                            <th>State</th>
                            <td><?= get_state_name($buyer->mem_state) ?></td>
                            <th>Country</th>
                            <td><?= get_country_name($buyer->mem_country) ?></td>
                            <th>Zip Code</th>
                            <td><?= $buyer->mem_zip?></td>
                        </tr>
                        <tr>
                            <th colspan="1">Address</th>
                            <td colspan="3"><?= $buyer->mem_address?></td>
                        </tr>
                    <?php }  if($row->address_type == 'hotel'){ ?>
                        <tr>
                            <th>City</th>
                            <td><?= $buyer->mem_hotel_city ?></td>
                            <th>State</th>
                            <td><?= get_state_name($buyer->mem_hotel_state) ?></td>
                            <th>Country</th>
                            <td><?= get_country_name($buyer->mem_hotel_country) ?></td>
                            <th>Zip Code</th>
                            <td><?= $buyer->mem_hotel_zip?></td>
                        </tr>
                        <tr>
                            <th colspan="4">Address</th>
                            <td colspan="4"><?= $buyer->mem_hotel_address?></td>
                        </tr>
                    <?php }  if($row->address_type == 'office'){ ?>
                        <tr>
                            <th>City</th>
                            <td><?= $buyer->mem_business_city ?></td>
                            <th>State</th>
                            <td><?= get_state_name($buyer->mem_business_state) ?></td>
                            <th>Country</th>
                            <td><?= get_country_name($buyer->mem_business_country) ?></td>
                            <th>Zip Code</th>
                            <td><?= $buyer->mem_business_zip?></td>
                        </tr>
                        <tr>
                            <th colspan="4">Address</th>
                            <td colspan="4"><?= $buyer->mem_business_address ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>
            <br>
            <hr class="hr-short">
            <br>
            <br>
            <form action=""  role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label class="control-label"> Status</label>
                        <select name="order_status" id="order_status" class="form-control">
                            <?php foreach (order_status() as $val) : ?>
                                <option value="<?= $val ?>" <?= $row->order_status == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label class="control-label">Add Note</label>
                        <textarea class="form-control" rows="4" name="order_note"><?= isset($row->order_note) ?  $row->order_note : '' ?></textarea>
                    </div>
                    
                    <div class="col-md-4"></div>
                    <!-- <div class="col-md-9">
                        <label class="control-label" for="shipping_msg"> Shipping Message</label>
                        <input type="text" name="shipping_msg" id="shipping_msg" value="<?php if (isset($row->shipping_msg)) echo $row->shipping_msg; ?>" class="form-control">
                    </div> -->
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">     
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> Save Status</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Product Orders Management')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-12">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage Orders</h2>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="8%" class="text-center">Order ID</th>
                <th>Customer Name</th>
                <th>Vendor Name</th>
                <th>Amount</th>
                <th>Date</th>
                <th width="5%">Status</th>
                <th width="12%" class="text-center">Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) > 0): $count = 0; ?>
                <?php foreach ($rows as $row): ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td class="text-center"><?= num_size($row->order_id); ?></td>
                        <td><b><?= $row->buyer_fname.' '.$row->buyer_lname?></b></td>
                        <td><b><?= get_mem_name($row->vendor_id) ?></b></td>s
                        <td><?= format_amount($row->product_total-$row->discount_amount+$row->tax_amount+$row->shipping_fee)?></td>
                        <td><?= format_date($row->order_date,'M d, Y h:i:s a'); ?></td>
                        <td><?= get_order_status_label($row->order_status)?></td>
                        <td class="text-center">
                            <a href="<?= site_url(ADMIN.'/orders/detail/'.$row->order_id); ?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
<script type="text/javascript">
    (function($){
        $(function(){

        })
    }(jQuery))
</script>