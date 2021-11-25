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
                            <h5>Filter by</h5>
                            <button type="button" class="cross_btn"></button>
                            <form id="searchForm">
                                <div class="in_blk">
                                    <h6>Zip Code</h6>
                                    <input type="text" name="" id="" class="text_box" placeholder="eg: BL0 0WY" value="BL0 0WY" readonly>
                                </div>
                                <div class="in_blk">
                                    <h6>Price</h6>
                                    <input type="text" name="" id="price" value="">
                                </div>
                                <div class="in_blk">
                                    <h6>Distance <small>(miles)</small></h6>
                                    <input type="text" name="" id="distance" value="">
                                </div>
                                <div class="in_blk">
                                    <h6>Rating</h6>
                                    <ul class="ctg_lst rating_st">
                                        <li>
                                            <label for="star_four_five">
                                                <input type="radio" class="rating" id="star_four_five" name="star_rating">
                                                <span class="rateYo" data-rateyo-rating="4.5"></span>
                                                4.5 & up
                                            </label>
                                        </li>
                                        <li>
                                            <label for="star_four">
                                                <input type="radio" class="rating" id="star_four" name="star_rating">
                                                <span class="rateYo" data-rateyo-rating="4"></span>
                                                4.0 & up
                                            </label>
                                        </li>
                                        <li>
                                            <label for="star_three_five">
                                                <input type="radio" class="rating" id="star_three_five" name="star_rating">
                                                <span class="rateYo" data-rateyo-rating="3.5"></span>
                                                3.5 & up
                                            </label>
                                        </li>
                                        <li>
                                            <label for="star_three">
                                                <input type="radio" class="rating" id="star_three" name="star_rating">
                                                <span class="rateYo" data-rateyo-rating="3"></span>
                                                3.0 & up
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="btn_blk">
                                    <button type="reset" class="site_btn md light">Clear</button>
                                    <button type="submit" class="site_btn md">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col col2">
                        <div id="quote_blk" class="blk">
                            <?php if (empty($vendors)) : ?>
                                <div class="srch_blk">
                                    <h5>No quote available.</h5>
                                </div>
                            <?php else : ?>
                                <div class="quotes">
                                    <?php foreach ($vendors as $key => $row) : ?>
                                        <div class="srch_blk" style="display: none;">
                                            <div class="icon"><img src="<?= get_site_image_src("members", $row->mem_image, 'thumb_'); ?>" alt=""></div>
                                            <div class="txt">
                                                <h5><?= $row->mem_fname . ' ' . $row->mem_lname ?></h5>
                                                <div class="rating">
                                                    <div class="rateYo" data-rateyo-rating="<?= get_mem_avg_rating($row->mem_id) ?>"></div>
                                                    <strong>4.1<em>286 ratings</em></strong>
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
                                            <a href="<?= base_url() ?>vendor-detail/<?= doEncode($row->mem_id) ?>/<?= doEncode(round($row->distance, 2)) ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (count($vendors) > 8) : ?>
                            <div class="btn_blk form_btn text-center more-less-quotes">
                                <button onclick="loadMore();" class="site_btn light">More Quotes <i class="fi-arrow-right"></i></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col col3">
                        <div id="map_blk" class="blk">
                            <button type="button" class="cross_btn"></button>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4855.859527591884!2d-79.3863699277487!3d43.641690188092966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b34d68bf33a9b%3A0x15edd8c4de1c7581!2sCN%20Tower!5e0!3m2!1sen!2s!4v1634128919096!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
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
            var total = '<?= count($vendors) ?>';
            var size_quotes = $(".quotes .srch_blk").length;
            var append_size = 4;
            var x = 4;
            $(document).ready(function() {
                $('.quotes .srch_blk:lt(' + x + ')').show();
            });
            const loadMore = () => {
                x = (x + append_size <= size_quotes) ? x + append_size : size_quotes;
                $('.quotes .srch_blk:lt(' + x + ')').show();
                if (x == total) {
                    $('.more-less-quotes').empty().append(`<button onclick="showLess();" class="webBtn lightBtn">Show Less <i class="fi-arrow-right"></i></button>`);
                }
            }
            const showLess = () => {
                x = 4;
                $('.quotes .srch_blk').not(':lt(' + x + ')').hide();
                $('.more-less-quotes').empty().append(`<button onclick="loadMore();" class="webBtn lightBtn">More Quotes <i class="fi-arrow-right"></i></button>`);
            }
        </script>
        <!-- Ion Slider -->
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/ion.slider.min.css') ?>">
        <script type="text/javascript" src="<?= base_url('assets/js/ion.slider.min.js') ?>"></script>
        <script type="text/javascript">
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
                    min: 1,
                    max: 200,
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

                // SEARCH REQUEST DETECTIONS BLOCK
                $(document).on('change', '#price, #distance', function(e) 
                {
                    e.preventDefault();
                    search();
                });

                $(document).on('click', '.rating', function(e) 
                {
                    // e.preventDefault();
                    search();
                });


                var xhr = new window.XMLHttpRequest();
                var ajaxSearch = false;
                function search() 
                {
                    if(xhr && xhr.readyState != 4) {
                        xhr.abort();
                    }
                    if(ajaxSearch)
                        return;

                    ajaxSearch = true;
                    let formData = $("#searchForm").serializeArray();
                    $.ajax({
                        url: base_url + 'search/advance_search_vendors',
                        type: "POST",
                        data: $.param(formData),
                        success: function (rs) {
                            // let data = JSON.parse(rs);
                            // $('#model_records').html(data.html);
                            // if(data.total < 2)
                            //     $('#total_records').html(`${data.total} Result Available`);
                            // else
                            //     $('#total_records').html(`${data.total} Results Available`);
                        },
                        error: function (data) {
                            console.log(data);
                        },
                        complete: function (data) {
                            ajaxSearch = false;
                        },
                        xhr : function(){
                            return xhr;
                        }
                    }); 
                }
                // END SEARCH BLOCK
            });
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>