<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="title" content="Compare My Laundry">
<meta name="description" content="Laundry & Dry Cleaning Services in the UK.">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= base_url() ?>assets/index.php">
<meta property="og:title" content="Compare My Laundry">
<meta property="og:description" content="Laundry & Dry Cleaning Services in the UK.">
<meta property="og:image" content="<?= base_url() ?>assets/images/thumbnail.jpg">
<meta property="twitter:card" content="thumbnail">
<meta property="twitter:url" content="<?= base_url() ?>assets/index.php">
<meta property="twitter:title" content="Compare My Laundry">
<meta property="twitter:description" content="Laundry & Dry Cleaning Services in the UK.">
<meta property="twitter:image" content="<?= base_url() ?>assets/images/thumbnail.jpg">


<!-- Css files -->
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/app.min.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/owl.carousel.min.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/owl.theme.default.min.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/datepicker.min.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/toastr.min.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.passwordRequirements.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/countdown.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/fancybox.min.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/select.min.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css">


<!-- JS Files -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.dirrty.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/toastr.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/lazyload.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/crafty_postcode.class.js') ?>"></script>
<script type="text/javascript">
    var base_url = "<?= base_url() ?>";
</script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.passwordRequirements.min.js') ?>"></script>
<script type="text/javascript">
    $(function () {
        $("img[lazy]").lazyload();
    });
    
    $(function() {
        $(".pr-password").passwordRequirements({
            numCharacters: 8,
            useLowercase: true,
            useUppercase: true,
            useNumbers: true,
            useSpecial: true
        });
    });
</script>
<script type="text/javascript" src="<?= base_url('assets/js/owl.carousel.min.js') ?>"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        $('#owl-folio').owlCarousel({
            nav: true,
            navText: ['', ''],
            // dots: false,
            loop: true,
            margin: 30,
            smartSpeed: 1000,
            autoplayTimeout: 8000,
            autoplayHoverPause: true,
            items: 1
        });
        $('form.checkstate').dirrty({
            preventLeaving: false
            // this function is called when the form.trigger's "dirty"
        }).on("dirty", function() {
            $('button.submit').removeAttr('disabled');
            $('button.submit').removeAttr('title');
            // this function is called when the form.trigger's "clean"
        }).on("clean", function() {
            $('button.submit').prop('disabled', true);
            $('button.submit').prop('title', 'Please make any change to enable save button.');
        });
        $('#owl-serve').owlCarousel({
            dots: false,
            nav: true,
            navText: ['<i class="fi-chevron-left"></i>', '<i class="fi-chevron-right"></i>'],
            loop: false,
            margin: 20,
            smartSpeed: 1000,
            autoplayTimeout: 8000,
            autoplayHoverPause: true,
            mouseDrag: false,
            touchDrag: false,
            pullDrag: false,
            responsive: {
                0: {
                    items: 1
                },
                580: {
                    items: 2
                },
                991: {
                    items: 6
                }
            }
        });
        $('#owl-partner').owlCarousel({
            dots: false,
            loop: true,
            margin: 40,
            smartSpeed: 1000,
            autoWidth: true,
            autoplayTimeout: 8000,
            autoplayHoverPause: true,
            items: 10
        });
    });
</script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/datepicker.min.js"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        $('.datepicker').datepicker({
            // multidate: true,
            format: 'mm-dd-yyyy',
            todayHighlight: true,
            multidateSeparator: ',  '
        });
    });
</script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.rateyo.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.rateYo').rateYo({
            rating: 4.0,
            fullStar: true,
            readOnly: true,
            normalFill: '#ddd',
            ratedFill: '#ffc000',
            starWidth: '14px',
            spacing: '2px'
        });
        $(document).on("rateyo.set", '#rating', function(e, data) {
            let rating = data.rating;
            $('input[name="rating"]').val(rating);
        });
    });
</script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/circle-progress.js"></script>
<script type="text/javascript">
    $(function() {
        function animateElements() {
            $('.progressbar').each(function() {
                var elementPos = $(this).offset().top;
                var topOfWindow = $(window).scrollTop();
                var percent = $(this).find('.circle').attr('data-percent');
                var percentage = parseInt(percent, 10) / parseInt(100, 10);
                var animate = $(this).data('animate');
                if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                    $(this).data('animate', true);
                    $(this).find('.circle').circleProgress({
                        startAngle: -Math.PI / 2,
                        value: percent / 100,
                        thickness: 10,
                        size: 200,
                        fill: {
                            color: '#016ecf'
                        }
                    }).on('circle-animation-progress', function(event, progress, stepValue) {
                        $(this).find('div').text((stepValue * 100).toFixed(1) + "%");
                    }).stop();
                }
            });
        }
        // Show animated elements
        animateElements();
        $(window).scroll(animateElements);
    });

    function ucfirst(str, force) {
        str = force ? str.toLowerCase() : str;
        return str.replace(/(\b)([a-zA-Z])/,
            function(firstLetter) {
                return firstLetter.toUpperCase();
            });
    }
</script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select.min.js"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        $('.selectpicker').selectpicker();
    });
</script>


<!-- Favicon -->
<link type="image/png" rel="icon" href="<?= getImageSrc(UPLOADIMAGE . 'images/', $site_settings->site_icon) ?>">