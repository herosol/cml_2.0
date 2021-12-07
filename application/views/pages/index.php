<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="index">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="banner" class="flex_box" style="background-image: url('<?= getImageSrc(UPLOAD_PATH . "images/", $content['image1']) ?>');">
            <div class="flex_dv">
                <div class="contain">
                    <div class="content text-center">
                        <h1><?= $content['banner_heading'] ?></h1>
                        <?php if ($this->session->mem_type == 'vendor') : ?>
                            <div class="btn_blk form_btn">
                                <a href="<?= base_url('promotions-offers') ?>" class="site_btn lg round simple">Learn More</a>
                                <a href="<?= base_url('contact') ?>" class="site_btn lg round">Contact us</a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php echo showMsg(); ?>
                    <?php if (empty($this->session->mem_type) || $this->session->mem_type == 'buyer') : ?>
                        <form action="" method="POST" data-form="search">
                            <div class="inside">
                                <div class="form_blk">
                                    <img src="<?= base_url('assets/images/icon-map-marker.svg') ?>" alt="">
                                    <input type="text" name="zip" id="zip" class="text_box" placeholder="Type your Postcode">
                                    <span id="invalidZip"></span>
                                </div>
                                <div class="btn_blk">
                                    <button type="button" class="site_btn" id="searchZipForm">
                                        <i class="spinner hidden"></i><?= $content['search_btn_title'] ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!-- banner -->

        <section id="deals" style="background-image: url('<?= base_url('assets/images/shape_01.svg') ?>');">
            <div class="contain">
                <div class="flex_row">
                    <div class="col col1">
                        <h2 class="heading"><?= $content['deals_headings'] ?></h2>
                        <p><?= $content['deals_tagline'] ?></p>
                    </div>
                    <div class="col col2">
                        <div class="flex_row full_height">
                            <div class="col">
                                <div class="small_blk">
                                    <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image10']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                                    <div class="txt">
                                        <h4><?= $content['deal1_heading'] ?></h4>
                                        <p><?= $content['deal1_details'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="small_blk">
                                    <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image11']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                                    <div class="txt">
                                        <h4><?= $content['deal2_heading'] ?></h4>
                                        <p><?= $content['deal2_details'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="small_blk">
                                    <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image12']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                                    <div class="txt">
                                        <h4><?= $content['deal3_heading'] ?></h4>
                                        <p><?= $content['deal3_details'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="small_blk">
                                    <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image13']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                                    <div class="txt">
                                        <h4><?= $content['deal4_heading'] ?></h4>
                                        <p><?= $content['deal4_details'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- deals -->


        <section id="intro">
            <div class="contain">
                <div class="flex_row">
                    <div class="col col1">
                        <div class="fancy_image" style="background-image: url('<?= base_url('assets/images/shape_02.svg') ?>');">
                            <div class="fig"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image2']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                        </div>
                    </div>
                    <div class="col col2">
                        <div class="content">
                            <h1 class="heading"><?= $content['section3_heading'] ?></h1>
                            <p><?= $content['section3_desc'] ?></p>
                            <div class="btn_blk">
                                <a href="<?= base_url($content['section3_button_link']) ?>" class="site_btn lg round"><?= $content['section3_button_text'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- intro -->


        <section id="listing">
            <div class="contain">
                <div class="flex_row full_height">
                    <div class="col">
                        <div class="small_blk">
                            <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image6']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                            <div class="txt">
                                <h4><?= $content['media1_heading'] ?></h4>
                                <p> <?= $content['media1_detail'] ?> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="small_blk">
                            <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image7']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                            <div class="txt">
                                <h4><?= $content['media2_heading'] ?></h4>
                                <p> <?= $content['media2_detail'] ?> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="small_blk">
                            <div class="icon"><img data-original="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image8']) ?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy></div>
                            <div class="txt">
                                <h4><?= $content['media3_heading'] ?></h4>
                                <p> <?= $content['media3_detail'] ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- listing -->


        <section id="works" style="background-image: url('<?= base_url('assets/images/shape_04.svg') ?>');">
            <div class="contain text-center">
                <div class="content">
                    <h1 class="heading"><?= $content['card_heading'] ?></h1>
                </div>
                <div class="flex_row">
                    <div class="col">
                        <div class="work_blk">
                            <div class="num">01</div>
                            <div class="txt">
                                <h3><?= $content['card1_heading'] ?></h3>
                                <p><?= $content['card1_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="work_blk">
                            <div class="num">02</div>
                            <div class="txt">
                                <h3><?= $content['card2_heading'] ?></h3>
                                <p><?= $content['card2_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="work_blk">
                            <div class="num">03</div>
                            <div class="txt">
                                <h3><?= $content['card3_heading'] ?></h3>
                                <p><?= $content['card3_details'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- works -->


        <?php if (!empty($testimonials)) { ?>
            <section id="folio">
                <div class="contain text-center">
                    <h1 class="heading"><?= $content['testimonials_heading'] ?></h1>
                    <!-- <h1 class="heading">What They’re <em>Saying</em></h1> -->
                    <div id="owl-folio" class="owl-carousel owl-theme">
                        <?php foreach ($testimonials as $testimonial) { ?>
                            <div class="folio_blk">
                                <div class="ico"><img  src="<?= getImageSrc(UPLOAD_PATH . "testimonials/", $testimonial->image) ?>" alt=""></div>
                                <p><?= $testimonial->detail ?></p>
                                <h4><?= $testimonial->name ?> <span><?= $testimonial->city ?></span></h4>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        <?php } ?>
        <!-- folio -->


        <section id="posts">
            <div class="contain">
                <h1 class="heading text-center"><?= $content['last_heading'] ?></h1>
                <div class="flex_row">
                    <?php foreach($blogs as $blog): ?>
                        <div class="col">
                            <div class="post_blk">
                                <div class="image">
                                    <a href="<?= base_url('blog-detail/').doEncode($blog->id).'/'.toSlugUrl($blog->title) ?>">
                                        <img data-original="<?=get_site_image_src("blogs/thumbs", $blog->image)?>" src="<?=base_url('assets/images/loading.gif')?>" alt="" lazy>
                                    </a>
                                </div>
                                <div class="txt">
                                    <div class="date"><?= format_date($blog->created_date,'M d Y h:i:s A'); ?></div>
                                    <h4><a href="<?= base_url('blog-detail/').doEncode($blog->id).'/'.toSlugUrl($blog->title) ?>"><?= short_text($blog->title, 60); ?></a></h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- posts -->


        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmqmsf3pVEVUoGAmwerePWzjUClvYUtwM&libraries=geometry,places&ext=.js"></script>
        <script type="text/javascript">
            $(document).on('click', '#searchZipForm', function () {
                $('#invalidZip').html('');
                let zipcode = $.trim($('#zip').val());
                if (zipcode.length == 0)
                    return false;
                    
                let frmIcon = $(this).find("i.spinner");
                let btn = $(this);
                frmIcon.removeClass("hidden");
                btn.prop('disabled', true);


                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    componentRestrictions: {
                        country: 'gb',
                        postalCode: zipcode
                    }
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        $('#invalidZip').html('');
                        latitude = results[0].geometry.location.lat();
                        longitude = results[0].geometry.location.lng();
                        window.location = base_url + 'service-selection?zipcode=' + zipcode + '&lat=' + latitude + '&long=' + longitude;
                    } else {
                        frmIcon.addClass("hidden");
                        btn.prop('disabled', false);
                        $('#invalidZip').html('Please enter a valid zip.');
                    }
                });
            });
        </script>


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>