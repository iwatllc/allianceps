<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$old_password = array(
	'name'	=> 'old_password',
	'id'		=> 'old_password',
	'size' 	=> 30,
	'value' => set_value('old_password')
);

$new_password = array(
	'name'	=> 'new_password',
	'id'		=> 'new_password',
	'size'	=> 30
);

$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'		=> 'confirm_new_password',
	'size' 	=> 30
);

$change = array(
    'name' => 'change',
    'id' => 'change',
    'value' => 'Change Password',
    'class' => 'btn btn-sm btn-success'
);

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

        <!-- begin col-12 -->
        <div class="col-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" >
                <div class="panel-heading">
                    <h4 class="panel-title">Change Password</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-9">
                        <div class="form-inline">
                            <div class="control-label"
                                <?php echo form_label('Old Password', $old_password['id']);?>
                            </div>
                            <?php echo form_password($old_password); ?>
                            <?php echo form_error($old_password['name']); ?>
                        </div><br/>
                    </div>
                    <div class="col-md-9">
                        <div class="form-inline">
                            <div class="control-label"
                                <?php echo form_label('New Password', $new_password['id']);?>
                            </div>
                            <?php echo form_password($new_password); ?>
                            <?php echo form_error($new_password['name']); ?>
                        </div><br/>
                    </div>
                    <div class="col-md-9">
                        <div class="form-inline">
                            <div class="control-label"
                                <?php echo form_label('Confirm New Password', $confirm_new_password['id']);?>
                            </div>
                            <?php echo form_password($confirm_new_password); ?>
                            <?php echo form_error($confirm_new_password['name']); ?>
                        </div><br/>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9">
                            <?php echo form_submit($change); ?>                                        
                            <?php echo form_close(); ?>
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