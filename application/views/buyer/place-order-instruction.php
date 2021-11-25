<!DOCTYPE html>
<html lang="en">

<head>
    <title>Place Order — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body id="home-page">
    <?php $this->load->view('includes/header-buyer'); ?>
    <main common place>


        <section id="sBanner">
            <div class="contain">
                <div class="content">
                    <h2 class="heading">Instruction</h2>
                    <p>Deleniti iste earum sed est distinctio corporis dolore autem, omnis facere amet blanditiis velit!</p>
                </div>
            </div>
            <div class="image"><img src="<?= $base_url ?>images/illustration_step2.svg" alt=""></div>
        </section>
        <!-- sBanner -->


        <section id="place">
            <div class="contain">
                <ul class="numLst semi">
                    <li class="active"><a href="<?= $base_url ?>buyer/place-order.php">1</a></li>
                    <li class="active"><a href="<?= $base_url ?>buyer/place-order-instruction.php">2</a></li>
                    <li><a href="<?= $base_url ?>buyer/place-order-confirmation.php">3</a></li>
                </ul>
                <h2 class="heading text-center">Step 2</h2>
                <ul class="stepLst flex text-center">
                    <li>
                        <div class="inner">
                            <div class="icon"><img src="<?= $base_url ?>images/vector-bag.svg" alt=""></div>
                            <div class="txt">
                                <h5>Allow one service per bag</h5>
                                <p>Unde ut, commodi inventore rerum magni deserunt atque veritatis architecto vel dolorum consequatur est voluptatem repudiandae qui tempora nobis maiores adipisci ipsa?</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="inner">
                            <div class="icon"><img src="<?= $base_url ?>images/vector-tag.svg" alt=""></div>
                            <div class="txt">
                                <h5>Tag or label the bags</h5>
                                <p>Unde ut, commodi inventore rerum magni deserunt atque veritatis architecto vel dolorum consequatur est voluptatem repudiandae qui tempora nobis maiores adipisci ipsa?</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="inner">
                            <div class="icon"><img src="<?= $base_url ?>images/vector-secure.svg" alt=""></div>
                            <div class="txt">
                                <h5>Help Service providers avoid mistakes</h5>
                                <p>Unde ut, commodi inventore rerum magni deserunt atque veritatis architecto vel dolorum consequatur est voluptatem repudiandae qui tempora nobis maiores adipisci ipsa?</p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="bTn text-center"><a href="<?= $base_url ?>buyer/place-order-confirmation.php" class="webBtn">Next</a></div>
            </div>
        </section>
        <!-- place -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>