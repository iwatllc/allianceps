<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('header'); ?>
<?php $this->load->view('navbar'); ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<head>
    <title><?php echo 'EZOLP | Change Password'; ?></title>
</head>

<body class = "flat-back">

<?php echo form_open($this->uri->uri_string()); ?>
<?php echo $this->dx_auth->get_auth_error(); ?>

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin page-header -->
<!--    <h1 class="page-header">--><?php //echo 'Change Password';?><!--</h1>-->
    <!-- end page-header -->

    <!-- begin col-12 -->
    <div class="col-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" >
            <div class="panel-heading">
                <h4 class="panel-title">Change Password</h4>
            </div>
            <div class="alert alert-success fade in">
                <span class="close" data-dismiss="alert">×</span>
                <i class="fa fa-check fa-2x pull-left"></i>
                <p>Your password has been changed successfully.</p>
            </div>
            <div class="panel-body">
                <p>Use this password the next time you login.</p>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- end #content -->

<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->

</div>
<!-- end page container -->

</body>

<?php $this->load->view('footer'); ?>

</html>