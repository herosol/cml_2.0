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