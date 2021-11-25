<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body id="home-page" lndg>
    <?php $this->load->view('includes/header'); ?>
    <main index>
        <section id="banner" class="flexBox">
            <div class="flexDv">
                <div class="contain">
                    <div class="outer">
                        <div class="content">
                            <h4><?= $content['banner_tagline'] ?></h4>
                            <h1><?= $content['banner_heading'] ?></h1>
                            <p><?= $content['banner_detail'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="image"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image1']) ?>" alt=""></div>
        </section>
        <!-- banner -->


        <section id="timer">
            <div class="contain">
                <div id="counter" class="text-center">
                    <h2 class="regular"><?= $content['timer_heading'] ?></h2>
                    <div class="main-example">
                        <div class="countdown-container" id="main-example"></div>
                    </div>
                    <h3 class="regular"><?= $content['timer_detail'] ?></h3>
                </div>
            </div>
        </section>
        <!-- timer -->


        <section id="what">
            <div class="contain">
                <div class="flexRow flex">
                    <div class="col col1">
                        <div class="content">
                            <h1 class="heading"><?= $content['section3_heading'] ?></h1>
                            <p><?= $content['section3_detail'] ?></p>
                            <div class="bTn">
                                <a href="<?= makeExternalUrl($content['section3_btn_link']) ?>" class="webBtn"><?= $content['section3_btn_title'] ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col col2">
                        <div class="image"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image2']) ?>" alt=""></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- what -->


        <section id="customer">
            <div class="contain text-center">
                <div class="flexRow flex">
                    <div class="col">
                        <div class="inner">
                            <h2><?= $content['buyer_heading'] ?></h2>
                            <div class="vidBlk popBtn" data-popup="video" data-store="<?= $content['buyer_video'] ?>" style="background-image: url('<?= getImageSrc(UPLOAD_PATH . "images/", $content['image3']) ?>');"></div>
                            <h4><?= $content['buyer_input_heading'] ?></h4>
                            <form action="" method="post">
                                <div class="txtGrp">
                                    <label for="">Email Address</label>
                                    <input type="text" name="" id="" class="txtBox">
                                </div>
                                <div class="bTn"><button type="submit" class="webBtn simpleBtn"><?= $content['buyer_btn_title'] ?></button></div>
                            </form>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner disable">
                            <h2><?= $content['vendor_heading'] ?></h2>
                            <div class="vidBlk popBtn" data-popup="video" data-store="<?= $content['vendor_video'] ?>-w" style="background-image: url('<?= getImageSrc(UPLOAD_PATH . "images/", $content['image4']) ?>');"></div>
                            <h4><?= $content['vendor_input_heading'] ?></h4>
                            <form action="" method="post">
                                <div class="txtGrp">
                                    <label for="">Email Address</label>
                                    <input type="text" name="" id="" class="txtBox">
                                </div>
                                <div class="bTn"><button type="submit" class="webBtn simpleBtn"><?= $content['vendor_btn_title'] ?></button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup" data-popup="video">
                <div class="tableDv">
                    <div class="tableCell">
                        <div class="crosBtn"></div>
                        <div class="contain">
                            <div id="vidBlk" class="vidBlk inside">
                                <!-- <iframe src="https://www.youtube.com/embed/X_zf0n0PC-w"></iframe> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- customer -->


        <section id="blocks">
            <div class="contain text-center">
                <h1 class="heading">The Benefits</h1>
                <div class="flexRow flex">
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image5']) ?>" alt=""></div>
                            <div class="txt">
                                <h3><?= $content['benefit1_heading'] ?></h3>
                                <p><?= $content['benefit1_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image6']) ?>" alt=""></div>
                            <div class="txt">
                                <h3><?= $content['benefit2_heading'] ?></h3>
                                <p><?= $content['benefit2_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image7']) ?>" alt=""></div>
                            <div class="txt">
                                <h3><?= $content['benefit3_heading'] ?></h3>
                                <p><?= $content['benefit3_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image8']) ?>" alt=""></div>
                            <div class="txt">
                                <h3><?= $content['benefit4_heading'] ?></h3>
                                <p><?= $content['benefit4_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image9']) ?>" alt=""></div>
                            <div class="txt">
                                <h3><?= $content['benefit5_heading'] ?></h3>
                                <p><?= $content['benefit5_details'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="inner">
                            <div class="icon"><img src="<?= getImageSrc(UPLOAD_PATH . "images/", $content['image10']) ?>" alt=""></div>
                            <div class="txt">
                                <h3><?= $content['benefit6_heading'] ?></h3>
                                <p><?= $content['benefit6_details'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- blocks -->


        <!-- Countdown Js -->
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/countdown.css">
        <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.countdown.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/lodash.min.js"></script>
        <script type="text/template" id="main-example-template">
            <div class="time <%= label %>">
            <span class="count curr top"><%= curr %></span>
            <span class="count next top"><%= next %></span>
            <span class="count next bottom"><%= next %></span>
            <span class="count curr bottom"><%= curr %></span>
            <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
            </div>
        </script>
        <script type="text/javascript">
            $(window).on('load', function() {
                var labels = ['weeks', 'days', 'hours', 'minutes', 'seconds'],
                    nextYear = '2022/08/05',
                    template = _.template($('#main-example-template').html()),
                    currDate = '00:00:00:00:00',
                    nextDate = '00:00:00:00:00',
                    parser = /([0-9]{2})/gi,
                    $example = $('#main-example');
                // Parse countdown string to an object
                function strfobj(str) {
                    var parsed = str.match(parser),
                        obj = {};
                    labels.forEach(function(label, i) {
                        obj[label] = parsed[i]
                    });
                    return obj;
                }
                // Return the time components that diffs
                function diff(obj1, obj2) {
                    var diff = [];
                    labels.forEach(function(key) {
                        if (obj1[key] !== obj2[key]) {
                            diff.push(key);
                        }
                    });
                    return diff;
                }
                // Build the layout
                var initData = strfobj(currDate);
                labels.forEach(function(label, i) {
                    $example.append(template({
                        curr: initData[label],
                        next: initData[label],
                        label: label
                    }));
                });
                // Starts the countdown
                $example.countdown(nextYear, function(event) {
                    var newDate = event.strftime('%w:%D:%H:%M:%S'),
                        data;
                    if (newDate !== nextDate) {
                        currDate = nextDate;
                        nextDate = newDate;
                        // Setup the data
                        data = {
                            'curr': strfobj(currDate),
                            'next': strfobj(nextDate)
                        };
                        // Apply the new values to each node that changed
                        diff(data.curr, data.next).forEach(function(label) {
                            var selector = '.%s'.replace(/%s/, label),
                                $node = $example.find(selector);
                            // Update the node
                            $node.removeClass('flip');
                            $node.find('.curr').text(data.curr[label]);
                            $node.find('.next').text(data.next[label]);
                            // Wait for a repaint to then flip
                            _.delay(function($node) {
                                $node.addClass('flip');
                            }, 50, $node);
                        });
                    }
                });
            });
        </script>
    </main>
    <?php $this->load->view('includes/footer-sm'); ?>
</body>

</html>