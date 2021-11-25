<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?php echo getBredcrum(ADMIN, array('#' => 'View Invoices')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-chat "></i> Invoices </h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?php echo base_url('admin/invoices'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <div class="clearfix"></div>
        <div class="panel-body">

            <div class="row">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><strong> Order Number : </strong></td>
                            <td>
                                <a href="<?php echo base_url(); ?>admin/orders/detail/<?php echo $row->order_id; ?> ">
                                    <?php echo num_size($row->order_id); ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Payment Method : </strong></td>
                            <td><?php echo $row->payment_method; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Invoice Type : </strong></td>
                            <td><?php echo $row->invoice_type; ?></td>
                        </tr>
                        <?php if(!empty($row->charge_id)){ ?>
                        <tr>
                            <td><strong>Charge ID : </strong></td>
                            <td><?php echo $row->charge_id; ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td><strong>Payment Status : </strong></td>
                            <td><?php echo $row->payment_status; ?></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            <br>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(ADMIN, array("#" => "Invoices")); ?>

    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-chat" aria-hidden="true"></i> Manage <strong> Invoices</strong></h2>
        </div>
        <div class="col-md-6 text-right">
    <!--<a href="<?php echo base_url('admin/what/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>-->
        </div>
    </div>
    <br>
    <form method="post" action="<?=base_url('admin/invoices/deleteAll')?>">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <!-- <th width="" class="text-center no_order" style="">
                        <button type="submit" onclick="return confirm('Are you sure to delete?');" name="delete_selected" class="btn btn-sm btn-danger">Delete</button>
                    </th> -->
                    <th width="5%" class="text-center">Sr#</th>
                    <th width="" class="text-center">Order ID</th>
                    <th width="" class="text-center">Payment Method</th>
                    <th width="" class="text-center">Invoice Type</th>
                    <th width="" class="text-center">Status</th>
                    <th width="" class="text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rows) > 0): $count = 0; ?>
                    <?php foreach ($rows as $row): ?>
                        <tr  class="odd gradeX status_tr">
                            <!-- <td class="text-center">
                                <input type="checkbox" name="checkbox_id[]" class="select_checkbox" value="<?= $row->id ?>">
                            </td> -->
                            <td class="text-center"><?php echo ++$count; ?></td>
                            <td class="text-center"><?= num_size($row->order_id) ?></td>
                            <td class="text-center"><?= $row->payment_method ?></td>
                            <td class="text-center"><?= $row->invoice_type ?></td>
                            <td class="text-center"><?= $row->payment_status ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-primary" role="menu" style="right:0 !important;left:inherit">
                                        <li><a href="<?php echo base_url(); ?>admin/invoices/changestatus/<?php echo $row->invoice_id; ?> ">
                                        <?= $row->payment_status == 'paid' ? 'Mark as Pending' : 'Mark as Paid'; ?>
                                        </a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/invoices/manage/<?php echo $row->invoice_id; ?>/<?php echo $row->slug; ?>">View</a></li>
                                        <!-- <li><a href="<?php echo base_url(); ?>admin/invoices/delete/<?php echo $row->invoice_id; ?>" onclick="return confirm('Are you sure?');">Delete</a></li> -->
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php endif; ?>