<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update services')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Services</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= base_url(ADMIN . '/services'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmGuide Categoreis" role="form" class="form-horizontal blog-form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-eye" aria-hidden="true"></i> Display Options</div>
                                <div class="panel-body" style="padding: 15.5px 0px">
                                    <div class="col-md-3">
                                        <h5>Status</h5>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="btn-group" id="status" data-toggle="buttons">
                                            <label class="btn btn-default btn-on btn-sm <?php if($row->status == 1){echo 'active';}?>">
                                            <input type="radio" value="1" name="status"<?php if($row->status == 1){echo 'checked';}?>><i class="fa fa-check" aria-hidden="true"></i></label>
                                          
                                            <label class="btn btn-default btn-off btn-sm <?php if($row->status == 0){echo 'active';}?>">
                                            <input type="radio" value="0" name="status" <?php if($row->status == 0){echo 'checked';}?>><i class="fa fa-times" aria-hidden="true"></i></label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                    </div>
                </div>  
                <div style="margin:45px 0px" class="">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                 Image
                            </div>
                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <?php
                        get_site_image_src("images", $row->image);
                    ?>
                    <div class="panel-body">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                <img src="<?= !empty($row->image) ? get_site_image_src("services", $row->image) : 'http://placehold.it/700x620' ?>" alt="--">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                        <div>
                        <span class="btn btn-black btn-file">
                            <span class="fileinput-new">Select image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="image" accept="image/*" <?php if(empty($row->image)){echo 'required=""';}?>>
                        </span>
                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                    </div>
                </div>    
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label" for="name"> Name</label>
                        <input type="text" name="name" id="name" value="<?php if (isset($row->name)) echo $row->name; ?>" class="form-control" autofocus required>
                    </div>
                </div> 
				<div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label" for="description">Details</label>
                        <textarea type="text" name="details" id="details" class="form-control ck-editor" required><?php if (isset($row->details)) echo $row->details; ?></textarea>
                    </div>
                </div>
              <hr>			
                <div class="form-group text-right">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage services')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>services</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= base_url(ADMIN . '/services/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>
    <form method="post" action="<?=base_url('admin/services/deleteAll')?>">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <!-- <th width="" class="text-center no_order" style="">
                    <button type="submit" onclick="return confirm('Are you sure to delete?');" name="delete_selected" class="btn btn-sm btn-danger">Delete</button>
                </th> -->
                <th width="5%" class="text-center">Sr#</th>
                <th>Image</th>
                <th>Name</th>
                <th>details</th>
                <th>Added Date</th>
                <th>Deleted Date</th>
                <th>Status</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) > 0): $count = 0; ?>
                <?php foreach ($rows as $row): ?>
                    <tr class="odd gradeX">
                        <!-- <td class="text-center">
                            <input type="checkbox" name="checkbox_id[]" class="select_checkbox" value="<?= $row->id ?>">
                        </td> -->
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><img src="<?= !empty($row->image) ? get_site_image_src("services", $row->image) : 'http://placehold.it/3000x1000' ?>" alt="--" height="80" class="image"></td>
                        <td><b><?= $row->name; ?></b></td>
                        <td><b><?= $row->details?></b></td>
                        <td><b><?= $row->added_date?></b></td>
                        <td><b>
                            <?php if($row->status == '1'){
                                echo '-';
                            }else{
                            echo $row->deleted_date ;
                            } ?>
                        </b></td>
                        <td><?=get_active_status($row->status)?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" style="left:inherit;right:0;" role="menu">
                                    <li><a href="<?= site_url(ADMIN.'/services/manage/'.$row->id); ?>">Edit</a></li>
                                    <!-- <li><a href="<?= site_url(ADMIN.'/services/delete/'.$row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li> -->
                                    <li>
                                        <a href="<?= site_url(ADMIN.'/services/changestatus/'.$row->id); ?>" onclick="return confirm('Do you want to change status?');">
                                            <?php if($row->status == '1'){
                                                echo 'Inactive';
                                            }else{
                                            echo 'Active' ;
                                            } ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
