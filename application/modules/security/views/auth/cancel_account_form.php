<?php
$password = array(
	'name'	=> 'password',
	'id'		=> 'password',
	'size' 	=> 30
);

$cancel = array(
    'name'  => 'cancel',
    'id'    => 'cancel',
    'value' => 'Cancel Account',
    'class' => 'btn btn-sm btn-success'
);

?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('header'); ?>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<head>
    <title><?php echo 'EZOLP | Cancel Account'; ?></title>
</head>
    
<body class = "flat-back">

<?php echo form_open($this->uri->uri_string()); ?>
<?php echo $this->dx_auth->get_auth_error(); ?>

<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
    
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin page-header -->
        <h1 class="page-header"><?php echo 'Cancel Account';?></h1>
        <!-- end page-header -->

        <!-- begin col-12 -->
        <div class="col-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" >
                <div class="panel-heading">
                    <h4 class="panel-title">CANCEL ACCOUNT</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-9">
                        <div class="form-inline">
                            <div class="control-label"
                                <?php echo form_label('Password', $password['id']);?>
                            </div>
                            <?php echo form_input($password); ?> 
                            <?php echo form_error($password['name']); ?>
                        </div>
                    </div>
                    
                    <br />
                    
                    <div class="form-group">
                        <div class="col-md-9">
                            <?php echo form_submit($cancel); ?>                                        
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
