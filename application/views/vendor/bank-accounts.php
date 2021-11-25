<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard — <?= $site_settings->site_name ?></title>
    <?php $this->load->view('includes/site-master'); ?>
</head>

<body data-page="dash">
    <?php $this->load->view('includes/header'); ?>
    <main>


        <section id="account">
            <div class="contain">
                <?php echo showMsg(); ?>
                <h4 class="subheading">Bank Account Detail</h4>
                <div class="blk">
                    <form action="" method="post" id="vendorBankAccount" class="vendorBankAccount">
                        <div class="inside">
                            <div class="alertMsg" style="display:none"></div>
                            <div id="form-bank-account">
                                <?= mem_bank_form() ?>
                            </div>
                            <div class="btn_blk form_btn text-center">
                                <button type="submit" class="site_btn long submit"><i class="spinner hidden"></i>Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="blk">
                    <div class="tbl_blk">
                        <table>
                            <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Account Number</th>
                                    <th>Short Code</th>
                                    <th>Beneficiary Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="bank-accounts-vendor">
                                <?= get_mem_banks($this->session->mem_id) ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- account -->


        <script>
            $(document).on("click", ".edit-bank-account", function(e) {
                e.preventDefault();
                let btn = $(this);
                let bank_id = btn.data('bank-id');
                $.ajax({
                    url: base_url + 'vendor/edit_bank_fetch',
                    data: {
                        'bank_id': bank_id
                    },
                    dataType: 'JSON',
                    method: 'POST',
                    success: function(rs) {
                        $('#form-bank-account').html(rs.html);
                    },
                    complete: function() {

                    }
                })
            });

            $(document).on("click", ".delete-bank-account", function(e) {
                e.preventDefault();
                let btn = $(this);
                let bank_id = btn.data('bank-id');
                $.ajax({
                    url: base_url + 'vendor/delete_bank_fetch',
                    data: {
                        'bank_id': bank_id
                    },
                    dataType: 'JSON',
                    method: 'POST',
                    success: function(rs) {
                        $('#form-bank-account').html(rs.html);
                    },
                    complete: function() {

                    }
                })
            });
        </script>
    </main>
    <?php $this->load->view('includes/footer'); ?>
</body>

</html>