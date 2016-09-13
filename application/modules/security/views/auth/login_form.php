<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$username = array(
    'name'  => 'username',
    'id'    => 'username',
    'class' => 'form-control input-lg',
    'placeholder' => 'Username',
    'size'  => 30,
    'value' => set_value('username')
);

$password = array(
    'name'  => 'password',
    'id'    => 'password',
    'class' => 'form-control input-lg',
    'placeholder' => 'Password',
    'size'  => 30
);

$remember = array(
    'name'  => 'remember',
    'id'    => 'remember',
    'value' => 1,
    'checked'   => set_value('remember'),
    'style' => 'margin:0;padding:0'
);

$submit = array(
    'name' => 'submit',
    'id' => 'submit',
    'value' => 'Login',
    'class' => 'btn btn-success btn-block btn-lg'
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
    
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
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
    <?php // echo $this->dx_auth->get_auth_error(); ?>

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
                    <img src="<?php echo base_url(); ?><?php echo $page_data['logo']; ?>"  height="50" alt="<?php echo $page_data['title']; ?>" >
                    <br>
                    <small><?php echo $page_data['slogan']; ?></small>
                </div>

            </div>
            <!-- end brand -->

            <div class="login-content">

                <div class="form-group m-b-20">
                    <p class="text-danger"><?php echo $this->dx_auth->get_auth_error(); ?></p>
                </div>

                <form action="index.html" method="POST" class="margin-bottom-0">
                    <div class="form-group m-b-20">
                        <?php echo form_input($username)?>
                        <?php echo form_error($username['name']); ?>
                    </div>
                    <div class="form-group m-b-20">
                        <?php echo form_password($password)?>
                        <?php echo form_error($password['name']); ?>
                    </div>
                    <div class="form-group m-b-20">
                        <a href="<?php echo site_url('security/auth/forgot_password') ?>">Forgot your password?</a>
                    </div>
                    <div class="checkbox m-b-20">
                        <label>
                            <?php echo form_checkbox($remember);?>
                            <?php echo form_label('Remember me', $remember['id']);?>
                        </label>
                    </div>

                    <!-- begin captcha registration -->
                    <?php if ($this->dx_auth->captcha_registration && $this->dx_auth->is_max_login_attempts_exceeded()): ?>
                        <label class="control-label">Please enter the Captcha</label>
                        <div class="form-group m-b-20">
                            <?php if ($this->dx_auth->captcha_registration): ?>
                                <?php
                                    // Show recaptcha image
                                    echo $this->dx_auth->get_recaptcha_image();
                                    // Show reload captcha link
                                    echo $this->dx_auth->get_recaptcha_reload_link();
                                    // Show switch to image captcha or audio link
                                    echo $this->dx_auth->get_recaptcha_switch_image_audio_link();
                                ?>

                                <?php echo $this->dx_auth->get_recaptcha_label(); ?>

                                <?php echo $this->dx_auth->get_recaptcha_input(); ?>
                                <?php echo form_error('recaptcha_response_field'); ?>

                                <?php
                                    // Get recaptcha javascript and non javasript html
                                    echo $this->dx_auth->get_recaptcha_html();
                                ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <!-- end captcha registration -->

                    <div class="login-buttons">
                        <?php echo form_submit($submit);?>
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