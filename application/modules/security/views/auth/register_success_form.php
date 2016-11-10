<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo $page_data['title']; ?> | <?php echo $page_data['page_title']; ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="<?php echo base_url(); ?>assets/css/google-api-fonts.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/style.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->

    <?php echo form_open($this->uri->uri_string())?>
</head>

<body class="pace-top">
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin brand -->
    <div class="login bg-black animated fadeInDown">
        <!-- begin news-feed -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> EZOLP
                <small>Registration Successful</small>
            </div>
            <div class="icon">
                <i class="fa fa-sign-in"></i>
            </div>
        </div>
        <!-- end brand -->
        <!-- begin register-content -->
        <div class="login-content">
            <p>You have registered successfully.</p>
            <p>Please <a href="<?php echo base_url() ?>">Login</a> using your credentials.</p>
        </div>
        <!-- end register-content -->
    </div>
    <!-- end register -->

    <?php echo form_close()?>

</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="assets/crossbrowserjs/html5shiv.js"></script>
<script src="assets/crossbrowserjs/respond.min.js"></script>
<script src="assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url(); ?>assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
</body>
</html>