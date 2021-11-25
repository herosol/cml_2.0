<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title ?> — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="serve">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="offer">
            <div class="contain">
                <div class="content">
                    <h1 class="heading"><?= $content['heading'] ?></h1>
                    <p><?= $content['header_detail'] ?></p>
                </div>
                <form action="" method="post" class="frmAjax">
                    <input type="hidden" name="zipcode" value="<?= $_GET['zipcode'] ?>">
                    <input type="hidden" name="lat" value="<?= $_GET['lat'] ?>">
                    <input type="hidden" name="long" value="<?= $_GET['long'] ?>">
                    <div class="flex_row">
                        <div class="col col1">
                            <ul class="svc_lst">
                                <li class="active">
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $wash_and_dry->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $wash_and_dry->name ?></strong>
                                            <!-- <p>Everyday laundry, washed and tumble-dried. No ironing.</p> -->
                                        </div>
                                        <a data-toggle="tab" href="#WashDry"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $wash_and_iron->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $wash_and_iron->name ?></strong>
                                            <!-- <p>Laundry that is ironed after tumble-drying and put on hangers.</p> -->
                                        </div>
                                        <a data-toggle="tab" href="#WashIron"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $dry_cleaning->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $dry_cleaning->name ?></strong>
                                            <!-- <p>Delicate items and fabrics. Cleaned, ironed and put on hangers.</p> -->
                                        </div>
                                        <a data-toggle="tab" href="#DryCleaning"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $iron_only->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $iron_only->name ?></strong>
                                            <!-- <p>Items that are already washed. Priced per item.</p> -->
                                        </div>
                                        <a data-toggle="tab" href="#IronOnly"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $buly_items->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $buly_items->name ?></strong>
                                            <!-- <p>Larger items requiring different processing.</p> -->
                                        </div>
                                        <a data-toggle="tab" href="#BulkyItems"></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col col2">
                            <div class="blk tab-content">
                                <div id="WashDry" class="tab-pane fade in active">
                                    <h4><?= $wash_and_dry->name ?></h4>
                                    <p><?= $wash_and_dry->details ?></p>
                                    <hr>
                                    <div class="serve_blk">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $wash_and_dry->image, ''); ?>" alt=""></div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Items</th>
                                                    <th width="40" class="text-center">Action</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($wash_and_dry->id) as $key => $sub_service) :
                                                ?>
                                                    <tr id="<?= $sub_service->id ?>">
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><button type="button" id="<?= $sub_service->id ?>" class="act_btn add_btn left" data-subservice-id="<?= $sub_service->id ?>" data-name="<?= $sub_service->name ?>"></button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="DryCleaning" class="tab-pane fade">
                                    <h4><?= $dry_cleaning->name ?></h4>
                                    <p><?= $dry_cleaning->details ?></p>
                                    <hr>
                                    <div class="serve_blk">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $dry_cleaning->image, ''); ?>" alt=""></div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Items</th>
                                                    <th width="40" class="text-center">Action</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($dry_cleaning->id) as $key => $sub_service) :
                                                ?>
                                                    <tr id="<?= $sub_service->id ?>">
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><button type="button" id="<?= $sub_service->id ?>" class="act_btn add_btn left" data-subservice-id="<?= $sub_service->id ?>" data-name="<?= $sub_service->name ?>"></button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="WashIron" class="tab-pane fade">
                                    <h4><?= $wash_and_iron->name ?></h4>
                                    <p><?= $wash_and_iron->details ?></p>
                                    <hr>
                                    <div class="serve_blk">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $wash_and_iron->image, ''); ?>" alt=""></div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Items</th>
                                                    <th width="40" class="text-center">Action</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($wash_and_iron->id) as $key => $sub_service) :
                                                ?>
                                                    <tr id="<?= $sub_service->id ?>">
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><button type="button" id="<?= $sub_service->id ?>" class="act_btn add_btn left" data-subservice-id="<?= $sub_service->id ?>" data-name="<?= $sub_service->name ?>"></button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="IronOnly" class="tab-pane fade">
                                    <h4><?= $iron_only->name ?></h4>
                                    <p><?= $iron_only->details ?></p>
                                    <hr>
                                    <div class="serve_blk">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $iron_only->image, ''); ?>" alt=""></div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Items</th>
                                                    <th width="40" class="text-center">Action</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($iron_only->id) as $key => $sub_service) :
                                                ?>
                                                    <tr id="<?= $sub_service->id ?>">
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><button type="button" id="<?= $sub_service->id ?>" class="act_btn add_btn left" data-subservice-id="<?= $sub_service->id ?>" data-name="<?= $sub_service->name ?>"></button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="BulkyItems" class="tab-pane fade">
                                    <h4><?= $buly_items->name ?></h4>
                                    <p><?= $buly_items->details ?></p>
                                    <hr>
                                    <div class="serve_blk">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $buly_items->image, ''); ?>" alt=""></div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Items</th>
                                                    <th width="40" class="text-center">Action</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($buly_items->id) as $key => $sub_service) :
                                                ?>
                                                    <tr id="<?= $sub_service->id ?>">
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><button type="button" id="<?= $sub_service->id ?>" class="act_btn add_btn left" data-subservice-id="<?= $sub_service->id ?>" data-name="<?= $sub_service->name ?>"></button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="Deals" class="tab-pane fade hidden">
                                    <h4><?= $deals->name ?></h4>
                                    <p><?= $deals->details ?></p>
                                    <hr>
                                    <div class="serve_blk">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $deals->image, ''); ?>" alt=""></div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Items</th>
                                                    <th width="40" class="text-center">Action</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($deals->id) as $key => $sub_service) :
                                                ?>
                                                    <tr id="<?= $sub_service->id ?>">
                                                        <td>
                                                            <?= $sub_service->name ?>
                                                            <p class="small">Sapiente nemo aliquid aliquam eveniet blanditiis rem, unde expedita quibusdam veritatis sint, animi hic totam aut.</p>
                                                        </td>
                                                        <td class="text-center"><button type="button" id="<?= $sub_service->id ?>" class="act_btn add_btn left" data-subservice-id="<?= $sub_service->id ?>" data-name="<?= $sub_service->name ?>"></button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="blk find_blk">
                                <div class="icon"><img src="<?= base_url('assets/images/vector-support.svg') ?>" alt=""></div>
                                <div class="txt">
                                    <h4>Can't find your item?</h4>
                                    <p>Our team will happily help you.</p>
                                </div>
                                <div class="btn_blk">
                                    <a target="_blank" href="<?= base_url('contact') ?>" class="site_btn light">Contact us</a>
                                </div>
                            </div>
                        </div>
                        <div class="col col3">
                            <div class="estimate_blk blk scrollbar">
                                <div class="top_head">
                                    <h5 class="heading">Basket Summary</h5>
                                    <div class="btn_blk hidden">
                                        <button type="reset" class="site_btn text">Reset</button>
                                    </div>
                                    <button type="button" class="cross_btn"></button>
                                </div>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe reiciendis quas libero totam illo hic.</p>
                                <div class="serve_blk">
                                    <table>
                                        <tbody id="selected_services">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="btn_blk form_btn form_blk">
                                    <button type="submit" class="site_btn md block next_btn"><i class="spinner hidden"></i>Get Quotes</button>
                                </div>
                                <div class="alertMsg" style="display:none"></div>
                                <p class="small">Please note that the final price may vary and it will be calculated after the cleaning process.</p>
                            </div>
                        </div>
                    </div>
                    <div id="estimate_btn_blk" class="btn_blk">
                        <button type="button" id="estimate_btn" class="site_btn block">View Basket Summary</button>
                    </div>
                </form>
            </div>
        </section>
        <!-- offer -->


        <script type="text/javascript">
            $(window).on("load", function() {
                $(document).on("click", ".act_btn", function() {
                    let selectedArea = $('#selected_services');
                    $('.alertMsg').hide();
                    if ($(this).hasClass("add_btn")) {
                        if ($(this).hasClass('left')) {
                            selectedArea.prepend(`<tr data-id="${$(this).data('subservice-id')}">
                            <td>
                                ${$(this).data('name')}
                                <button type="button" class="act_btn del_btn right" data-subservice-id="${$(this).data('subservice-id')}"></button>
                            </td>
                            <input type="hidden" name="selected_service[]" value="${$(this).data('subservice-id')}">
                            <td width="40">
                                <div class="qty_btn">
                                    <a class="qty_minus"></a>
                                    <input type="text" name="qty[]" value="1" class="qty" readonly>
                                    <a class="qty_plus"></a>
                                </div>
                            </td>
                        </tr>`);
                        }
                        $(this).removeClass("add_btn").addClass("del_btn");
                    } else {
                        if ($(this).hasClass('right')) {
                            $("td button").filter("[data-subservice-id='" + $(this).data('subservice-id') + "']").removeClass('del_btn').addClass('add_btn');
                            $(this).parent().parent().remove();
                        } else {
                            $("tr").filter("[data-id='" + $(this).data('subservice-id') + "']").remove();
                            $(this).removeClass("del_btn").addClass("add_btn");
                        }
                    }
                });
                // This button will increment the value
                $(document).on("click", ".qty_plus", function(e) {
                    e.preventDefault();
                    $('.servicesMessage').fadeOut();
                    var parent = $(this).parent().children(".qty");
                    var currentVal = parent.val();
                    if (!isNaN(currentVal)) {
                        let incrementedVal = parseInt(currentVal) + 1;
                        parent.val(incrementedVal);
                    } else {
                        parent.val(1);
                    }
                });
                // This button will decrement the value till 0
                $(document).on("click", ".qty_minus", function(e) {
                    e.preventDefault();
                    $('.servicesMessage').fadeOut();
                    var parent = $(this).parent().children(".qty");
                    var currentVal = parent.val();
                    if (!isNaN(currentVal) && currentVal > 1) {
                        let decrementedVal = parseInt(currentVal) - 1;
                        parent.val(decrementedVal);
                    } else {
                        parent.val(1);
                    }
                });
                $(document).on("click", "#estimate_btn", function() {
                    $(".estimate_blk").addClass("active");
                });
                $(document).on("click", ".estimate_blk .cross_btn", function() {
                    $(".estimate_blk").removeClass("active");
                });
            });
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>