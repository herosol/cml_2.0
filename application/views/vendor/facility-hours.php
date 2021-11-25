<!DOCTYPE html>
<html lang="en">

<head>
    <title>Facility Hours — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body id="home-page">
    <?php $this->load->view('includes/header-vendor'); ?>
    <main dash calendar>
        <?php $this->load->view('includes/sidebar-vendor'); ?>


        <section id="calendar">
            <div class="contain-fluid">
                <h3>Facility Information</h3>
                <p>Please specify your facility hours of operation and location.</p>
                <form action="" method="post">
                    <div class="blk">
                        <div class="flexRow flex">
                            <div class="col col1">
                                <h6>Facility Location</h6>
                                <div class="row formRow">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <label for="mem_business_country" class="move">Country</label>
                                            <select name="mem_business_country" id="mem_business_country" class="txtBox" onchange="fetchStates(this.value, 'mem_business_state')">
                                                <option value="">Select</option>
                                                <?php foreach (countries() as $country) : ?>
                                                    <option value="<?= $country->id ?>" <?= $mem_data->mem_business_country == $country->id ? 'selected' : '' ?>><?= $country->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <label for="mem_business_city">City</label>
                                            <input type="text" name="mem_business_city" id="mem_business_city" value="<?= $mem_data->mem_business_city ?>" class="txtBox">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <label for="mem_business_state" class="move">State</label>
                                            <select name="mem_business_state" id="mem_business_state" value="<?= $mem_data->mem_business_state ?>" class="txtBox">
                                                <option value="">Select</option>
                                                <?php foreach (states_by_country($mem_data->mem_business_country) as $state) : ?>
                                                    <option value="<?= $state->id ?>" <?= $mem_data->mem_business_state == $state->id ? 'selected' : '' ?>><?= $state->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xx-6">
                                        <div class="txtGrp">
                                            <label for="mem_business_zip">Zip Code</label>
                                            <input type="hidden" name="mem_map_lat" id="mem_map_lat" value="<?= $mem_data->mem_map_lat ?>">
                                            <input type="hidden" name="mem_map_lng" id="mem_map_lng" value="<?= $mem_data->mem_map_lng ?>">
                                            <input type="text" id="mem_business_zip" name="mem_business_zip" value="<?= $mem_data->mem_business_zip ?>" class="txtBox" onkeyup="getLocationAndInitMap(this.value)">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xx-12">
                                        <div class="txtGrp">
                                            <label for="mem_business_address">Address</label>
                                            <input type="text" id="mem_business_address" name="mem_business_address" value="<?= $mem_data->mem_business_address ?>" class="txtBox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col2">
                                <div class="tblBlock">
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
                                                <td>Mon</td>
                                                <td>
                                                    <select name="mon_opening" id="mon_opening" class="txtBox" data-day="mon" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->mon_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->mon_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="mon_closing" id="mon_closing" class="txtBox" data-day="mon" data-action="closing" onchange="valid_open_close(this)">
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
                                                    <select name="tue_opening" id="tue_opening" class="txtBox" data-day="tue" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->tue_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->tue_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="tue_closing" id="tue_closing" class="txtBox" data-day="tue" data-action="closing" onchange="valid_open_close(this)">
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
                                                    <select name="wed_opening" id="wed_opening" class="txtBox" data-day="wed" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->wed_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->wed_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="wed_closing" id="wed_closing" class="txtBox" data-day="wed" data-action="closing" onchange="valid_open_close(this)">
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
                                                    <select name="thu_opening" id="thu_opening" class="txtBox" data-day="thu" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->thu_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->thu_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="thu_closing" id="thu_closing" class="txtBox" data-day="thu" data-action="closing" onchange="valid_open_close(this)">
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
                                                    <select name="fri_opening" id="fri_opening" class="txtBox" data-day="fri" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->fri_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->fri_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="fri_closing" id="fri_closing" class="txtBox" data-day="fri" data-action="closing" onchange="valid_open_close(this)">
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
                                                    <select name="sat_opening" id="sat_opening" class="txtBox" data-day="sat" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sat_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sat_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="sat_closing" id="sat_closing" class="txtBox" data-day="sat" data-action="closing" onchange="valid_open_close(this)">
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
                                                    <select name="sun_opening" id="sun_opening" class="txtBox" data-day="sun" data-action="opening" onchange="valid_open_close(this)">
                                                        <option value="">Select</option>
                                                        <option value="closed" <?= $facility_hours->sun_opening == 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <?php foreach (halfHourTimes() as $key => $value) : ?>
                                                            <option value="<?= $value ?>" <?= $facility_hours->sun_opening == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="sun_closing" id="sun_closing" class="txtBox" data-day="sun" data-action="closing" onchange="valid_open_close(this)">
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
                    </div>
                </form>
            </div>
        </section>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmqmsf3pVEVUoGAmwerePWzjUClvYUtwM&libraries=geometry,places&ext=.js"></script>
        <script>
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
                        $('#mem_map_lat').val(latitude);
                        $('#mem_map_lng').val(longitude);
                    } else {
                        alert("Request failed.")
                    }
                });
            }
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>