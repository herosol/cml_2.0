<?php if ($this->uri->segment(3) == 'detail'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Detail Withdraw Request')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> <strong>Withdraw</strong> Detail</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/withdraws'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="<?= site_url(ADMIN.'/withdraws/mark_paid/'.$row->id)?>" name="frmPartner" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td><?= ucwords($member->mem_fname.' '.$member->mem_lname)?></td>
                        <td><strong>Date:</strong></td>
                        <td><?= format_date($row->date ,'M d, Y H:i A')?></td>
                    </tr>
                    <tr>
                        <td><strong>Total Amount:</strong></td>
                        <td><span style="font-size:14px; font-weight: bold; color:green">£<?= price_format($row->amount)?></span></td>
                        <td><strong>Status:</strong></td>
                        <td><?= get_paid_status_withdraws($row->status)?></td>
                    </tr>
                    <?php if($row->status== 'completed'):?>
                        <tr>
                            <td><strong>Paid Date:</strong></td>
                            <td><?= format_date($row->paid_date ,'M d, Y H:i A')?></td>
                        </tr>
                    <?php endif?>
                </tbody>
            </table>
            <h3>Payment Method <strong><?=$row->payment_method == 'bank-account' ? 'Bank Account' : 'Paypal'?></strong></h3>
            <?php if($row->payment_method == 'bank-account'): ?>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Bank Name:</strong></td>
                            <td><?= $bank->bank_name?></td>
                            <td><strong>Account Number:</strong></td>
                            <td><?= $bank->account_number?></td>
                        </tr>
                        <tr>
                            <td><strong>Short Code:</strong></td>
                            <td><?= $bank->short_code?></td>
                            <td><strong>Beneficiary Name:</strong></td>
                            <td><?= $bank->beneficiary_name?></td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Paypal Address:</strong></td>
                            <td><?= $row->paypal_address?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            <h3>Orders</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Order</th>
                        <th>Amount</th>
                        <th>Transaction Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($with_trxs as $key => $trx): ?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td><a href="<?= site_url(ADMIN.'/orders/detail/'.$trx->order_id)?>" target="__blank">Order No. <?= num_size($trx->order_id)?></a></td>
                            <td><?= format_amount($trx->amount)?></td>
                            <td><?= format_date($trx->date ,'M d, Y H:i A')?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php if($row->status == 'pending'):?>
                <div class="form-group text-right">
                    <div class="col-md-12">
                        <button type="submit" onClick="return confirm('Complete this transaction you should have to pay this amount manually to the user! Are you sure mark paid that amount?')" class="btn btn-primary btn-lg col-md-2 pull-right"><i class="fa fa-save"></i> Mark Complete</button>
                    </div>
                </div>
            <?php endif?>
            </form>
        </div>
    </div>
<?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => $page_tittle)); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-12">
            <h2 class="no-margin"><i class="entypo-list"></i> <?= $page_tittle ?> </h2>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Member</th>
                <th>Date</th>
                <th>Amount</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) > 0): $count = 0; ?>
                <?php foreach ($rows as $row): ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><b><a href="<?= site_url(ADMIN.'/vendors/manage/'.$row->mem_id); ?>" target="_blank"><?= get_mem_name($row->mem_id); ?></a></b></td>
                        <td><?= format_date($row->date, 'M d, Y h:m:i a'); ?></td>
                        <td><?= format_amount($row->amount); ?></td>
                        <td class="text-center">
                            <a href="<?= site_url(ADMIN.'/withdraws/detail/'.$row->id); ?>" class="btn btn-primary btn-sm">View</a>
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