<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Delivery Proof Management')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="fa fa-bars"></i> Order <strong>Detail</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/delivery_proof'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th><b>Order Number :</b></th>
                        <td><?= num_size($row->order_id);?></td>
                    </tr>
                    <tr>    
                        <th><b>Date :</b></th>
                        <td><?= format_date($row->date);?></td>
                    </tr>
                    <tr>    
                        
                        <th><b>Proof Image :</b></th>
                        <td><img height="360" src="<?= !empty($row->proof_image) ? get_site_image_src("orders", $row->proof_image) : 'http://placehold.it/700x620' ?>" alt="--"></td>
                    </tr>
                    <tr>    
                        <th><b>Comment :</b></th>
                        <td><?= ($row->proof_comment);?></td>
                    </tr>
                </tbody>
            </table>

           
            <br>
            <hr class="hr-short">
            <br>
            <form action=""  role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label class="control-label">Proof Status</label>
                        <select name="status" id="status" class="form-control">
                            <?php foreach (proof_status() as $val) : ?>
                                <option value="<?= $val ?>" <?= $row->order_status == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                            <?php endforeach; ?>
                        </select>
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
    <?= getBredcrum(ADMIN, array('#' => 'Delivery Proof Management')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-12">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage Delivery Proof</h2>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="8%" class="text-center">Order Number</th>
                <th>Proof Image</th>
                <th>Proof Comment</th>
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
                        <td><img height="90" src="<?= !empty($row->proof_image) ? get_site_image_src("orders", $row->proof_image) : 'http://placehold.it/700x620' ?>" alt="--"></td>
                        <td><b><?= short_text($row->proof_comment,50) ?></b></td>s
                        <td><?= format_date($row->date,'M d, Y h:i:s a'); ?></td>
                        <td><?= get_proof_status_label($row->status)?></td>
                        <td class="text-center">
                            <a href="<?= site_url(ADMIN.'/delivery_proof/manage/'.$row->proof_id); ?>" class="btn btn-primary btn-sm">View</a>
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