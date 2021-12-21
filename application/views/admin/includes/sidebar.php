<div class="sidebar-menu fixed">
    <div class="sidebar-menu-inner ps-container ps-active-y">
        <header class="logo-env">
            <!-- logo -->
            <div class="logo">
                <a href="<?=site_url(ADMIN.'/dashboard')?>">
                    <img src="<?= base_url().SITE_IMAGES.'images/'.$adminsite_setting->site_logo ?>" width="120" alt="">
                </a>
            </div>
            <!-- logo collapse icon -->
            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                    <i class="entypo-menu"></i>
                </a>
            </div>
            <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
            <div class="sidebar-mobile-menu visible-xs">
                <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                    <i class="entypo-menu"></i>
                </a>
            </div>
        </header>
        <ul id="main-menu" class="main-menu">
            <li class="opened <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/dashboard') ?>">
                    <i class="entypo-gauge"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class=" <?= ($this->uri->segment(2) == 'vendors' || $this->uri->segment(2) == 'individuals') ? ' opened  active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-users"></i>
                    <span class="title">Manage Members</span>
                </a>
                <ul>
                    <li class=" <?= ($this->uri->segment(3) == 'vendors') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/vendors') ?>">
                        <i class="fa fa-user"></i>
                            <span class="title">Vendors</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'individuals') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/individuals') ?>">
                            <i class="fa fa-user"></i>
                            <span class="title">Individuals </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'orders') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/orders') ?>">
                    <i class="fa fa-file"></i>
                    <span class="title">Manage Orders</span>
                    <span class="badge badge-info"><?=new_orders()?></span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'invoices') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/invoices') ?>">
                    <i class="fa fa-file"></i>
                    <span class="title">Manage Invoices</span>
                </a>
            </li>
            <li class=" <?= ($this->uri->segment(2) == 'vendors' || $this->uri->segment(2) == 'individuals') ? ' opened  active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-users"></i>
                    <span class="title">Manage Withdraws</span>
                    <span class="badge badge-info"><?=new_withdraws_requests()?></span>
                </a>
                <ul>
                    <li class=" <?= ($this->uri->segment(3) == 'vendors') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/withdraws') ?>">
                        <i class="fa fa-user"></i>
                            <span class="title">Completed Withdraws</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'individuals') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/withdraws/requests') ?>">
                            <i class="fa fa-user"></i>
                            <span class="title">Withdraws Requests</span>
                            <span class="badge badge-info"><?=new_withdraws_requests()?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" <?= ($this->uri->segment(2) == 'pending-proof' || $this->uri->segment(2) == 'rejected-proof' || $this->uri->segment(2) == 'accepted-proof') ? ' opened  active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="entypo-doc-text  "></i>
                    <span class="title">Manage Delivery Proofs</span>
                    <span class="badge badge-info"><?=new_delivery_proofs()?></span>
                </a>
                <ul>
                    <li class=" <?= ($this->uri->segment(2) == 'pending-proof') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/pending-proof') ?>">
                        <i class="entypo-doc-text  "></i>
                            <span class="title">Pending Proof</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(2) == 'accepted-proof') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/accepted-proof') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Accepted Proof</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(2) == 'rejected-proof') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/rejected-proof') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Rejected Proof</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="opened<?= $this->uri->segment('2') == 'contact' ? ' active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/contact') ?>">
                    <i class="fa fa-comments"></i>
                    <span class="title">Manage Contacts</span><span class="badge badge-info"><?=new_messages()?></span>
                </a>
            </li>
            <li class=" <?= ($this->uri->segment(2) == 'services' || $this->uri->segment(2) == 'sub_services') ? ' opened  active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-pagelines  "></i>
                    <span class="title">Manage Services</span>
                </a>
                <ul>
                    <li class=" <?= ($this->uri->segment(3) == 'services') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/services') ?>">
                        <i class="fa fa-file"></i>
                            <span class="title">Services</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'sub_services') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sub_services') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Sub Services</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" <?= ($this->uri->segment(2) == 'sitecontent' || $this->uri->segment(2) == 'preferences') ? ' opened  active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-pagelines  "></i>
                    <span class="title">Manage Pages</span>
                </a>
                <ul>
                    <li class=" <?= ($this->uri->segment(3) == 'landing') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/landing') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Landing</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'home') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/home') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Home</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'signin') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/signin') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Sign In</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'signup') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/signup') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Sign Up</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'about_us') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/about_us') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">About Us</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'contact') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/contact') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Contact Us</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'about') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/promotions') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Promotions</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'faq') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/faq') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">FAQ's</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'service_selection') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/service_selection') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Service Selection</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'available_vendors') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/available_vendors') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Available Vendors</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'vendor_detail') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/vendor_detail') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Vendor Detail</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'booking') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/booking') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Booking</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'impact') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/impact') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Impact</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'terms_conditions') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/terms_conditions') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Terms & Conditions</span>
                        </a>
                    </li>
                    <li class=" <?= ($this->uri->segment(3) == 'privacy_policy') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN.'/sitecontent/privacy_policy') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Privacy Policy</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="opened<?= $this->uri->segment('2') == 'testimonials' ? ' active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/testimonials') ?>">
                    <i class="fa fa-comments"></i>
                    <span class="title">Manage Testimonials</span>
                </a>
            </li>
            <li class="opened<?= $this->uri->segment('2') == 'partners' ? ' active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/partners') ?>">
                    <i class="fa fa-comments"></i>
                    <span class="title">Manage Partners</span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'faq') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/faq') ?>">
                    <i class="fa fa-th-list"></i>
                    <span class="title">Manage FAQ's</span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'newsletter') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/newsletter') ?>">
                    <i class="fa fa-file"></i>
                    <span class="title">Newsletter</span><span class="badge badge-info"><?=new_subscribers()?></span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'promos') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/promos') ?>">
                    <i class="fa fa-file"></i>
                    <span class="title">Manage Promotions</span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'email_logs') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/email_logs') ?>">
                    <i class="fa fa-file"></i>
                    <span class="title">See Email Logs</span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'invoices') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/Blogs') ?>">
                    <i class="fa fa-file"></i>
                    <span class="title">Manage Blogs</span>
                </a>
            </li>

            <li class="opened <?= ($this->uri->segment('2') == 'meta-info') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/meta-info') ?>">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    <span class="title">Site Meta</span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'texts') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN) ?>/texts">
                    <i class="fa fa-cog"></i>
                    <span class="title">Manage Notifications</span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment(2) == 'settings' && $this->uri->segment(3) == '') ? 'active' : '' ?>">
                <a href="<?= site_url(ADMIN.'/settings') ?>">
                    <i class="fa fa-cogs"></i>
                    <span class="title">Site Settings</span>
                </a>
            </li>
            <li class="opened">
                <a href="<?= site_url(ADMIN.'/settings/change') ?>">
                    <i class="fa fa-lock"></i>
                    <span class="title">Change Password</span>
                </a>
            </li>
        </ul>
    </div>
</div>