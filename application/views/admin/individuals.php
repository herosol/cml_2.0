<?php if ($this->uri->segment(3) == 'manage'): ?>
<?= showMsg(); ?>
<?= getBredcrum(ADMIN, array('#' => 'Add/Update Individuals')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-users"></i> Add/Update <strong>Individuals</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?= site_url(ADMIN . '/individuals'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
    </div>
</div>
<div>
    <hr>
    <div class="row col-md-12">
        <form action=""  role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
            
            <div class="col-md-12">
                <h3><i class="fa fa-bars"></i> Profile Detail</h3>
                <hr class="hr-short">
                <div class="col-md-6">
                    <div style="margin:15px 0px" class="">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Profile Image
                                </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <?php
                            get_site_image_src("members", $row->mem_image);
                        ?>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row->mem_image) ? get_site_image_src("members", $row->mem_image) : 'http://placehold.it/700x620' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                <span class="btn btn-black btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="mem_image" accept="image/*" <?php if(empty($row->mem_image)){echo 'required=""';}?>>
                                </span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label"> Status</label>
                            <select name="mem_status" id="mem_status" class="form-control">
                                <option value="1" <?php
                                    if (isset($row->mem_status) && '1' == $row->mem_status) {
                                    echo 'selected';
                                    }
                                ?>>Active</option>
                                <option value="0" <?php
                                    if (isset($row->mem_status) && '0' == $row->mem_status) {
                                    echo 'selected';
                                    }
                                ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"> Verified</label>
                            <select name="mem_verified" id="mem_verified" class="form-control">
                                <option value="1" <?php
                                    if (isset($row->mem_verified) && '1' == $row->mem_verified) {
                                    echo 'selected';
                                    }
                                ?>>Yes</option>
                                <option value="0" <?php
                                    if (isset($row->mem_verified) && '0' == $row->mem_verified) {
                                    echo 'selected';
                                    }
                                ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"> Featured</label>
                            <select name="mem_featured" id="mem_featured" class="form-control">
                                <option value="1" <?php
                                    if (isset($row->mem_featured) && '1' == $row->mem_featured) {
                                    echo 'selected';
                                    }
                                ?>>yes</option>
                                <option value="0" <?php
                                    if (isset($row->mem_featured) && '0' == $row->mem_featured) {
                                    echo 'selected';
                                    }
                                ?>>No</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label"> First Name <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_fname" value="<?php if (isset($row->mem_fname)) echo $row->mem_fname; ?>" class="form-control" autofocus required>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label"> Last Name <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_lname" value="<?php if (isset($row->mem_lname)) echo $row->mem_lname; ?>" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label"> Gender <span class="symbol required" style="color: red">*</span></label>
                            <select name="mem_sex" id="mem_sex" class="form-control">
                                <option value="">Select</option>
                                <?php foreach (gender() as $val) : ?>
                                    <option value="<?= $val ?>" <?= $row->mem_sex == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                                <?php endforeach; ?>
                            </select>                        
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label">Date of Birth <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_dob" id="mem_dob" value="<?=format_date($row->mem_dob, 'm-d-Y')?>" class="form-control datepicker">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Email <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_email" 
                            <?php if (isset($row->mem_email)) { echo 'readonly';} ?>  
                            value="<?php if (isset($row->mem_email)) echo $row->mem_email; ?>"  class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Phone No <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_phone" value="<?php if (isset($row->mem_phone)) echo $row->mem_phone; ?>"  class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Password <span class="symbol required" style="color: red">*</span></label>
                            <?php if ($row->mem_pswd): ?>
                                <input type="text"  name="mem_pswd" value="<?php  if (isset($row->mem_pswd)) echo doDecode($row->mem_pswd);  ?>" class="form-control" autocomplete="off" placeholder="password" required="" >
                            <?php else:?>    
                                <input type="password"  name="mem_pswd" value="<?php  if (isset($row->mem_pswd)) echo doDecode($row->mem_pswd);  ?>" class="form-control" autocomplete="off" placeholder="password" required="" >
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <h3><i class="fa fa-bars"></i>Home Address Detail</h3>
                <hr class="hr-short">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label"> City</label>
                            <input type="text" name="mem_city" value="<?php if (isset($row->mem_city)) echo $row->mem_city; ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label"> State</label>
                            <select name="mem_state" id="mem_state" class="form-control select2">
                                <option value="">Select</option>
                                <?php foreach (states_by_country('232') as $state) : ?>
                                    <option value="<?= $state->id ?>" <?= $row->mem_state == $state->id ? 'selected' : '' ?>><?= $state->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Customer Country</label>
                            <select name="mem_country" id="mem_country" class="form-control select2">
                                <option value="0" selected="" readonly="">Country</option>
                                <?php foreach (countries() as $country) : ?>
                                    <?php if (in_array($country->name, ['United Kingdom'])){ ?>
                                    <option value="<?= $country->id ?>" <?= $row->mem_country == $country->id ? 'selected' : '' ?>><?= $country->name ?></option>
                                <?php } endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Postal Code</label>
                            <input type="text" name="mem_zip" value="<?php if (isset($row->mem_zip)) echo $row->mem_zip; ?>" class="form-control" data-type="home" onkeyup="getLocationAndInitMap(this)">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Lattitude </label>
                            <input type="text" readonly name="mem_map_lat" id="mem_map_lat" value="<?php if (isset($row->mem_map_lat)) echo $row->mem_map_lat; ?>" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Longitude</label>
                            <input type="text" readonly name="mem_map_lng" id="mem_map_lng" value="<?php if (isset($row->mem_map_lng)) echo $row->mem_map_lng; ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Address</label>
                            <textarea name="mem_address" id="mem_address" cols="" rows="3" class="form-control"><?php if (isset($row->mem_address)) echo $row->mem_address; ?></textarea>
                        </div>
                    </div>
                </div>
                <h3><i class="fa fa-bars"></i>Office Address Detail</h3>
                <hr class="hr-short">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label"> City</label>
                            <input type="text" name="mem_business_city" value="<?php if (isset($row->mem_business_city)) echo $row->mem_business_city; ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label"> State</label>
                            <select name="mem_business_state" id="mem_business_state" class="form-control select2">
                                <option value="">Select</option>
                                <?php foreach (states_by_country('232') as $state) : ?>
                                    <option value="<?= $state->id ?>" <?= $row->mem_business_state == $state->id ? 'selected' : '' ?>><?= $state->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Customer Country</label>
                            <select name="mem_business_country" id="mem_business_country" class="form-control select2">
                                <option value="0" selected="" readonly="">Country</option>
                                <?php foreach (countries() as $country) : ?>
                                    <?php if (in_array($country->name, ['United Kingdom'])){ ?>
                                    <option value="<?= $country->id ?>" <?= $row->mem_business_country == $country->id ? 'selected' : '' ?>><?= $country->name ?></option>
                                <?php } endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Postal Code</label>
                            <input type="text" name="mem_business_zip" value="<?php if (isset($row->mem_business_zip)) echo $row->mem_business_zip; ?>" class="form-control" data-type="office" onkeyup="getLocationAndInitMap(this)">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Lattitude </label>
                            <input type="text" readonly name="mem_business_map_lat" id="mem_business_map_lat" value="<?php if (isset($row->mem_business_map_lat)) echo $row->mem_business_map_lat; ?>" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Longitude</label>
                            <input type="text" readonly name="mem_business_map_lng" id="mem_business_map_lng" value="<?php if (isset($row->mem_business_map_lng)) echo $row->mem_business_map_lng; ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Address</label>
                            <textarea name="mem_business_address" id="mem_business_address" cols="" rows="3" class="form-control"><?php if (isset($row->mem_business_address)) echo $row->mem_business_address; ?></textarea>
                        </div>
                    </div>
                </div>
                <h3><i class="fa fa-bars"></i>Hotel Address Detail</h3>
                <hr class="hr-short">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label"> City</label>
                            <input type="text" name="mem_hotel_city" value="<?php if (isset($row->mem_hotel_city)) echo $row->mem_hotel_city; ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label"> State</label>
                            <select name="mem_hotel_state" id="mem_hotel_state" class="form-control select2">
                                <option value="">Select</option>
                                <?php foreach (states_by_country('232') as $state) : ?>
                                    <option value="<?= $state->id ?>" <?= $row->mem_hotel_state == $state->id ? 'selected' : '' ?>><?= $state->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Customer Country</label>
                            <select name="mem_hotel_country" id="mem_hotel_country" class="form-control select2">
                                <option value="0" selected="" readonly="">Country</option>
                                <?php foreach (countries() as $country) : ?>
                                <?php if (in_array($country->name, ['United Kingdom'])){ ?>
                                    <option value="<?= $country->id ?>" <?= $row->mem_hotel_country == $country->id ? 'selected' : '' ?>><?= $country->name ?></option>
                                <?php } endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Postal Code</label>
                            <input type="text" name="mem_hotel_zip" value="<?php if (isset($row->mem_hotel_zip)) echo $row->mem_hotel_zip; ?>" class="form-control" data-type="hotel" onkeyup="getLocationAndInitMap(this)">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Lattitude </label>
                            <input type="text" readonly name="mem_hotel_map_lat" id="mem_hotel_map_lat" value="<?php if (isset($row->mem_hotel_map_lat)) echo $row->mem_hotel_map_lat; ?>" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Longitude</label>
                            <input type="text" readonly name="mem_hotel_map_lng" id="mem_hotel_map_lng" value="<?php if (isset($row->mem_hotel_map_lng)) echo $row->mem_hotel_map_lng; ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Address</label>
                            <textarea name="mem_hotel_address" id="mem_hotel_address" cols="" rows="3" class="form-control"><?php if (isset($row->mem_hotel_address)) echo $row->mem_hotel_address; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        
                    </div>
                </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
                <hr class="hr-short">
                <div class="form-group text-right">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
    <?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage Customers')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-users"></i> Manage <strong>Customers</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/individuals/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="10%">Photo</th>
                <th width="20%">Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th width="8%" class="text-center">Status</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) > 0): $count = 0; ?>
            <?php foreach ($rows as $row): ?>
            <tr class="odd gradeX">
                <td class="text-center"><?= ++$count; ?></td>
                <td class="text-center">
                    <div class="icoRound">
                        <img src = "<?= getImageSrc(UPLOADIMAGE.'members/' , $row->mem_image,'member'); ?>" height = "60">
                    </div>
                </td>
                <td><b><?= $row->mem_fname . ' ' . $row->mem_lname; ?></b></td>
                <td><?= $row->mem_email; ?></td>
                <td><?= $row->mem_phone; ?></td>
                <td class="text-center"><?= getStatus($row->mem_status); ?></td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-primary" role="menu">
                            <?php if ($row->mem_status == '0'): ?>
                            <li><a href="<?= site_url(ADMIN); ?>/individuals/active/<?= $row->mem_id; ?>">Active</a></li>
                            <?php else: ?>
                            <li><a href="<?= site_url(ADMIN); ?>/individuals/inactive/<?= $row->mem_id; ?>">Inactive</a></li>
                            <?php endif; ?>
                            <li><a href="<?= site_url(ADMIN); ?>/individuals/manage/<?= $row->mem_id; ?>">Edit</a></li>
                            <li><a href="<?= site_url(ADMIN); ?>/individuals/delete/<?= $row->mem_id; ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
// Prepare the preview for profile picture
    jQuery("#wizard-picture").change(function(){
        readURL(this);
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }}
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmqmsf3pVEVUoGAmwerePWzjUClvYUtwM&libraries=geometry,places&ext=.js"></script>
    <script>
        
        var map, startLat = "", startLng = "";

        const getLocationAndInitMap = myThis => 
        {
            console.log('run');
            var value= myThis.value;
            value = value.trim();
            var myType = myThis.getAttribute('data-type');
            if(value.length == 0){
                if( myType == 'hotel'){
                    document.getElementById('mem_hotel_map_lat').value = '';
                    document.getElementById('mem_hotel_map_lng').value = '';
                }else if( myType == 'office'){
                    document.getElementById('mem_business_map_lat').value = '';
                    document.getElementById('mem_business_map_lng').value = '';
                }else if( myType == 'home'){
                    document.getElementById('mem_map_lat').value = '';
                    document.getElementById('mem_map_lng').value = '';
                } 
                return false;
            }
            
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode(
            { 
            componentRestrictions: { 
                country: 'gb', 
                postalCode: value
            } 
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    latitude = results[0].geometry.location.lat();
                    longitude = results[0].geometry.location.lng();
                    if( myType == 'hotel'){
                        document.getElementById('mem_hotel_map_lat').value = latitude;
                        document.getElementById('mem_hotel_map_lng').value = longitude;
                    }else if( myType == 'office'){
                        document.getElementById('mem_business_map_lat').value = latitude;
                        document.getElementById('mem_business_map_lng').value = longitude;
                    }else if( myType == 'home'){
                        document.getElementById('mem_map_lat').value = latitude;
                        document.getElementById('mem_map_lng').value = longitude;
                    }    
                    
                    
                } else {
                    if( myType == 'hotel'){
                        document.getElementById('mem_hotel_map_lat').value = '';
                        document.getElementById('mem_hotel_map_lng').value = '';
                    }else if( myType == 'office'){
                        document.getElementById('mem_business_map_lat').value = '';
                        document.getElementById('mem_business_map_lng').value = '';
                    }else if( myType == 'home'){
                        document.getElementById('mem_map_lat').value = '';
                        document.getElementById('mem_map_lng').value = '';
                    } 
                }
            });
        }
        </script>