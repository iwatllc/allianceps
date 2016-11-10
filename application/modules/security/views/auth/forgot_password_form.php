<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$login = array(
    'name'	=> 'login',
    'id'	=> 'login',
    'placeholder' => 'Username or Email',
    'class' => 'form-control',
    'maxlength'	=> 80,
    'size'	=> 30,
    'value' => set_value('login')
);

$reset = array(
    'name'  => 'reset',
    'id'    => 'reset',
    'value' => 'Reset Now',
    'class' => 'btn btn-sm btn-success'
);

?>

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

    <?php
    $css = new Asset_css('login');
    $css->add_asset($this->config->item('base_preprocess'));
    ?>

    <link type="text/css" rel="stylesheet" href="<?php echo Modules::run('kmassets/asset_create/index', $css); ?>" media="all" />


    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->

    <?php echo form_open($this->uri->uri_string())?>
    <?php echo $this->dx_auth->get_auth_error(); ?>

</head>

<body class="pace-top">

<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <div class="login bg-black animated fadeInDown">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <img src="<?php echo base_url(); ?><?php  echo $page_data['logo']; ?>"  height="50" alt="<?php  echo $page_data['title']; ?>" ></a>
                <br>
                <small><?php echo $page_data['slogan']; ?></small>
            </div>

        </div>
        <!-- end brand -->
        <div class="login-content">
            <form action="index.html" method="POST" class="margin-bottom-0">
                <div class="form-group m-b-20">
                    <?php echo form_input($login); ?>
                    <?php echo form_error($login['name']); ?>
                </div>
                <div class="login-buttons">
                    <?php echo form_submit($reset); ?>
                </div>
            </form>
        </div>
    </div>
    <!-- end login -->

    <?php echo form_close()?>

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