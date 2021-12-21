<div class="row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/orders') ?>">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $completed_orders?>" data-postfix="" data-duration="1500" data-delay="0"><?= $completed_orders?></div>
                <h3>Total Completed Orders </h3>
                <p>Total completed orders in our website </p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/orders') ?>">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $inprogress_orders?>" data-postfix="" data-duration="1500" data-delay="0"><?= $inprogress_orders?></div>
                <h3>Total Orders In Progress</h3>
                <p>Total orders in progress in our website </p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/individuals') ?>">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $total_buyers?>" data-postfix="" data-duration="1500" data-delay="0"><?= $total_buyers?></div>
                <h3>Total Earnings</h3>
                <p>Total Earnings in our website </p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/settings') ?>">
            <div class="tile-stats tile-black">
                <div class="icon"><i class="fa fa-cogs"></i></div>
                <div class="num" data-start="0" data-end="<?= $total_buyers?>" data-postfix="" data-duration="1500" data-delay="0"><?= $total_buyers?></div>
                <h3>Total Upcoming Earnings</h3>
                <p>Total upcoming earnings in our website.</p>
            </div>
        </a>		
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/invoices') ?>">
            <div class="tile-stats tile-black">
                <div class="icon"><i class="fa fa-cogs"></i></div>
                <div class="num" data-start="0" data-end="<?= $total_transactions?>" data-postfix="" data-duration="1500" data-delay="0"><?= $total_transactions?></div>
                <h3>Total Transactions</h3>
                <p>Total transactions in our website.</p>
            </div>
        </a>		
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/withdraws') ?>">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $total_payouts?>" data-postfix="" data-duration="1500" data-delay="0"><?= $total_payouts?></div>
                <h3>Total Payouts</h3>
                <p>Total payouts in our website </p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/withdraws') ?>">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $payouts_amount?>" data-prefix="£" data-postfix="" data-duration="1500" data-delay="0"><?= $payouts_amount?></div>
                <h3>Total Payouts Amount</h3>
                <p>Total payouts amount in our website </p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/contact') ?>">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $total_contact_msgs?>" data-postfix="" data-duration="1500" data-delay="0"><?= $total_contact_msgs?></div>
                <h3>Total Contact Messages </h3>
                <p>Total Contact Messages in our website </p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/vendors') ?>">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $total_vendors?>" data-postfix="" data-duration="1500" data-delay="0"><?= $total_vendors?></div>
                <h3>Total Vendors </h3>
                <p>Total Registered Vendors in our website </p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/individuals') ?>">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $total_buyers?>" data-postfix="" data-duration="1500" data-delay="0"><?= $total_buyers?></div>
                <h3>Total Buyers </h3>
                <p>Total Registered Individuals in our website </p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/settings') ?>">
            <div class="tile-stats tile-black">
                <div class="icon"><i class="fa fa-cogs"></i></div>
                <div class="num" data-start="0" data-end="0" data-postfix="" data-duration="1500" data-delay="1800"> Settings</div>

                <h3>Change Settings</h3>
                <p>on our site right now.</p>
            </div>
        </a>		
    </div>
</div>
