<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$username = array(
    'name' => 'username',
    'id' => 'username',
    'class' => 'form-control',
    'placeholder' => 'Username',
    'size' => 30,
    'value' => set_value('username')
);

$email = array(
    'name' => 'email',
    'id' => 'email',
    'class' => 'form-control',
    'placeholder' => 'Email',
    'maxlength' => 80,
    'size' => 30,
    'value' => set_value('email')
);

$password = array(
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control',
    'placeholder' => 'Password',
    'size' => 30,
    'value' => set_value('password')
);

$confirm_password = array(
    'name' => 'confirm_password',
    'id' => 'confirm_password',
    'class' => 'form-control',
    'placeholder' => 'Confirm Password',
    'size' => 30,
    'value' => set_value('confirm_password')
);

$register = array(
    'name' => 'register',
    'id' => 'register',
    'value' => 'Add User',
    'class' => 'btn btn-sm btn-success'
);

?>

<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('header'); ?>
<?php $this->load->view('navbar'); ?>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<head>
    <title><?php echo 'EZOLP | Add User'; ?></title>
</head>

<body class="flat-back">

<?php echo form_open($this->uri->uri_string()); ?>
<?php echo $this->dx_auth->get_auth_error(); ?>

<!-- begin #content -->
<div id="content" class="content">

    <!-- begin col-12 -->
    <div class="col-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Add User</h4>
            </div>

            <div class="panel-body">
                <div class="col-md-9">

                    <div class="form-inline">
                        <div class="control-label"
                        <?php echo form_label('Username', $username['id']); ?>
                    </div>
                    <?php echo form_input($username) ?>
                    <?php echo form_error($username['name']); ?>
                    <br/><br/>

                    <div class="form-inline">
                        <div class="control-label"
                        <?php echo form_label('Email', $email['id']); ?>
                    </div>
                    <?php echo form_input($email) ?>
                    <?php echo form_error($email['name']); ?>
                    <br/><br/>

                    <div class="form-inline">
                        <div class="control-label"
                        <?php echo form_label('Password', $password['id']); ?>
                    </div>
                    <?php echo form_password($password); ?>
                    <?php echo form_error($password['name']); ?>
                    <br/><br/>

                    <div class="form-inline">
                        <div class="control-label"
                        <?php echo form_label('Confirm Password', $confirm_password['id']); ?>
                    </div>
                    <?php echo form_password($confirm_password); ?>
                    <?php echo form_error($confirm_password['name']); ?>

                </div><br/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-9">
            <?php echo form_submit($register); ?>
            <?php echo form_close(); ?><br/><br/>
            <?php if (isset($add_user)) { echo $add_user; } ?>
        </div>
    </div>
</div>
</div>
</div>
<!-- end #content -->

<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
        class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->

</div>
<!-- end page container -->

</body>

<?php $this->load->view('footer'); ?>

</html>