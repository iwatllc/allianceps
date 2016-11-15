<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Alliance Payment Solutions</title>
    <link rel="icon" href="{{ base_url('/client/logo-small.png') }}">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="{{ $page_data['description'] }}" name="description" />
	<meta content="{{ $page_data['author'] }}" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="{{ base_url() }}assets/css/google-api-fonts.css" rel="stylesheet">
	<link href="{{ base_url() }}assets/one-page-parallax/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="{{ base_url() }}assets/one-page-parallax/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="{{ base_url() }}assets/one-page-parallax/assets/css/animate.min.css" rel="stylesheet" />
	<link href="{{ base_url() }}assets/one-page-parallax/assets/css/style.min.css" rel="stylesheet" />
	<link href="{{ base_url() }}assets/one-page-parallax/assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="{{ base_url() }}assets/one-page-parallax/assets/css/theme/default.css" id="theme" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ base_url() }}assets/one-page-parallax/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->

    <style type="text/css">
        .widthSet {
            max-width: 112px;
        }
        .heightSet {
            max-height: 30px;
        }
        .largeWidthSet {
            max-width: 364px;
        }
        .largeHeightSet {
            max-height: 95px;
        }
    </style>
</head>
<body data-spy="scroll" data-target="#header-navbar" data-offset="51">
    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-default navbar-fixed-top">
            <!-- begin container -->
            <div class="container">
                <!-- begin navbar-header -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="https://allianceps.com/" class="navbar-brand">
                        <img src="{{ base_url('client/logo.png') }}" class="heightSet widthSet">
                        <!--<span class="brand-logo"></span>
                        <span class="brand-text">
                            <span class="text-theme">Color</span> Admin
                        </span>-->
                    </a>
                </div>
                <!-- end navbar-header -->
                <!-- begin navbar-collapse -->
                <div class="collapse navbar-collapse" id="header-navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li class="active dropdown">
                            <a href="#home" data-click="scroll-to-target" data-target="#" data-toggle="dropdown">HOME <b class="caret"></b></a>
                            <ul class="dropdown-menu dropdown-menu-left animated fadeInDown">
                                <li><a href="index.html">Page with Transparent Header</a></li>
                                <li><a href="index_inverse_header.html">Page with Inverse Header</a></li>
                                <li><a href="index_default_header.html">Page with White Header</a></li>
                                <li><a href="extra_element.html">Extra Element</a></li>
                            </ul>
                        </li>
                        <li><a href="#about" data-click="scroll-to-target">ABOUT</a></li>
                        <li><a href="#team" data-click="scroll-to-target">TEAM</a></li>
                        <li><a href="#service" data-click="scroll-to-target">SERVICES</a></li>
                        <li><a href="#work" data-click="scroll-to-target">WORK</a></li>
                        <li><a href="#client" data-click="scroll-to-target">CLIENT</a></li>
                        <li><a href="#pricing" data-click="scroll-to-target">PRICING</a></li>-->
                        <li><a href="https://allianceps.com/">HOME</a></li>
                    </ul>
                </div>
                <!-- end navbar-collapse -->
            </div>
            <!-- end container -->
        </div>
        <!-- end #header -->
        
        <!-- begin #home -->
        <div id="home" class="content home">
            <!-- begin content-bg -->
            <div class="content-bg">
                <img src="{{ base_url('assets/one-page-parallax/assets/img/hm_banner2.jpg') }}" alt="Home"  height="700"/>
            </div>
            <!-- end content-bg -->
            <!-- begin container -->
            <div class="container home-content">
                <img src="{{ base_url('client/logo-inverse.png') }}" class="largeHeightSet largeWidthSet">
                <br/><br/>
                <!--<h1>Payment Processing Solutions</h1>-->
                <h3>Increase Your Productivity</h3>
                <p style="color:white;">
                    Customized solutions specifically designed to help your business streamline their receivables, reduce float time, improve cash flow, and more! <br/>
                    Access your account through our custom back-end portal secured by Thwarte ® encryption technology.
                </p>
            </div>
            <!-- end container -->
        </div>
        <!-- end #home -->
        
        <!-- begin #footer -->
        <div id="footer" class="footer">
            <div class="container">
                <div class="footer-brand">
                    <img src="{{ base_url('client/logo-small.png') }}" class="heightSet widthSet">
                    <br/>
                    <!--<div class="footer-brand-logo"></div>-->
                    Alliance Payment Solutions
                </div>
                <p>
                    &copy; Copyright 2016 <br />
                    <!--Site developed by <a target="_blank" href="http://www.iwatllc.com/">iWAT LLC</a>-->
                </p>
                <!--<p class="social-list">
                    <a href="#"><i class="fa fa-facebook fa-fw"></i></a>
                    <a href="#"><i class="fa fa-instagram fa-fw"></i></a>
                    <a href="#"><i class="fa fa-twitter fa-fw"></i></a>
                    <a href="#"><i class="fa fa-google-plus fa-fw"></i></a>
                    <a href="#"><i class="fa fa-dribbble fa-fw"></i></a>
                </p>-->
            </div>
        </div>
        <!-- end #footer -->
    </div>
    <!-- end #page-container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ base_url() }}assets/one-page-parallax/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="{{ base_url() }}assets/one-page-parallax/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="{{ base_url() }}assets/one-page-parallax/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="{{ base_url() }}assets/one-page-parallax/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="{{ base_url() }}assets/one-page-parallax/assets/crossbrowserjs/respond.min.js"></script>
		<script src="{{ base_url() }}assets/one-page-parallax/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="{{ base_url() }}assets/one-page-parallax/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="{{ base_url() }}assets/one-page-parallax/assets/plugins/scrollMonitor/scrollMonitor.js"></script>
	<script src="{{ base_url() }}assets/one-page-parallax/assets/js/apps.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<script>    
	    $(document).ready(function() {
	        App.init();
	    });
	</script>
</body>
</html>
