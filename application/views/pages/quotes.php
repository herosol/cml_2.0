<!DOCTYPE html>
<html lang="en">

<head>

    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="search">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="quotes">
            <div class="contain">
                <div class="flex_row">
                    <div class="col col1">
                        <div id="filter_blk" class="blk filters scrollbar">
                            <span id="showing_records">Filter by</span>
                            <button type="button" class="cross_btn"></button>
                            <form id="searchForm">
                                <div class="in_blk">
                                    <h6>Zip Code</h6>
                                    <input type="text" class="text_box" id="zip" name="zip"  value="<?=$selections['zipcode']?>" readonly>
                                    <span id="invalidZip" style="color: red"></span>
                                </div>
                                <div class="in_blk">
                                    <h6>Price</h6>
                                    <input type="text" name="price" id="price" value="">
                                </div>
                                <div class="in_blk">
                                    <h6>Distance <small>(miles)</small></h6>
                                    <input type="text" name="distance" id="distance" value="">
                                </div>
                                <div class="in_blk">
                                    <h6>Rating</h6>
                                    <ul class="ctg_lst rating_st">
                                        <li>
                                            <label for="star_four_five">
                                                <input type="radio" class="rating" id="star_four_five" name="star_rating" value="4.5">
                                                <span class="rateYo" data-rateyo-rating="4.5"></span>
                                                4.5 - 5.0
                                            </label>
                                        </li>
                                        <li>
                                            <label for="star_four">
                                                <input type="radio" class="rating" id="star_four" name="star_rating" value="4">
                                                <span class="rateYo" data-rateyo-rating="4"></span>
                                                4.0 & up
                                            </label>
                                        </li>
                                        <li>
                                            <label for="star_three_five">
                                                <input type="radio" class="rating" id="star_three_five" name="star_rating" value="3.5">
                                                <span class="rateYo" data-rateyo-rating="3.5"></span>
                                                3.5 & up
                                            </label>
                                        </li>
                                        <li>
                                            <label for="star_three">
                                                <input type="radio" class="rating" id="star_three" name="star_rating" value="3">
                                                <span class="rateYo" data-rateyo-rating="3"></span>
                                                3.0 & up
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="btn_blk">
                                    <button type="button" id="clear" class="site_btn md light" disabled>
                                        <i class="spinner hidden"></i>Clear
                                    </button>
                                    <button type="button" id="search" class="site_btn md">
                                        <i class="spinner hidden"></i>Apply
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col col2" id=quotes-section>
                        <div id="quote_blk" class="blk">
                            <input type="hidden" value="<?=count($vendors)?>" id="total-vendors" />
                            <?php if (empty($vendors)) : ?>
                                <div class="srch_blk">
                                    <h5>No quote available.</h5>
                                </div>
                            <?php else : ?>
                                <div class="quotes">
                                    <?php foreach ($vendors as $key => $row) : ?>
                                        <div class="srch_blk" style="display: none;">
                                            <div class="icon"><img data-original="<?= get_site_image_src("members", $row->mem_image, 'thumb_'); ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                                            <div class="txt">
                                                <h5><?= $row->mem_fname . ' ' . $row->mem_lname ?></h5>
                                                <div class="rating">
                                                    <div class="rateYo" data-rateyo-rating="<?= get_mem_avg_rating($row->mem_id) ?>"></div>
                                                    <strong><?= get_mem_avg_rating($row->mem_id) ?><em><?= count_mem_ratings($row->mem_id) ?> <?= count_mem_ratings($row->mem_id) > 1 ? 'ratings' : 'rating' ?></em></strong>
                                                </div>
                                                <div class="price">Estimated Price<strong>£<?= $row->estimated_price ?></strong></div>
                                                <?php if ($row->mem_company_pickdrop == 'yes') : ?>
                                                    <p>Pickup & Delivery Service Available</p>
                                                <?php else : ?>
                                                    <p>Pickup & Delivery Service Not Available</p>
                                                <?php endif; ?>
                                                <small><?= round($row->distance, 2) ?> Miles Away</small>
                                            </div>
                                            <?php if ($row->mem_company_pickdrop == 'yes') : ?>
                                                <div class="serve">
                                                    <div class="symbol"><img src="<?= base_url() ?>assets/images/vector-wait.svg" alt=""></div>
                                                </div>
                                            <?php else : ?>
                                                <div class="serve">
                                                    <div class="symbol"><img src="<?= base_url() ?>assets/images/vector-wait-cross.svg" alt=""></div>
                                                </div>
                                            <?php endif; ?>
                                            <a href="<?= base_url() ?>order-booking/<?= doEncode($row->mem_id) ?>/<?= doEncode(round($row->distance, 2)) ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (count($vendors) > 3) : ?>
                            <div class="btn_blk form_btn text-center more-less-quotes">
                                <button onclick="loadMore();" class="site_btn light">More Quotes <i class="fi-arrow-right"></i></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col col3">
                        <div id="map_blk" class="blk"></div>
                    </div>
                </div>
                <div id="filter_btn_blk" class="btn_blk">
                    <button type="button" id="map_btn" class="site_btn auto light">View Map</button>
                    <button type="button" id="filter_btn" class="site_btn auto">View Filters</button>
                </div>
            </div>
        </section>
        <!-- quotes -->


        <script type="text/javascript">
            var x,size_quotes, append_size, total;
            function loadQuotes()
            {
                total = $("#total-vendors").val();
                size_quotes = $(".quotes .srch_blk").length;
                append_size = 3;
                x = 3;
                
                $('.quotes .srch_blk:lt(' + x + ')').show();
            }
            $(document).ready(function() {
                loadQuotes();
                records_showing();
            });

            const loadMore = () => {
                x = (x + append_size <= size_quotes) ? x + append_size : size_quotes;
                $('.quotes .srch_blk:lt(' + x + ')').show();
                if (x == total) {
                    $('.more-less-quotes').empty().append(`<button onclick="showLess();" class="site_btn light">Show Less <i class="fi-arrow-right"></i></button>`);
                }
                records_showing();
            }
            const showLess = () => {
                x = 3;
                $('.quotes .srch_blk').not(':lt(' + x + ')').hide();
                $('.more-less-quotes').empty().append(`<button onclick="loadMore();" class="site_btn light">More Quotes <i class="fi-arrow-right"></i></button>`);
                records_showing();
                window.scrollTo({top: 0, behavior: 'smooth'});
            }

            const records_showing = () => {
                $('#showing_records').html(`Showing <em>${total <= x ? total : x}</em> out of total <em>${total}</em> ${total > 1 ? 'records' : 'record'}`);
            }
        </script>
        <!-- Ion Slider -->
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/ion.slider.min.css') ?>">
        <script type="text/javascript" src="<?= base_url('assets/js/ion.slider.min.js') ?>"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmqmsf3pVEVUoGAmwerePWzjUClvYUtwM&libraries=geometry,places&ext=.js"></script>
        <script type="text/javascript">
            var locations = <?=$locations?>;

            var map, bounds, startLat = locations[0][1], startLng = locations[0][2];
            var markers = [];
            var infowindows = [];
            var haveGeoLocation = false;
            var startLatLng = new google.maps.LatLng(startLat, startLng);
            var user_icon = {
                    url: base_url + "assets/images/user_marker.png", // url
                    scaledSize: new google.maps.Size(50, 50), // scaled size
                    origin: new google.maps.Point(0, 0), // origin
                    anchor: new google.maps.Point(25, 50) // anchor
                };

            $(window).on("load", function() {
                $('#price').ionRangeSlider({
                    skin: 'square',
                    min: 1,
                    max: 140,
                    type: 'double',
                    prettify: function(num) {
                        return '£' + num;
                    },
                    onFinish: function(data) {
                        // searchFunction();
                    },
                    grid: true
                });
                $('#distance').ionRangeSlider({
                    skin: 'square',
                    min: 0,
                    max: 50,
                    type: 'double',
                    prettify: function(num) {
                        return num;
                    },
                    onFinish: function(data) {
                        // searchFunction();
                    },
                    grid: true
                });

                $(document).on("click", "#filter_btn", function() {
                    $("#filter_blk").addClass("active");
                });
                $(document).on("click", "#filter_blk .cross_btn", function() {
                    $("#filter_blk").removeClass("active");
                });
                $(document).on("click", "#map_btn", function() {
                    $("#map_blk").addClass("active");
                });
                $(document).on("click", "#map_blk .cross_btn", function() {
                    $("#map_blk").removeClass("active");
                });
            });

            $(document).on('click', '#clear', function(e) {
                e.preventDefault();
                $('#price').ionRangeSlider({
                    skin: 'square',
                    min: 1,
                    max: 140,
                    type: 'double',
                    prettify: function(num) {
                        return '£' + num;
                    },
                    onFinish: function(data) {
                        // searchFunction();
                    },
                    grid: true
                });
                $('#distance').ionRangeSlider({
                    skin: 'square',
                    min: 0,
                    max: 50,
                    type: 'double',
                    prettify: function(num) {
                        return num;
                    },
                    onFinish: function(data) {
                        // searchFunction();
                    },
                    grid: true
                });
                $('.rating').prop('checked', false);
                search($(this));
                $('#clear').prop('disabled', true);
                
            });
            $(document).on('click', '#search', function(e) 
            {
                e.preventDefault();
                search($(this));
            });
            $(document).ready(function() {
                $('#searchForm').on('input change', function() {
                    $('#clear').attr('disabled', false);
                });
            });

            var xhr = new window.XMLHttpRequest();
            var ajaxSearch = false;
            function search(btn = null) 
            {
                if(xhr && xhr.readyState != 4) {
                    xhr.abort();
                }
                if(ajaxSearch)
                    return;

                let frmIcon;
                if(btn !== null)
                {   
                    frmIcon = btn.find('i.spinner');
                    frmIcon.removeClass('hidden');
                    frmIcon.prop('disabled', true);
                }

                ajaxSearch = true;
                let formData = $("#searchForm").serializeArray();
                $.ajax({
                    async: false,
                    url: base_url + 'search/advance_search_vendors',
                    type: "POST",
                    data: $.param(formData),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#quotes-section').html('Loading...');
                    },
                    success: function (res) {
                        if(btn !== null)
                        {
                            frmIcon.addClass('hidden');
                            frmIcon.prop('disabled', false);
                        }
                        $('#quotes-section').html(res.html);
                        $('#total-vendors').val(res.total);
                        loadQuotes();
                        records_showing();
                        $("img[lazy]").lazyload();
                        $('.rateYo').rateYo({
                            fullStar: true,
                            readOnly: true,
                            normalFill: '#ddd',
                            ratedFill: '#ffc000',
                            starWidth: '14px',
                            spacing: '2px'
                        });
                        locations = res.locations;
                        if(locations.length > 0)
                        {
                            $('#map_blk').show();
                            startLat = locations[0][1];
                            startLng = locations[0][2];
                            startLatLng = new google.maps.LatLng(startLat, startLng);
                            init();
                        }
                        else{
                            $('#map_blk').hide();
                        }
                    },
                    error: function (data) {
                    },
                    complete: function (data) {
                        ajaxSearch = false;
                    },
                    xhr : function(){
                        return xhr;
                    }
                }); 
            }

            // $(document).ready(function () {
            //     // SEARCH REQUEST DETECTIONS BLOCK
            //     $(document).on('submit', '#searchForm', function(e){
            //         e.preventDefault();
            //         $('#invalidZip').html('');

            //         let zipcode = $.trim($('#zip').val());
            //         if (zipcode.length == 0){
            //             $('#invalidZip').html('Please enter a valid zip.');
            //             return false;
            //         }

            //         var geocoder = new google.maps.Geocoder();
            //         geocoder.geocode({
            //             componentRestrictions: {
            //                 country: 'gb',
            //                 postalCode: zipcode
            //             }
            //         }, function(results, status) {
            //             if (status == google.maps.GeocoderStatus.OK) {
            //                 $('#invalidZip').html('');
            //                 latitude = results[0].geometry.location.lat();
            //                 longitude = results[0].geometry.location.lng();

            //                 let form = this;
            //                 let formData = new FormData(form);
            //                 $.ajax({
            //                     async: false,
            //                     url: base_url + 'search/advance_search_vendors',
            //                     type: "POST",
            //                     data: formData,
            //                     dataType: 'json',
            //                     success: function (res) {
            //                         $('#quotes-section').html(res.html);
            //                         loadQuotes();
            //                         $("img[lazy]").lazyload();
            //                         $('.rateYo').rateYo({
            //                             fullStar: true,
            //                             readOnly: true,
            //                             normalFill: '#ddd',
            //                             ratedFill: '#ffc000',
            //                             starWidth: '14px',
            //                             spacing: '2px'
            //                         });
            //                         locations = res.locations;
            //                         if(locations.length > 0)
            //                         {
            //                             $('#map_blk').show();
            //                             startLat = locations[0][1];
            //                             startLng = locations[0][2];
            //                             startLatLng = new google.maps.LatLng(startLat, startLng);
            //                             init();
            //                         }
            //                         else{
            //                             $('#map_blk').hide();
            //                         }
            //                     },
            //                     error: function (data) {
            //                     },
            //                     complete: function (data) {
            //                         ajaxSearch = false;
            //                     },
            //                     xhr : function(){
            //                         return xhr;
            //                     }
            //                 }); 
            //             } else {
            //                 $('#invalidZip').html('Please enter a valid zip.');
            //             }
            //         });
            //     });
            //     // END SEARCH BLOCK
            // });

            function init() {
                map = new google.maps.Map(document.getElementById('map_blk'), {
                    center: startLatLng,
                    zoom: 10
                });
                bounds = new google.maps.LatLngBounds();
                searchAreaMarker = new google.maps.Marker({
                    position: startLatLng,
                    map: map,
                    draggable: false,
                    icon: user_icon,
                    animation: google.maps.Animation.DROP,
                    title: 'My Location'
                });
                setMarkers(map, locations);
            }

            function setMarkers(map, locations) {
                closeInfos();
                closeMarks();
                markers = [];
                infowindows = [];
                if (locations.length > 0)
                {
                    for (var i = 0; i < locations.length; i++) {
                        
                        var location = locations[i];
                        var title = location[0],
                        lat = location[1],
                        lng = location[2],
                        content = location[4];
                        var latlngset = new google.maps.LatLng(lat, lng);
                        
                        markers[i] = new google.maps.Marker({
                            position: latlngset,
                            map: map,
                            icon: user_icon,
                            title: title,
                        });

                        infowindows[i] = new google.maps.InfoWindow({
                            content: content
                        });
                        google.maps.event.addListener(markers[i], 'click', (function (inneri) {
                            return function () {
                                closeInfos();
                                infowindows[inneri].open(map, markers[inneri]);
                            }
                        })(i));
                        google.maps.event.addListener(infowindows[i], 'domready', function () {
                            var iwOuter = $('.gm-style-iw');
                            var iwBackground = iwOuter.prev();
                            // Remove the background shadow DIV
                            iwBackground.children(':nth-child(2)').css({'display': 'none'});
                            // Remove the white background DIV
                            iwBackground.children(':nth-child(4)').css({'display': 'none'});
                            iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index': '1'});
                            // Moves the shadow of the arrow 76px to the left margin 
                            iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                                return s + 'margin-top: 2px !important;'
                            });
                            // Moves the arrow 76px to the left margin 
                            iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                                return s + 'margin-top: 2px !important;'
                            });
                            iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index': '1'});
                            var iwCloseBtn = iwOuter.next();
                            // Apply the desired effect to the close button
                            iwCloseBtn.css({
                                opacity: '1', // by default the close button has an opacity of 0.7
                                right: '28px', top: '3px', // button repositioning
                                border: '7px solid #fff', // increasing button border and new color
                                'border-radius': '13px', // circular effect
                                'padding': '6px', // padding
                                'box-shadow': '0 0 5px #3990B9', // 3D effect to highlight the button
                                'z-index': '999999', // z-index
                            });
                            // The API automatically applies 0.7 opacity to the button after the mouseout event.
                            // This function reverses this event to the desired value.
                            iwCloseBtn.mouseout(function () {
                                $(this).css({opacity: '1'});
                            });
                        });
                        google.maps.event.addListener(map, 'click', function () {
                            closeInfos();
                        });
                    }
                }
            }

            function closeInfos() {
                if (infowindows.length > 0) {
                    for (var i = 0; i < infowindows.length; i++)
                    {
                        infowindows[i].close();
                    }
                }
            }

            function closeMarks() {
                if (markers.length > 0) {
                    for (var i = 0; i < markers.length; i++)
                    {
                        markers[i].setMap(null);
                    }
                }
            }

            google.maps.event.addDomListener(window, 'load', init);
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>