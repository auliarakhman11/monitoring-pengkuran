<div id="left-sidebar" class="sidebar">
    <button type="button" class="btn-toggle-offcanvas"><i class="fa fa-arrow-left"></i></button>
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="{{ asset('img') }}/Logo_BPN-KemenATR.png" class="rounded-circle user-photo"
                alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <strong>{{ session()->get('name') ? session()->get('name') : '' }}</strong>
                {{-- <a href="javascript:void(0);" class="dropdown-toggle user-name"
                    data-toggle="dropdown"></a> --}}
                {{-- <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="page-profile2.html"><i class="icon-user"></i>My Profile</a></li>
                    <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="page-login.html"><i class="icon-power"></i>Logout</a></li>
                </ul> --}}
            </div>
            <hr>
            {{-- <ul class="row list-unstyled">
                <li class="col-4">
                    <small>Sales</small>
                    <h6>561</h6>
                </li>
                <li class="col-4">
                    <small>Order</small>
                    <h6>920</h6>
                </li>
                <li class="col-4">
                    <small>Revenue</small>
                    <h6>$23B</h6>
                </li>
            </ul> --}}
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
            {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Chat"><i class="icon-book-open"></i></a>
            </li> --}}
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i>
                    Setting</a>
            </li>
            {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#question"><i
                        class="icon-question"></i></a></li> --}}
        </ul>

        <!-- Tab panes -->
        <div class="tab-content padding-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu li_animation_delay">
                        <li class="{{ Request::is(['/']) ? 'active' : '' }}">
                            <a href="javascript:void(0)" class="has-arrow"><i
                                    class="fa fa-dashboard"></i><span>Dashboard</span></a>
                            <ul>
                                <li class="{{ Request::is('/') ? 'active' : '' }}"><a
                                        href="{{ route('home') }}">Home</a></li>
                            </ul>
                        </li>

                        <li class="{{ Request::is(['loket', 'penjadwalan']) ? 'active' : '' }}">
                            <a href="javascript:void(0)" class="has-arrow"><i
                                    class="fa fa-address-card"></i><span>Berkas</span></a>
                            <ul>
                                <li class="{{ Request::is('loket') ? 'active' : '' }}"><a
                                        href="{{ route('loket') }}">Input Berkas</a></li>
                                <li class="{{ Request::is('penjadwalan') ? 'active' : '' }}"><a
                                        href="{{ route('penjadwalan') }}">Penjadwalan</a></li>
                            </ul>
                        </li>

                        <li class="{{ Request::is(['user']) ? 'active' : '' }}">
                            <a href="javascript:void(0)" class="has-arrow"><i
                                    class="fa fa-users"></i><span>Users</span></a>
                            <ul>
                                <li class="{{ Request::is('user') ? 'active' : '' }}"><a
                                        href="{{ route('user') }}">Manajemen User</a></li>
                            </ul>
                        </li>


                        {{-- <li>
                            <a href="#App" class="has-arrow"><i class="fa fa-th-large"></i><span>Ready
                                    App</span></a>
                            <ul>
                                <li><a href="app-inbox.html">Inbox</a></li>
                                <li><a href="app-chat.html">Chat</a></li>
                                <li><a href="app-calendar.html">Calendar</a></li>
                                <li><a href="app-contact.html">Contact list</a></li>
                                <li><a href="app-contact-grid.html">Contact Card <span
                                            class="badge badge-warning float-right">New</span></a></li>
                                <li><a href="app-taskboard.html">Taskboard</a></li>
                                <li><a href="javascript:void(0);"><span>Blog</span></a>
                                    <ul>
                                        <li><a href="blog-dashboard.html">Dashboard</a></li>
                                        <li><a href="blog-post.html">New Post</a></li>
                                        <li><a href="blog-list.html">Blog List</a></li>
                                        <li><a href="blog-details.html">Blog Detail</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0);"><span>File Manager</span></a>
                                    <ul>
                                        <li><a href="file-dashboard.html">Dashboard</a></li>
                                        <li><a href="file-documents.html">Documents</a></li>
                                        <li><a href="file-media.html">Media</a></li>
                                        <li><a href="file-images.html">Images</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Widgets" class="has-arrow"><i
                                    class="fa fa-puzzle-piece"></i><span>Widgets</span></a>
                            <ul>
                                <li><a href="widgets-statistics.html">Statistics</a></li>
                                <li><a href="widgets-data.html">Data</a></li>
                                <li><a href="widgets-chart.html">Chart</a></li>
                                <li><a href="widgets-weather.html">Weather</a></li>
                                <li><a href="widgets-social.html">Social</a></li>
                                <li><a href="widgets-blog.html">Blog</a></li>
                                <li><a href="widgets-ecommerce.html">eCommerce</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#uiElements" class="has-arrow"><i class="fa fa-diamond"></i><span>UI
                                    Elements</span></a>
                            <ul>
                                <li><a href="ui-typography.html">Typography</a></li>
                                <li><a href="ui-tabs.html">Tabs</a></li>
                                <li><a href="ui-buttons.html">Buttons</a></li>
                                <li><a href="ui-bootstrap.html">Bootstrap UI</a></li>
                                <li><a href="ui-icons.html">Icons</a></li>
                                <li><a href="ui-notifications.html">Notifications</a></li>
                                <li><a href="ui-colors.html">Colors</a></li>
                                <li><a href="ui-dialogs.html">Dialogs</a></li>
                                <li><a href="ui-list-group.html">List Group</a></li>
                                <li><a href="ui-media-object.html">Media Object</a></li>
                                <li><a href="ui-modals.html">Modals</a></li>
                                <li><a href="ui-nestable.html">Nestable</a></li>
                                <li><a href="ui-progressbars.html">Progress Bars</a></li>
                                <li><a href="ui-range-sliders.html">Range Sliders</a></li>
                                <li><a href="ui-treeview.html">Treeview</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#charts" class="has-arrow"><i class="fa fa-area-chart"></i><span>Charts</span></a>
                            <ul>
                                <li><a href="chart-apex.html">Apex</a> </li>
                                <li><a href="chart-c3.html">C3 Charts</a></li>
                                <li><a href="chart-morris.html">Morris</a> </li>
                                <li><a href="chart-flot.html">Flot</a> </li>
                                <li><a href="chart-chartjs.html">ChartJS</a> </li>
                                <li><a href="chart-jquery-knob.html">Jquery Knob</a> </li>
                                <li><a href="chart-sparkline.html">Sparkline Chart</a></li>
                                <li><a href="chart-peity.html">Peity</a></li>
                                <li><a href="chart-gauges.html">Gauges</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#forms" class="has-arrow"><i class="fa fa-pencil"></i><span>Forms</span></a>
                            <ul>
                                <li><a href="forms-validation.html">Form Validation</a></li>
                                <li><a href="forms-advanced.html">Advanced Elements</a></li>
                                <li><a href="forms-basic.html">Basic Elements</a></li>
                                <li><a href="forms-wizard.html">Form Wizard</a></li>
                                <li><a href="forms-dragdropupload.html">Drag &amp; Drop Upload</a></li>
                                <li><a href="forms-cropping.html">Image Cropping</a></li>
                                <li><a href="forms-summernote.html">Summernote</a></li>
                                <li><a href="forms-editors.html">CKEditor</a></li>
                                <li><a href="forms-markdown.html">Markdown</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Tables" class="has-arrow"><i class="fa fa-table"></i><span>Tables</span></a>
                            <ul>
                                <li><a href="table-basic.html">Tables Example<span
                                            class="badge badge-info float-right">New</span></a> </li>
                                <li><a href="table-normal.html">Normal Tables</a> </li>
                                <li><a href="table-jquery-datatable.html">Jquery Datatables</a> </li>
                                <li><a href="table-editable.html">Editable Tables</a> </li>
                                <li><a href="table-color.html">Tables Color</a> </li>
                                <li><a href="table-filter.html">Table Filter <span
                                            class="badge badge-info float-right">New</span></a> </li>
                                <li><a href="table-dragger.html">Table dragger <span
                                            class="badge badge-info float-right">New</span></a> </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Authentication" class="has-arrow"><i
                                    class="fa fa-lock"></i><span>Authentication</span></a>
                            <ul>
                                <li><a href="page-login.html">Login</a></li>
                                <li><a href="page-register.html">Register</a></li>
                                <li><a href="page-lockscreen.html">Lockscreen</a></li>
                                <li><a href="page-forgot-password.html">Forgot Password</a></li>
                                <li><a href="page-404.html">Page 404</a></li>
                                <li><a href="page-403.html">Page 403</a></li>
                                <li><a href="page-500.html">Page 500</a></li>
                                <li><a href="page-503.html">Page 503</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Pages" class="has-arrow"><i class="fa fa-file"></i><span>Extra
                                    Pages</span></a>
                            <ul>
                                <li><a href="page-blank.html">Blank Page</a> </li>
                                <li><a href="page-profile.html">Profile <span
                                            class="badge badge-default float-right">v1</span></a></li>
                                <li><a href="page-profile2.html">Profile <span
                                            class="badge badge-warning float-right">v2</span></a></li>
                                <li><a href="page-gallery.html">Image Gallery <span
                                            class="badge badge-default float-right">v1</span></a> </li>
                                <li><a href="page-gallery2.html">Image Gallery <span
                                            class="badge badge-warning float-right">v2</span></a> </li>
                                <li><a href="page-timeline.html">Timeline</a></li>
                                <li><a href="page-timeline-h.html">Horizontal Timeline</a></li>
                                <li><a href="page-pricing.html">Pricing</a></li>
                                <li><a href="page-invoices.html">Invoices</a></li>
                                <li><a href="page-invoices2.html">Invoices <span
                                            class="badge badge-warning float-right">v2</span></a></li>
                                <li><a href="page-search-results.html">Search Results</a></li>
                                <li><a href="page-helper-class.html">Helper Classes</a></li>
                                <li><a href="page-teams-board.html">Teams Board</a></li>
                                <li><a href="page-projects-list.html">Projects List</a></li>
                                <li><a href="page-maintenance.html">Maintenance</a></li>
                                <li><a href="page-testimonials.html">Testimonials</a></li>
                                <li><a href="page-faq.html">FAQ</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Maps" class="has-arrow"><i class="fa fa-map"></i><span>Maps</span></a>
                            <ul>
                                <li><a href="map-google.html">Google Map</a></li>
                                <li><a href="map-yandex.html">Yandex Map</a></li>
                                <li><a href="map-jvectormap.html">jVector Map</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                </nav>
            </div>
            {{-- <div class="tab-pane" id="Chat">
                <form>
                    <div class="input-group m-b-20">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-magnifier"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </form>
                <ul class="right_chat list-unstyled li_animation_delay">
                    <li>
                        <a href="javascript:void(0);" class="media">
                            <img class="media-object" src="{{ asset('assets') }}/images/xs/avatar1.jpg"
                                alt="">
                            <div class="media-body">
                                <span class="name d-flex justify-content-between">Chris Fox <i
                                        class="fa fa-heart-o font-12"></i></span>
                                <span class="message">chrisfox@gmail.com</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="media">
                            <img class="media-object" src="{{ asset('assets') }}/images/xs/avatar2.jpg"
                                alt="">
                            <div class="media-body">
                                <span class="name d-flex justify-content-between">Joge Lucky <i
                                        class="fa fa-heart-o font-12"></i></span>
                                <span class="message">Jogelucky@gmail.com</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="media">
                            <img class="media-object" src="{{ asset('assets') }}/images/xs/avatar3.jpg"
                                alt="">
                            <div class="media-body">
                                <span class="name d-flex justify-content-between">Isabella <i
                                        class="fa fa-heart-o font-12"></i></span>
                                <span class="message">Isabella@gmail.com</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="media">
                            <img class="media-object" src="{{ asset('assets') }}/images/xs/avatar4.jpg"
                                alt="">
                            <div class="media-body">
                                <span class="name d-flex justify-content-between">Folisise Chosielie <i
                                        class="fa fa-heart font-12"></i></span>
                                <span class="message">FolisiseChosielie@gmail.com</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="media">
                            <img class="media-object" src="{{ asset('assets') }}/images/xs/avatar5.jpg"
                                alt="">
                            <div class="media-body">
                                <span class="name d-flex justify-content-between">Alexander <i
                                        class="fa fa-heart-o font-12"></i></span>
                                <span class="message">Alexander@gmail.com</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div> --}}
            <div class="tab-pane" id="setting">
                <h6>Choose Skin</h6>
                <ul class="choose-skin list-unstyled">
                    <li data-theme="purple">
                        <div class="purple"></div>
                    </li>
                    <li data-theme="blue">
                        <div class="blue"></div>
                    </li>
                    <li data-theme="cyan" class="active">
                        <div class="cyan"></div>
                    </li>
                    <li data-theme="green">
                        <div class="green"></div>
                    </li>
                    <li data-theme="orange">
                        <div class="orange"></div>
                    </li>
                    <li data-theme="blush">
                        <div class="blush"></div>
                    </li>
                    <li data-theme="red">
                        <div class="red"></div>
                    </li>
                </ul>

                <ul class="list-unstyled font_setting mt-3">
                    <li>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="font" value="font-nunito"
                                checked="">
                            <span class="custom-control-label">Nunito Google Font</span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="font" value="font-ubuntu">
                            <span class="custom-control-label">Ubuntu Font</span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="font" value="font-raleway">
                            <span class="custom-control-label">Raleway Google Font</span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="font" value="font-IBMplex">
                            <span class="custom-control-label">IBM Plex Google Font</span>
                        </label>
                    </li>
                </ul>

                <ul class="list-unstyled mt-3">
                    <li class="d-flex align-items-center mb-2">
                        <label class="toggle-switch theme-switch">
                            <input type="checkbox">
                            <span class="toggle-switch-slider"></span>
                        </label>
                        <span class="ml-3">Enable Dark Mode!</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <label class="toggle-switch theme-rtl">
                            <input type="checkbox">
                            <span class="toggle-switch-slider"></span>
                        </label>
                        <span class="ml-3">Enable RTL Mode!</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <label class="toggle-switch theme-high-contrast">
                            <input type="checkbox">
                            <span class="toggle-switch-slider"></span>
                        </label>
                        <span class="ml-3">Enable High Contrast Mode!</span>
                    </li>
                </ul>

                {{-- <hr>
                <h6>General Settings</h6>
                <ul class="setting-list list-unstyled">
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox" checked>
                            <span>Allowed Notifications</span>
                        </label>
                    </li>
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox">
                            <span>Offline</span>
                        </label>
                    </li>
                    <li>
                        <label class="fancy-checkbox">
                            <input type="checkbox" name="checkbox">
                            <span>Location Permission</span>
                        </label>
                    </li>
                </ul> --}}

                {{-- <a href="#" target="_blank" class="btn btn-block btn-primary">Buy this item</a>
                <a href="https://themeforest.net/user/wrraptheme/portfolio" target="_blank"
                    class="btn btn-block btn-secondary">View portfolio</a> --}}
            </div>
            {{-- <div class="tab-pane" id="question">
                <form>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-magnifier"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </form>
                <ul class="list-unstyled question">
                    <li class="menu-heading">HOW-TO</li>
                    <li><a href="javascript:void(0);">How to Create Campaign</a></li>
                    <li><a href="javascript:void(0);">Boost Your Sales</a></li>
                    <li><a href="javascript:void(0);">Website Analytics</a></li>
                    <li class="menu-heading">ACCOUNT</li>
                    <li><a href="javascript:void(0);">Cearet New Account</a></li>
                    <li><a href="javascript:void(0);">Change Password?</a></li>
                    <li><a href="javascript:void(0);">Privacy &amp; Policy</a></li>
                    <li class="menu-heading">BILLING</li>
                    <li><a href="javascript:void(0);">Payment info</a></li>
                    <li><a href="javascript:void(0);">Auto-Renewal</a></li>
                    <li class="menu-button mt-3">
                        <a href="../docs/index.html" class="btn btn-primary btn-block">Documentation</a>
                    </li>
                </ul>
            </div> --}}
        </div>
    </div>
</div>
