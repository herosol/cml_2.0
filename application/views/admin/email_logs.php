<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?php echo getBredcrum(ADMIN, array('#' => 'Add/Update Email Logs')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-chat "></i> Email Logs </h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?php echo base_url('admin/email_logs'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <div class="clearfix"></div>
        <div class="panel-body">

            <div class="row">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><strong>Proof ID : </strong></td>
                            <td><?php echo $row->proof_id; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Order No : </strong></td>
                            <td><?php echo num_size($proof->order_id); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Date : </strong></td>
                            <td><?php $time = strtotime($row->date); echo date("D, d M Y H:i:s", $time); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email : </strong></td>
                            <td><?php echo $row->ebody; ?></td>
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
    <?php echo getBredcrum(ADMIN, array("#" => "Email Logs")); ?>

    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-chat" aria-hidden="true"></i> Manage <strong> Email Logs</strong></h2>
        </div>
        <div class="col-md-6 text-right">
    <!--            <a href="<?php echo base_url('admin/what/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>-->
        </div>
    </div>
    <br>
    <form method="post" action="<?=base_url('admin/email_logs/deleteAll')?>">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th width="" class="text-center no_order" style="">
                        <button type="submit" onclick="return confirm('Are you sure to delete?');" name="delete_selected" class="btn btn-sm btn-danger">Delete</button>
                    </th>
                    <th width="5%" class="text-center">Sr#</th>
                    <th width="" class="text-center">Proof ID</th>
                    <th width="" class="text-center">Date</th>
                    <th width="" class="text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rows) > 0): $count = 0; ?>
                    <?php foreach ($rows as $row): ?>
                        <?php $time = strtotime($row->date); ?>
                        <tr  class="odd gradeX status_tr">
                            <td class="text-center">
                                <input type="checkbox" name="checkbox_id[]" class="select_checkbox" value="<?= $row->id ?>">
                            </td>
                            <td class="text-center"><?php echo ++$count; ?></td>
                            <td class="text-center"><?= $row->proof_id ?></td>
                            <td class="text-center"><?php echo date("D, d M Y H:i:s", $time); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-primary" role="menu" style="right:0 !important;left:inherit">
                                        <li><a href="<?php echo base_url(); ?>admin/email_logs/manage/<?php echo $row->id; ?>/<?php echo $row->slug; ?>">View</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/email_logs/delete/<?php echo $row->id; ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
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