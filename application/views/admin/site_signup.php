<?php echo getBredcrum(ADMIN, array('#' => 'Sign up')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Sign up</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <!--        <a href="<?php echo base_url('admin/terms_conditions'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>-->
    </div>
</div>
<div>
    <hr>
    <div class="clearfix"></div>
    <div class="panel-body">
        <form role="form"  method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" enctype="multipart/form-data">
            <h3>Main Section</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Left Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image1']) ? getImageSrc(UPLOAD_PATH."images/", $row['image1']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image1" accept="image/*" <?php if(empty($row['image1'])){echo 'required=""';}?>>
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="heading" class="control-label">Left Heading <span class="symbol required">*</span></label>
                                <input type="text" name="heading" id="heading" value="<?= $row['heading'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label for="detail" class="control-label">Left Detail <span class="symbol ">*</span></label>
                                <textarea name="detail" id="detail" rows="4" class="form-control"><?= $row['detail'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Form Section</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="form_heading1" class="control-label">Individual Form Heading <span class="symbol required">*</span></label>
                        <input type="text" name="form_heading1" id="form_heading1" value="<?= $row['form_heading1'] ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="form_heading2" class="control-label">Vendor Form Heading <span class="symbol required">*</span></label>
                        <input type="text" name="form_heading2" id="form_heading2" value="<?= $row['form_heading2'] ?>" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="field-1" class="col-sm-2 control-label "></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>
</div>