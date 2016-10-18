<meta charset="utf-8" />
<title>{{ $this->config->item('Company_Title') }}</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content={{ $this->config->item('Company_Description') }} name="description" />
<meta content={{ $this->config->item('Company_Author') }} name="author" />
<link rel="icon" href="{{ base_url('/client/logo-small.png') }}">

<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="{{ base_url() }}assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/css/animate.min.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/css/style.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/css/style-responsive.min.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/css/theme/default.css" rel="stylesheet" id="theme" />
<link href="{{ base_url() }}assets/css/ezolp_print.css" rel="stylesheet" id="stylesheettheme" media="print" />
<!-- ================== END BASE CSS STYLE ================== -->

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="{{ base_url() }}assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/ionRangeSlider/css/ion.rangeSlider.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<link href="{{ base_url() }}assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- Overrides -->
@if (isset($asset) && ! empty($asset))
    <link type="text/css" rel="stylesheet" href="{{ Modules::run('kmassets/asset_create/index', $asset) }}" media="all" />
@endif

<!-- ================== BEGIN BASE JS ================== -->
<script src="{{ base_url() }}assets/plugins/pace/pace.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
        <!-- begin container-fluid -->
        <div class="container-fluid">
            <!-- begin mobile sidebar expand / collapse button -->
            <div class="navbar-header">
                <a href="{{ base_url('dashboard') }}" class="navbar-brand"><img src="{{ base_url() }}{{ $this->config->item('Company_Logo') }}"  height="40" alt="{{ $this->config->item('Company_Title') }}" ></a>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- end mobile sidebar expand / collapse button -->

            <!-- begin header navigation right -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- Insert an image for the user here -->
                        <span class="hidden-xs">{{ $this->session->userdata('DX_username') }}</span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <li><a href="{{ base_url() }}security/auth/change_password">Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ base_url() }}security/auth/logout">Log Out</a></li>
                    </ul>
                </li>
            </ul>
            <!-- end header navigation right -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <div id="sidebar" class="sidebar">
        <!-- begin sidebar scrollbar -->
        <div data-scrollbar="true" data-height="100%">
            <!-- begin sidebar user -->
            <!-- end sidebar user -->
            <!-- begin sidebar nav -->
            <ul class="nav">

                <li class="has-sub{{ $this->uri->segment(1) == 'dashboard' ? ' active' : '' }}">
                    <a href="{{ base_url() }}dashboard">
                        <i class="fa fa-laptop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="has-sub{{ $this->uri->segment(1) == 'search' ? ' active' : '' }}">
                    <a href="{{ base_url() }}search">
                        <i class="fa fa-search"></i>
                        <span>Search</span>
                    </a>
                </li>

                <li class="has-sub{{ $this->uri->segment(1) == 'customer' ? ' active' : '' }}">
                    <a href="{{ base_url() }}customer">
                        <i class="fa fa-user"></i>
                        <span>Customers</span>
                    </a>
                </li>

                <li class="has-sub{{ $this->uri->segment(1) == 'export' ? ' active' : '' }}">
                    <a href="{{ base_url() }}export">
                        <i class="fa fa-file-text"></i>
                        <span>Export Transactions</span>
                    </a>
                </li>
                
                <li class="has-sub{{ $this->uri->segment(1) == 'security' ? ' active' : '' }}">
                    <a>
                        <b class="caret pull-right"></b>
                        <i class="fa fa-key"></i>
                        <span>Security</span>
                    </a>
                    <ul class="sub-menu">
                        <li{{ $this->uri->segment(3) == 'users' ? ' class="active"' : '' }}><a href="{{ base_url() }}security/backend/users">Manage Users</a></li>
                        <li{{ $this->uri->segment(3) == 'unactivated_users' ? ' class="active"' : '' }}><a href="{{ base_url() }}security/backend/unactivated_users">Manage Unactivated Users</a></li>
                        <li{{ $this->uri->segment(3) == 'roles' ? ' class="active"' : '' }}><a href="{{ base_url() }}security/backend/roles">Manage Roles</a></li>
                        <li{{ $this->uri->segment(3) == 'uri_permissions' ? ' class="active"' : '' }}><a href="{{ base_url() }}security/backend/uri_permissions">URI Permissions</a></li>
                        <li{{ $this->uri->segment(3) == 'custom_permissions' ? ' class="active"' : '' }}><a href="{{ base_url() }}security/backend/custom_permissions">Custom Permissions</a></li>
                        <li{{ $this->uri->segment(3) == 'add_user' ? ' class="active"' : '' }}><a href="{{ base_url() }}security/backend/add_user">Add User</a></li>
                    </ul>
                </li>

                <li class="has-sub">
                    <a href="{{ base_url() }}security/auth/logout">
                        <i class="fa fa-power-off"></i>
                        <span>Log Out</span>
                    </a>
                </li>

                <!-- begin sidebar minify button -->
                <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                <!-- end sidebar minify button -->
            </ul>
            <!-- end sidebar nav -->
        </div>
        <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>
    <!-- end #sidebar -->