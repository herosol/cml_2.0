<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="account">
            <div class="contain">
                <?php echo showMsg(); ?>
                <?php if (empty($mem_data->mem_verified) || $mem_data->mem_verified == 0) : ?>
                    <div id="verify">
                        <div class="inBlk blk">
                            <h3 class="heading">Email Verification</h3>
                            <div id="resndCntnt">
                                <p>Please verify your email address, As you are currently signed in with email : <span id="currently-signin-email"><strong><?= $mem_data->mem_email ?></strong></span>. We've sent a verify email to your email address. If you don't see the email, check your spam folder. If you didn't get email click on resend email link, or if you want to change email address click link below.</p>
                                <p><a href="javascript:void(0)" id="rsnd-email">Resend Email</a> OR <a href="javascript:void(0)" class="pop_btn" data-popup="change-email">Change Email</a>
                                </p>
                            </div>
                            <div class="app_load hide">
                                <div class="app_loader"><span class="spinner"></span></div>
                            </div>
                            <div class="popup sm" data-popup="change-email">
                                <div class="table_dv">
                                    <div class="table_cell">
                                        <div class="contain">
                                            <div class="_inner">
                                                <div class="cross_btn"></div>
                                                <h4>Change your Email</h4>
                                                <form action="<?= base_url() . 'index/change_email' ?>" method="post" autocomplete="off" class="frmAjax" id="frmChangeEmail">
                                                    <div class="alertMsg" style="display:none"></div>
                                                    <h6>Email Address <sup>*</sup></h6>
                                                    <div class="form_blk">
                                                        <input type="email" id="email" name="email" class="text_box" placeholder="eg: sample@gmail.com">
                                                    </div>
                                                    <div class="btn_blk text-center">
                                                        <button type="submit" class="site_btn block"><i class="spinner hidden"></i>Change your Email</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="pro_blk">
                    <div class="ico icon" id="dp-image-head"><img src="<?= get_site_image_src("members", $mem_data->mem_image, '300p_'); ?>" alt=""></div>
                    <div class="txt">
                        <h2 id="name-head"><span>Welcome,</span> <?= $mem_data->mem_fname . ' ' . $mem_data->mem_lname ?>!</h2>
                        <p>Nice to see you<?= $mem_data->mem_first_time_login == 'no' ? ' again.' : '.' ?></p>
                    </div>
                </div>
                <div class="flex_row card_row full_height hidden">
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>Total donations</span>
                                    <div class="price">$ 5055.00</div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-payouts.svg') ?>" alt=""></div>
                            </div>
                            <div class="btm">
                                <label class="switch_btn">
                                    <span class="switch">
                                        <input type="checkbox" name="" id="">
                                        <em></em>
                                    </span>
                                    <span>Hide the scale</span>
                                </label>
                                <a href="?" class="site_btn learn">See more <img src="<?= base_url('assets/images/arrow-right-sm.svg') ?>" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>Total invested</span>
                                    <div class="price">$ 5055.00</div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-chart.svg') ?>" alt=""></div>
                            </div>
                            <div class="btm">
                                <label class="switch_btn">
                                    <span class="switch">
                                        <input type="checkbox" name="" id="">
                                        <em></em>
                                    </span>
                                    <span>Hide the scale</span>
                                </label>
                                <a href="?" class="site_btn learn">See more <img src="<?= base_url('assets/images/arrow-right-sm.svg') ?>" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="tile_blk">
                            <div class="top">
                                <div class="txt">
                                    <span>Available balance</span>
                                    <div class="price">$ ******. 00</div>
                                </div>
                                <div class="icon"><img src="<?= base_url('assets/images/vector-wallet.svg') ?>" alt=""></div>
                            </div>
                            <div class="btm">
                                <label class="switch_btn">
                                    <span class="switch">
                                        <input type="checkbox" name="" id="">
                                        <em></em>
                                    </span>
                                    <span>Hide the scale</span>
                                </label>
                                <a href="?" class="site_btn learn">See more <img src="<?= base_url('assets/images/arrow-right-sm.svg') ?>" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="br"></div>
                <?php if (!empty($mem_data->mem_verified) && $mem_data->mem_verified == 1) : ?>
                    <form action="" method="post" id="vendorProfileSettings" class="frmAjax">
                        <div class="blk">
                            <div class="alertMsg" style="display:none"></div>
                            <h4 class="subheading">Personal information</h4>
                            <div class="dp_blk upLoadDp">
                                <div class="ico icon">
                                    <img src="<?= get_site_image_src("members", $mem_data->mem_image, '300p_'); ?>" alt="" id="uploadDpPreview">
                                </div>
                                <div class="txt">
                                    <div class="btn_blk">
                                        <button type="button" class="site_btn md uploadImg" data-upload="dp_image" data-text="Change Photo"></button>
                                        <input type="file" name="dp_image" id="dp_image" class="uploadFile" data-upload="dp_image" onchange="PreviewImage();">
                                    </div>
                                    <div class="br"></div>
                                    <div>Acceptable only jpg, png</div>
                                    <div>The maximum file size is 500 kb and the minimum size is 80 kb.</div>
                                </div>
                            </div>
                            <div class="form_row row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>First Name</h6>
                                    <div class="form_blk">
                                        <input type="text" name="mem_fname" id="mem_fname" value="<?= $mem_data->mem_fname ?>" class="text_box" placeholder="eg: John">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Last Name</h6>
                                    <div class="form_blk">
                                        <input type="text" name="mem_lname" id="mem_lname" value="<?= $mem_data->mem_lname ?>" class="text_box" placeholder="eg: Wick">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="subheading">Company Information</h4>
                        <div class="blk">
                            <div class="form_row row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Company Name</h6>
                                    <div class="form_blk">
                                        <input type="text" name="mem_company_name" id="mem_company_name" value="<?= $mem_data->mem_company_name ?>" class="text_box" placeholder="eg: Vendor Seven">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Contact Email</h6>
                                    <div class="form_blk">
                                        <input type="text" name="mem_company_email" id="mem_company_email" value="<?= $mem_data->mem_company_email ?>" class="text_box" placeholder="eg: sample@gmail.com">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Phone Number</h6>
                                    <div class="form_blk">
                                        <input type="text" name="mem_company_phone" id="mem_company_phone" value="<?= $mem_data->mem_company_phone ?>" class="text_box" placeholder="eg: +92300 0000 000">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Order Email</h6>
                                    <div class="form_blk">
                                        <input type="text" id="mem_company_order_email" name="mem_company_order_email" value="<?= $mem_data->mem_company_order_email ?>" class="text_box" placeholder="eg: sample@gmail.com">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Website URL</h6>
                                    <div class="form_blk">
                                        <input type="text" name="mem_company_website" id="mem_company_website" value="<?= $mem_data->mem_company_website ?>" class="text_box" placeholder="eg: www.sample.com">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <h6>Trustpilot or Google Review URL</h6>
                                    <div class="form_blk">
                                        <input type="text" name="mem_company_trustpilot" id="mem_company_trustpilot" value="<?= $mem_data->mem_company_trustpilot ?>" class="text_box" placeholder="eg: www.sample.com">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
                                    <h6>Walk in facility?</h6>
                                    <div class="form_blk">
                                        <select name="mem_company_walkin_facility" id="mem_company_walkin_facility" class="text_box" onchange="getFacilityHours(this.value)">
                                            <option value="">Select</option>
                                            <?php foreach (yes_no() as $val) : ?>
                                                <option value="<?= $val ?>" <?= $mem_data->mem_company_walkin_facility == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="facilityAddressAndHours" <?= $mem_data->mem_company_walkin_facility == 'yes' ? '' : 'style="display:none"' ?>>
                            <h4 class="subheading">Business Address</h4>
                            <div class="blk">
                                <div class="form_row row">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <h6>Country</h6>
                                        <div class="form_blk">
                                            <select name="mem_business_country" id="mem_business_country" class="text_box" onchange="fetchStates(this.value, 'mem_business_state')">
                                                <option value="">Select</option>
                                                <?php foreach (countries() as $country) : ?>
                                                    <option value="<?= $country->id ?>" <?= $mem_data->mem_business_country == $country->id ? 'selected' : '' ?>><?= $country->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <h6>State</h6>
                                        <div class="form_blk">
                                            <select name="mem_business_state" id="mem_business_state" value="<?= $mem_data->mem_business_state ?>" class="text_box">
                                                <option value="">Select</option>
                                                <?php foreach (states_by_country($mem_data->mem_business_country) as $state) : ?>
                                                    <option value="<?= $state->id ?>" <?= $mem_data->mem_business_state == $state->id ? 'selected' : '' ?>><?= $state->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <h6>City</h6>
                                        <div class="form_blk">
                                            <input type="text" name="mem_business_city" id="mem_business_city" value="<?= $mem_data->mem_business_city ?>" class="text_box" placeholder="eg: California">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <h6>Zip Code</h6>
                                        <div class="form_blk">
                                            <input type="text" id="mem_business_zip" name="mem_business_zip" value="<?= $mem_data->mem_business_zip ?>" class="text_box" placeholder="eg: BL0 0WY">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <h6>Address</h6>
                                        <div class="form_blk">
                                            <input type="text" id="mem_business_address" name="mem_business_address" value="<?= $mem_data->mem_business_address ?>" class="text_box" placeholder="eg: 123 Main Street, California">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="subheading">Business Hours</h4>
                            <div class="blk" id="calendar">
                                <div class="tbl_blk">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Day</th>
                                                <th>Opening Time</th>
                                                <th>Closing Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Monday</td>
                                                <td>
                                                    <select name="mon_opening" id="mon_opening" class="text_box" data-day="mon" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->mon_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->mon_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="mon_closing" id="mon_closing" class="text_box" data-day="mon" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->mon_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->mon_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tuesday</td>
                                                <td>
                                                    <select name="tue_opening" id="tue_opening" class="text_box" data-day="tue" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->tue_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->tue_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="tue_closing" id="tue_closing" class="text_box" data-day="tue" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->tue_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->tue_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Wednesday</td>
                                                <td>
                                                    <select name="wed_opening" id="wed_opening" class="text_box" data-day="wed" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->wed_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->wed_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="wed_closing" id="wed_closing" class="text_box" data-day="wed" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->wed_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->wed_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Thursday</td>
                                                <td>
                                                    <select name="thu_opening" id="thu_opening" class="text_box" data-day="thu" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->thu_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->thu_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="thu_closing" id="thu_closing" class="text_box" data-day="thu" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->thu_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->thu_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Friday</td>
                                                <td>
                                                    <select name="fri_opening" id="fri_opening" class="text_box" data-day="fri" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->fri_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->fri_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="fri_closing" id="fri_closing" class="text_box" data-day="fri" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->fri_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->fri_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Saturday</td>
                                                <td>
                                                    <select name="sat_opening" id="sat_opening" class="text_box" data-day="sat" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sat_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sat_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="sat_closing" id="sat_closing" class="text_box" data-day="sat" data-action="closing" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sat_closing == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sat_closing == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sunday</td>
                                                <td>
                                                    <select name="sun_opening" id="sun_opening" class="text_box" data-day="sun" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sun_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sun_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="sun_closing" id="sun_closing" class="text_box" data-day="sun" data-action="closing" onchange="valid_open_close(this)">
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
                        <div class="br"></div>
                        <h4 class="subheading">Pickup & Collection Area</h4>
                        <div class="blk">
                            <div class="form_row row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h6>Provide pickup & drop off services?</h6>
                                    <div class="form_blk">
                                        <select name="mem_company_pickdrop" id="mem_company_pickdrop" class="text_box" onchange="getPickupDetail(this.value)">
                                            <option value="">Select</option>
                                            <?php foreach (yes_no() as $val) : ?>
                                                <option value="<?= $val ?>" <?= $mem_data->mem_company_pickdrop == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pickupdetails" <?= $mem_data->mem_company_pickdrop == 'yes' ? '' : 'style="display:none"' ?>>
                            <h4 class="subheading">Travel Distance</h4>
                            <div class="blk">
                                <div class="form_row row">
                                    <!-- <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
                                        <h6>Provide pickup & drop off services?</h6>
                                        <div class="form_blk">
                                            <select name="mem_company_pickdrop" id="mem_company_pickdrop" class="text_box" onchange="getPickupDetail(this.value)">
                                                <option value="">Select</option>
                                                <?php foreach (yes_no() as $val) : ?>
                                                    <option value="<?= $val ?>" <?= $mem_data->mem_company_pickdrop == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <h6>Zip Code</h6>
                                        <div class="form_blk">
                                            <input type="text" id="pickup_zip" name="pickup_zip" value="<?= $mem_data->pickup_zip ?>" class="text_box" onkeyup="getLocationAndInitMap(this.value)" placeholder="eg: BL0 0WY">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="form_blk">
                                            <h6>Travel Distance?</h6>
                                            <div class="irs_slider">
                                                <input type="text" name="mem_travel_radius" id="distance" value="<?= $mem_data->mem_travel_radius ?>" onchange="travel_distance(this.value)">
                                                <input type="hidden" name="mem_map_lat" id="mem_map_lat" value="<?= $mem_data->mem_map_lat ?>">
                                                <input type="hidden" name="mem_map_lng" id="mem_map_lng" value="<?= $mem_data->mem_map_lng ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div id="map-canvas"></div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="subheading">Charges Information</h4>
                            <div class="blk">
                                <div class="form_row row">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <h6>Charges per mile for pickup & drop off?</h6>
                                        <div class="form_blk">
                                            <input type="text" name="mem_charges_per_miles" id="mem_charges_per_miles" value="<?= $mem_data->mem_charges_per_miles ?>" class="text_box" placeholder="eg: 100">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <h6>Pick & drop off free for over (Order Amount)</h6>
                                        <div class="form_blk">
                                            <input type="text" name="mem_charges_free_over" id="mem_charges_free_over" value="<?= $mem_data->mem_charges_free_over ?>" class="text_box" placeholder="eg: 100">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <h6>Minimum order value?</h6>
                                        <div class="form_blk">
                                            <input type="text" name="mem_charges_min_order" id="mem_charges_min_order" value="<?= $mem_data->mem_charges_min_order ?>" class="text_box" placeholder="25">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 hidden">
                                        <h6>Show cancellation policy?</h6>
                                        <div class="form_blk">
                                            <select name="mem_show_cancellation" id="mem_show_cancellation" class="text_box">
                                                <option value="">Select</option>
                                                <?php foreach (yes_no() as $val) : ?>
                                                    <option value="<?= $val ?>" <?= $mem_data->mem_show_cancellation == $val ? 'selected' : '' ?>><?= ucfirst($val) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn_blk form_btn text-center">
                            <button type="submit" class="site_btn long submit" title="Please make any change to enable save button."><i class="spinner hidden"></i>Save</button>
                        </div>
                    </form>
                <?php endif; ?>
                <div class="br"></div>
                <div class="blk">
                    <div class="_header">
                        <h4 class="subheading">Change Password</h4>
                        <div class="info">
                            <strong><em>Strong Password</em></strong>
                            <div class="infoIn">
                                <p>Your password must contain the following:</p>
                                <ol>
                                    <li>At least 8 characters in length (a strong password has at least 8 characters)</li>
                                    <li>At least 1 capital letter, 1 small letter, 1 number and 1 symbol.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <form action="<?= base_url() ?>index/change_password" method="post" id="changePassword" class="frmAjax">
                        <div class="alertMsg" style="display:none"></div>
                        <div class="form_row row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form_blk pass_blk">
                                    <label for="pswd">Current password</label>
                                    <input type="password" name="pswd" id="pswd" class="text_box">
                                    <i class="icon-eye" id="eye"></i>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form_blk pass_blk">
                                    <label for="npswd">New password</label>
                                    <input type="password" name="npswd" id="npswd" class="text_box pr-password">
                                    <i class="icon-eye" id="eye"></i>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="form_blk pasDv">
                                    <label for="cpswd">Confirm new password</label>
                                    <input type="password" name="cpswd" id="cpswd" class="text_box">
                                    <i class="icon-eye" id="eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="btn_blk form_btn text-center">
                            <button type="submit" class="site_btn"><i class="spinner hidden"></i>Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- account -->


        <script type="text/javascript">
            function PreviewImage() {
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("dp_image").files[0]);
                oFReader.onload = function(oFREvent) {
                    document.getElementById("uploadDpPreview").src = oFREvent.target.result;
                };
            };
            const getFacilityHours = value => {
                if (value == 'no' || value == '')
                    $('#facilityAddressAndHours').hide();
                else
                    $('#facilityAddressAndHours').show();
            }
            const valid_open_close = obj => {
                obj = $(obj);
                let day = obj.data('day');
                let open_close = obj.data('action');
                if (open_close == 'opening') {
                    value = $('#' + day + '_' + open_close).val();
                    if (value == 'closed') {
                        $('#' + day + '_closing option[value="closed"]').prop('selected', true);
                    }
                } else {
                    value = $('#' + day + '_' + open_close).val();
                    if (value == 'closed') {
                        $('#' + day + '_opening option[value="closed"]').prop('selected', true);
                    }
                }
                if (open_close == 'opening') {
                    value = $('#' + day + '_' + open_close).val();
                    if (value == '') {
                        $('#' + day + '_closing option[value=""]').prop('selected', true);
                    }
                } else {
                    value = $('#' + day + '_' + open_close).val();
                    if (value == '') {
                        $('#' + day + '_opening option[value=""]').prop('selected', true);
                    }
                }
                if (open_close == 'opening') {
                    value = $('#' + day + '_' + open_close).val();
                    if (value != '' && value != 'closed') {
                        if ($('#' + day + '_closing').val() == 'closed')
                            $('#' + day + '_closing option[value=""]').prop('selected', true);
                    }
                } else {
                    value = $('#' + day + '_' + open_close).val();
                    if (value != '' && value != 'closed') {
                        if ($('#' + day + '_opening').val() == 'closed')
                            $('#' + day + '_opening option[value=""]').prop('selected', true);
                    }
                }
            }
            $(function() {
                $(document).on('click', '#rsnd-email', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    if (btn.data("disabled"))
                        return false;
                    $("#resndCntnt").addClass('hide');
                    $('.app_load').removeClass('hide');
                    btn.data("disabled", "disabled");
                    $.ajax({
                        url: base_url + 'resend-email',
                        data: {
                            'cmd': 'resend'
                        },
                        dataType: 'JSON',
                        method: 'POST',
                        success: function(rs) {
                            $('#resndCntnt').find('.alertMsg').remove().end().append(rs.msg);
                        },
                        complete: function() {
                            btn.removeData("disabled");
                            setTimeout(function() {
                                $('.app_load').addClass('hide');
                                $('#resndCntnt').removeClass('hide');
                            }, 1500)
                        }
                    })
                })
            });
        </script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmqmsf3pVEVUoGAmwerePWzjUClvYUtwM&libraries=geometry,places&ext=.js"></script>
        <script type="text/javascript">
            var map, bounds, startLat = "<?= $mem_data->mem_map_lat == '' ? '51.509865' : $mem_data->mem_map_lat; ?>",
                startLng = "<?= $mem_data->mem_map_lng == '' ? '-0.118092' : $mem_data->mem_map_lng; ?>";
            const getLocationAndInitMap = value => {
                value = $.trim(value);
                if ($.trim(value).length == 0)
                    return false;
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    componentRestrictions: {
                        country: 'gb',
                        postalCode: value
                    }
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        latitude = results[0].geometry.location.lat();
                        longitude = results[0].geometry.location.lng();
                        console.log()
                        $('#mem_map_lat').val(latitude);
                        $('#mem_map_lng').val(longitude);
                        startLat = latitude;
                        startLng = longitude;
                        startLatLng = new google.maps.LatLng(startLat, startLng);
                        init();
                    } else {
                        alert("Request failed.")
                    }
                });
            }
            const travel_distance = miles => {
                miles = $.trim(miles);
                let meters = getMeters(miles);
                if (!isInt(miles) || miles == 0 || miles.length == 0)
                    return false;
                radiusCircle = true;
                radiusMeters = meters;
                init();
            }

            function getMeters(i) {
                return i * 1609.344;
            }

            function isInt(value) {
                return !isNaN(value) && parseInt(Number(value)) == value && !isNaN(parseInt(value, 10));
            }
            var markers = [];
            var infowindows = [];
            var haveGeoLocation = false;
            var radiusCircle = <?= $mem_data->mem_travel_radius == '0' ? 'false' : 'true' ?>;
            var radiusMeters = getMeters(<?= $mem_data->mem_travel_radius ?>);
            var startLatLng = new google.maps.LatLng(startLat, startLng);
            var image = {
                url: base_url + "assets/images/marker.png", // url
                scaledSize: new google.maps.Size(40, 40), // scaled size
                origin: new google.maps.Point(0, 0), // origin
                anchor: new google.maps.Point(25, 50) // anchor
            };

            function init() {
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: startLatLng,
                    zoom: 10
                });
                bounds = new google.maps.LatLngBounds();
                var user_icon = {
                    url: base_url + "assets/images/user_marker.png", // url
                    scaledSize: new google.maps.Size(50, 50), // scaled size
                    origin: new google.maps.Point(0, 0), // origin
                    anchor: new google.maps.Point(25, 50) // anchor
                };
                searchAreaMarker = new google.maps.Marker({
                    position: startLatLng,
                    map: map,
                    draggable: false,
                    icon: user_icon,
                    animation: google.maps.Animation.DROP,
                    title: 'My Location'
                });
                if (radiusCircle) {
                    // setMarkers(map, locations);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: new google.maps.LatLng(startLat, startLng),
                        title: 'Some location'
                    });
                    // Add circle overlay and bind to marker
                    var circle = new google.maps.Circle({
                        map: map,
                        radius: radiusMeters, // 10 miles in metres
                        fillColor: '#016ecf'
                    });
                    circle.bindTo('center', marker, 'position');
                }
            }

            function closeInfos() {
                if (infowindows.length > 0) {
                    for (var i = 0; i < infowindows.length; i++) {
                        infowindows[i].close();
                    }
                }
            }

            function closeMarks() {
                if (markers.length > 0) {
                    for (var i = 0; i < markers.length; i++) {
                        markers[i].setMap(null);
                    }
                }
            }
            google.maps.event.addDomListener(window, 'load', init);
            const getPickupDetail = value => {
                if (value == 'no' || value == '')
                    document.getElementById('pickupdetails').style.display = "none";
                else
                    document.getElementById('pickupdetails').style.display = "block";
            }
        </script>
        <!-- Ion Slider -->
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/ion.slider.min.css">
        <script type="text/javascript" src="<?= base_url() ?>assets/js/ion.slider.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#distance').ionRangeSlider({
                    skin: 'square',
                    min: 1,
                    max: 50,
                    type: 'single',
                    onFinish: function(data) {},
                    grid: true,
                    hide_min_max: true,
                    hide_from_to: true
                });
            });
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>