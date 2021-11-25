<!DOCTYPE html>
<html lang="en">

<head>
    <title>Price List — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="pricing">
            <div class="contain">
                <form action="" method="post" id="vendorPriceList" class="frmAjax">
                    <div class="alertMsg" style="display:none"></div>
                    <div class="flex_row">
                        <div class="col col1">
                            <ul class="svc_lst">
                                <li class="active">
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $wash_and_dry->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $wash_and_dry->name ?></strong>
                                        </div>
                                        <a data-toggle="tab" href="#WashDry"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $wash_and_iron->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $wash_and_iron->name ?></strong>
                                        </div>
                                        <a data-toggle="tab" href="#WashIron"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $dry_cleaning->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $dry_cleaning->name ?></strong>
                                        </div>
                                        <a data-toggle="tab" href="#DryCleaning"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $iron_only->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $iron_only->name ?></strong>
                                        </div>
                                        <a data-toggle="tab" href="#IronOnly"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $buly_items->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $buly_items->name ?></strong>
                                        </div>
                                        <a data-toggle="tab" href="#BulkyItems"></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $deals->image, ''); ?>" alt=""></div>
                                        <div class="txt">
                                            <strong><?= $deals->name ?></strong>
                                        </div>
                                        <a data-toggle="tab" href="#Deals"></a>
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
                                                    <th>Item</th>
                                                    <th width="40" class="text-center">Price</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($wash_and_dry->id) as $key => $sub_service) :
                                                    $price = sub_service_price($sub_service->id, $this->session->mem_id);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="lblBtn">
                                                                <label for="washAndDry<?= $key ?>"><?= $sub_service->name ?></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" name="sub_service[<?= $sub_service->id ?>][price]" class="text_box" <?= count($price) > 0 ? 'value="' . $price->price . '"' : 'placeholder="0.00"' ?>>
                                                        </td>
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
                                                    <th>Item</th>
                                                    <th width="40" class="text-center">Price</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($dry_cleaning->id) as $key => $sub_service) :
                                                    $price = sub_service_price($sub_service->id, $this->session->mem_id);
                                                ?>
                                                    <tr>
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><input type="text" name="sub_service[<?= $sub_service->id ?>][price]" class="text_box" <?= count($price) > 0 ? 'value="' . $price->price . '"' : 'placeholder="0.00"' ?>></td>
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
                                                    <th>Item</th>
                                                    <th width="40" class="text-center">Price</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($wash_and_iron->id) as $key => $sub_service) :
                                                    $price = sub_service_price($sub_service->id, $this->session->mem_id);
                                                ?>
                                                    <tr>
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><input type="text" name="sub_service[<?= $sub_service->id ?>][price]" class="text_box" <?= count($price) > 0 ? 'value="' . $price->price . '"' : 'placeholder="0.00"' ?>></td>
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
                                                    <th>Item</th>
                                                    <th width="40" class="text-center">Price</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($iron_only->id) as $key => $sub_service) :
                                                    $price = sub_service_price($sub_service->id, $this->session->mem_id);
                                                ?>
                                                    <tr>
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><input type="text" name="sub_service[<?= $sub_service->id ?>][price]" class="text_box" <?= count($price) > 0 ? 'value="' . $price->price . '"' : 'placeholder="0.00"' ?>></td>
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
                                                    <th>Item</th>
                                                    <th width="40" class="text-center">Price</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($buly_items->id) as $key => $sub_service) :
                                                    $price = sub_service_price($sub_service->id, $this->session->mem_id);
                                                ?>
                                                    <tr>
                                                        <td><?= $sub_service->name ?></td>
                                                        <td class="text-center"><input type="text" name="sub_service[<?= $sub_service->id ?>][price]" class="text_box" <?= count($price) > 0 ? 'value="' . $price->price . '"' : 'placeholder="0.00"' ?>></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="Deals" class="tab-pane fade">
                                    <h4><?= $deals->name ?></h4>
                                    <p><?= $deals->details ?></p>
                                    <hr>
                                    <div class="serve_blk">
                                        <div class="icon"><img src="<?= get_site_image_src("services", $deals->image, ''); ?>" alt=""></div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th>Deal</th>
                                                    <th width="40" class="text-center">Price</th>
                                                </tr>
                                                <?php
                                                foreach (get_sub_services($deals->id) as $key => $sub_service) :
                                                    $price = sub_service_price($sub_service->id, $this->session->mem_id);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?= $sub_service->name ?>
                                                            <p class="small">Sapiente nemo aliquid aliquam eveniet blanditiis rem, unde expedita quibusdam veritatis sint, animi hic totam aut.</p>
                                                        </td>
                                                        <td class="text-center"><input type="text" name="sub_service[<?= $sub_service->id ?>][price]" class="text_box" <?= count($price) > 0 ? 'value="' . $price->price . '"' : 'placeholder="0.00"' ?>></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="submit" class="site_btn long"><i class="spinner hidden"></i>Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- pricing -->


    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>