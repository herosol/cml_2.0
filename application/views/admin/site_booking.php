<?php echo getBredcrum(ADMIN, array('#' => 'Booking Page')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Booking Page</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <!--<a href="<?php echo base_url('admin/search'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>-->
    </div>
</div>
<div>
    <hr>
    <div class="clearfix"></div>
    <div class="panel-body">
        <form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" enctype="multipart/form-data">
            <h3>Main Section</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Right Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image1']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image1']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image1" accept="image/*" <?php if (empty($row['image1'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
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
                                <label for="heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                                <input type="text" name="heading" id="heading" value="<?= $row['heading'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="header_detail" class="control-label"> Detail <span class="symbol ">*</span></label>
                                <textarea name="header_detail" id="header_detail" rows="4" class="form-control"><?= $row['header_detail'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h3>Step 1 (Vendor)</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Step Icon
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image2']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image2']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image2" accept="image/*" <?php if (empty($row['image1'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
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
                                <label for="step1_title" class="control-label"> Title <span class="symbol ">*</span></label>
                                <input type="text" name="step1_title" id="step1_title" value="<?= $row['step1_title'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="step1_desc" class="control-label"> Details <span class="symbol ">*</span></label>
                                <input type="text" name="step1_desc" id="step1_desc" value="<?= $row['step1_desc'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="step1_heading" class="control-label">Content Heading <span class="symbol required">*</span></label>
                                <input type="text" name="step1_heading" id="step1_heading" value="<?= $row['step1_heading'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Step 1 Cards</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Card Icon
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image7']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image7']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image7" accept="image/*" <?php if (empty($row['image7'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="" class="control-label"> Heading <span class="symbol ">*</span></label>
                                <input type="text" name="instruction1_heading" id="instruction1_heading" value="<?= $row['instruction1_heading'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="control-label">Details <span class="symbol required">*</span></label>
                                <input type="text" name="instruction1_detail" id="instruction1_detail" value="<?= $row['instruction1_detail'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Card Icon
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image8']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image8']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image8" accept="image/*" <?php if (empty($row['image8'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="" class="control-label"> Heading <span class="symbol ">*</span></label>
                                <input type="text" name="instruction2_heading" id="instruction2_heading" value="<?= $row['instruction2_heading'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="control-label">Details <span class="symbol required">*</span></label>
                                <input type="text" name="instruction2_detail" id="instruction2_detail" value="<?= $row['instruction2_detail'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Card Icon
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image9']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image9']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image9" accept="image/*" <?php if (empty($row['image9'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="instruction3_heading" class="control-label"> Heading <span class="symbol ">*</span></label>
                                <input type="text" name="instruction3_heading" id="instruction3_heading" value="<?= $row['instruction3_heading'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="instruction3_detail" class="control-label">Details <span class="symbol required">*</span></label>
                                <input type="text" name="instruction3_detail" id="instruction3_detail" value="<?= $row['instruction3_detail'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Step 1.1 (Collection & Delivery)</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Step Icon
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image3']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image3']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image3" accept="image/*" <?php if (empty($row['image3'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
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
                                <label for="" class="control-label"> Title <span class="symbol ">*</span></label>
                                <input type="text" name="step2_title" id="step2_title" value="<?= $row['step2_title'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="control-label">Content Heading <span class="symbol required">*</span></label>
                                <input type="text" name="step2_heading" id="step2_heading" value="<?= $row['step2_heading'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="control-label">Map Heading <span class="symbol required">*</span></label>
                                <input type="text" name="step2_map_heading" id="step2_map_heading" value="<?= $row['step2_map_heading'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Step 2 (Services)</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Step Icon
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image4']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image4']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image4" accept="image/*" <?php if (empty($row['image4'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
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
                                <label for="" class="control-label"> Title <span class="symbol ">*</span></label>
                                <input type="text" name="step3_title" id="step3_title" value="<?= $row['step3_title'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="control-label">Content Heading <span class="symbol required">*</span></label>
                                <input type="text" name="step3_heading" id="step3_heading" value="<?= $row['step3_heading'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Step 3 (Address)</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Step Icon
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image5']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image5']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image5" accept="image/*" <?php if (empty($row['image5'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
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
                                <label for="" class="control-label"> Title <span class="symbol ">*</span></label>
                                <input type="text" name="step4_title" id="step4_title" value="<?= $row['step4_title'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="" class="control-label">Content Heading <span class="symbol required">*</span></label>
                                <input type="text" name="step4_heading" id="step4_heading" value="<?= $row['step4_heading'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Step 4 (Contact & Payment)</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Step Icon
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image6']) ? getImageSrc(UPLOAD_PATH . "images/", $row['image6']) : 'http://placehold.it/3000x1000' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image6" accept="image/*" <?php if (empty($row['image6'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
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
                                <label for="step5_title" class="control-label"> Title <span class="symbol ">*</span></label>
                                <input type="text" name="step5_title" id="step5_title" value="<?= $row['step5_title'] ?>" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="step5_heading" class="control-label">Content Heading <span class="symbol required">*</span></label>
                                <input type="text" name="step5_heading" id="step5_heading" value="<?= $row['step5_heading'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <h3>Page Section</h3>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="page_heading" class="control-label"> Heading <span class="symbol required"></span></label>
                    <input type="text" name="page_heading" id="page_heading" value="<?= $row['page_heading'] ?>" class="form-control" >
                </div>
            </div> -->
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