<?php if ($this->uri->segment(3) == 'manage'): ?>
<?= showMsg(); ?>
<?= getBredcrum(ADMIN, array('#' => 'Add/Update Vendors')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-users"></i> Add/Update <strong>Vendors</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?= site_url(ADMIN . '/vendors'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
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
                        <div class="col-md-6">
                            <label class="control-label"> First Name <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_fname" value="<?php if (isset($row->mem_fname)) echo $row->mem_fname; ?>" class="form-control" autofocus required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label"> Last Name <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_lname" value="<?php if (isset($row->mem_lname)) echo $row->mem_lname; ?>" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label">Email <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_email"
                             <?php if (isset($row->mem_email)) { echo 'readonly';} ?>  
                             value="<?php if (isset($row->mem_email)) echo $row->mem_email; ?>"  class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Password <span class="symbol required" style="color: red">*</span></label>
                            <?php if ($row->mem_pswd): ?>
                                <input type="text"  name="mem_pswd" minlength="8" value="<?php  if (isset($row->mem_pswd)) echo doDecode($row->mem_pswd);  ?>" class="form-control" autocomplete="off" placeholder="password" required="" >
                            <?php else:?>    
                                <input type="password"  name="mem_pswd" minlength="8" value="<?php  if (isset($row->mem_pswd)) echo doDecode($row->mem_pswd);  ?>" class="form-control" autocomplete="off" placeholder="password" required="" >
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <h3><i class="fa fa-bars"></i> Company Detail</h3>
                <hr class="hr-short">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label">Company Name</label>
                            <input type="text" name="mem_company_name" value="<?php if (isset($row->mem_company_name)) echo $row->mem_company_name; ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label"> Phone Number</label>
                            <input type="text" name="mem_company_phone" value="<?php if (isset($row->mem_company_phone)) echo $row->mem_company_phone; ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label"> Company Website URL</label>
                            <input type="text" name="mem_company_website" value="<?php if (isset($row->mem_company_website)) echo $row->mem_company_website; ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label"> Trust Pilot or Google Review URL</label>
                            <input type="text" name="mem_company_trustpilot" value="<?php if (isset($row->mem_company_trustpilot)) echo $row->mem_company_trustpilot; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="control-label">Contact Email</label>
                            <input type="email" name="mem_company_email" value="<?php if (isset($row->mem_company_email)) echo $row->mem_company_email; ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Order Email</label>
                            <input type="email" name="mem_company_order_email" value="<?php if (isset($row->mem_company_order_email)) echo $row->mem_company_order_email; ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Provide pickup & drop off services?</label>
                            <select name="mem_company_pickdrop" id="mem_company_pickdrop" class="form-control"  onchange="getPickupDetail(this.value)">
                                <option value="">Select</option>
                                <?php foreach (yes_no() as $val) : ?>
                                    <option value="<?= $val ?>" <?= $row->mem_company_pickdrop == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                                <?php endforeach; ?>
                            </select>                        
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Walk in facility?</label>
                            <select name="mem_company_walkin_facility" id="mem_company_walkin_facility" class="form-control" onchange="getFacilityHours(this.value)">
                                <option value="">Select</option>
                                <?php foreach (yes_no() as $val) : ?>
                                    <option value="<?= $val ?>" <?= $row->mem_company_walkin_facility == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                                <?php endforeach; ?>
                            </select>                       
                        </div>
                    </div>
                </div>
                <div class="row" id="facilityAddressAndHours" <?=$row->mem_company_walkin_facility == 'yes' ? '' : 'style="display:none"'?>>
                <h3><i class="fa fa-bars"></i>Business Address Detail</h3>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label"> Country</label>
                            <select name="mem_business_country" id="mem_business_country" class="form-control" onchange="fetchStates(this.value, 'mem_business_state')">
                                <option value="0" selected="" readonly="">Country</option>
                                <?php foreach (countries() as $country) : ?>
                                <?php if (in_array($country->name, ['United Kingdom'])){ ?>
                                    <option value="<?= $country->id ?>" <?= $row->mem_business_country == $country->id ? 'selected' : '' ?>><?= $country->name ?></option>
                                <?php } endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">State</label>
                            <select name="mem_business_state" id="mem_business_state" class="form-control" >
                                <option value="0" selected="" readonly="">State</option>
                                <?php foreach (states_by_country('232') as $state) : ?>
                                    <option value="<?= $state->id ?>" <?= $row->mem_business_state == $state->id ? 'selected' : '' ?>><?= $state->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">City</label>
                            <input type="text" name="mem_business_city" value="<?php if (isset($row->mem_business_city)) echo $row->mem_business_city; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Postal Code</label>
                            <input type="text" name="mem_business_zip" value="<?php if (isset($row->mem_business_zip)) echo $row->mem_business_zip; ?>" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <label class="control-label">Business Address</label>
                            <textarea name="mem_business_address" id="mem_business_address" cols="30" rows="1" class="form-control"><?php if (isset($row->mem_business_address)) echo $row->mem_business_address; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div id="calendar">
                                <div class="tblBlock">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Day</th>
                                                <th>Opening Time</th>
                                                <th>Closing Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Mon</td>
                                                <td>
                                                    <select name="mon_opening" id="mon_opening" class="form-control" data-day="mon" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->mon_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->mon_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="mon_closing" id="mon_closing" class="form-control" data-day="mon" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->mon_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->mon_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tue</td>
                                                <td>
                                                    <select name="tue_opening" id="tue_opening" class="form-control" data-day="tue" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->tue_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->tue_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="tue_closing" id="tue_closing" class="form-control" data-day="tue" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->tue_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->tue_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Wed</td>
                                                <td>
                                                    <select name="wed_opening" id="wed_opening" class="form-control" data-day="wed" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->wed_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->wed_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="wed_closing" id="wed_closing" class="form-control" data-day="wed" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->wed_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->wed_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Thu</td>
                                                <td>
                                                    <select name="thu_opening" id="thu_opening" class="form-control" data-day="thu" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->thu_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->thu_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="thu_closing" id="thu_closing" class="form-control" data-day="thu" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->thu_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->thu_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Fri</td>
                                                <td>
                                                    <select name="fri_opening" id="fri_opening" class="form-control" data-day="fri" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->fri_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->fri_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="fri_closing" id="fri_closing" class="form-control" data-day="fri" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->fri_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->fri_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sat</td>
                                                <td>
                                                    <select name="sat_opening" id="sat_opening" class="form-control" data-day="sat" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sat_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sat_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="sat_closing" id="sat_closing" class="form-control" data-day="sat" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sat_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sat_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sun</td>
                                                <td>
                                                    <select name="sun_opening" id="sun_opening" class="form-control" data-day="sun" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sun_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sun_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="sun_closing" id="sun_closing" class="form-control" data-day="sun" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sun_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sun_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                
                <div class="row" id="pickupdetails" <?=$row->mem_company_pickdrop == 'yes' ? '' : 'style="display:none"'?>>
                    <h3><i class="fa fa-bars"></i>Pickup & Collection Area</h3>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label">Postal Code</label>
                            <input type="text" name="pickup_zip" value="<?php if (isset($row->pickup_zip)) echo $row->pickup_zip; ?>" class="form-control" onkeyup="getLocationAndInitMap(this)">
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
                            <label class="control-label">Travel Distance (Miles)</label>
                            <input type="number" step="0.1" name="mem_travel_radius" value="<?php if (isset($row->mem_travel_radius)) echo $row->mem_travel_radius; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <h3><i class="fa fa-bars"></i>Charges Information</h3>
                        <div class="col-md-4">
                            <label class="control-label">Charges/Mile For Pickup & Drop Off (£)</label>
                            <input type="number" step="0.01" name="mem_charges_per_miles" value="<?php if (isset($row->mem_charges_per_miles)) echo $row->mem_charges_per_miles; ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Pick & drop off free for over (Order Amount)</label>
                            <input type="number" step="0.1" name="mem_charges_free_over" value="<?php if (isset($row->mem_charges_free_over)) echo $row->mem_charges_free_over; ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Min Order Value (£)</label>
                            <input type="number" step="0.1" name="mem_charges_min_order" value="<?php if (isset($row->mem_charges_min_order)) echo $row->mem_charges_min_order; ?>" class="form-control">
                        </div>
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
    <?= getBredcrum(ADMIN, array('#' => 'Manage Vendors')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-users"></i> Manage <strong>Vendors</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/vendors/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="10%">Photo</th>
                <th width="20%">Name</th>
                <th>Email</th>
                <th>Company Name</th>
                <th width="8%" class="text-center">Status</th>
                <th width="8%" class="text-center">Verify</th>
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
                <td><?= $row->mem_company_name; ?></td>
                <td class="text-center"><?= getStatus($row->mem_status); ?></td>
                <td class="text-center"><?= ($row->mem_verified)? 'Yes' : 'No' ?></td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-primary" role="menu">
                            <?php if ($row->mem_verified == '0'): ?>
                            <li><a href="<?= site_url(ADMIN); ?>/vendors/verify/<?= $row->mem_id; ?>">Verify</a></li>
                            <?php else: ?>
                            <li><a href="<?= site_url(ADMIN); ?>/vendors/unverify/<?= $row->mem_id; ?>">Unverify</a></li>
                            <?php endif; ?>
                            <?php if ($row->mem_status == '0'): ?>
                            <li><a href="<?= site_url(ADMIN); ?>/vendors/active/<?= $row->mem_id; ?>">Active</a></li>
                            <?php else: ?>
                            <li><a href="<?= site_url(ADMIN); ?>/vendors/inactive/<?= $row->mem_id; ?>">Inactive</a></li>
                            <?php endif; ?>
                            <li><a href="<?= site_url(ADMIN); ?>/vendors/manage/<?= $row->mem_id; ?>">Edit</a></li>
                            <li><a href="<?= site_url(ADMIN); ?>/vendors/delete/<?= $row->mem_id; ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
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
        const getFacilityHours = value => 
        {
            // console.log('x');
            if(value == 'no' || value == '')
                document.getElementById('facilityAddressAndHours').style.display = "none";
            else
                document.getElementById('facilityAddressAndHours').style.display = "block";
        }
        const getPickupDetail = value => 
        {
            if(value == 'no' || value == '')
                document.getElementById('pickupdetails').style.display = "none";
            else
                document.getElementById('pickupdetails').style.display = "block";
        }
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
            
            var value= myThis.value;
            value = value.trim();
            
            if(value.length == 0){
                document.getElementById('mem_map_lat').value = '';
                document.getElementById('mem_map_lng').value = '';
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
                    
                    document.getElementById('mem_map_lat').value = latitude;
                    document.getElementById('mem_map_lng').value = longitude;
                      
                } else {
                    document.getElementById('mem_map_lat').value = '';
                    document.getElementById('mem_map_lng').value = '';
                }
            });
        }
        </script>