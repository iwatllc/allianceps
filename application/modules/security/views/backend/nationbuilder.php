<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$enabled = array(
    'name' => 'nb_enabled',
    'id' => 'nb_enabled',
    'class' => 'form-control',
    'checked' => $form_vars['enabled'],
    'value' => 'true'
);

$slug = array(
    'name' => 'slug',
    'id' => 'slug',
    'class' => 'form-control',
    'placeholder' => 'Slug',
    'value' => $form_vars['slug']
);

$client_id = array(
    'name' => 'client_id',
    'id' => 'client_id',
    'class' => 'form-control',
    'placeholder' => 'Client ID',
    'value' => $form_vars['client_id']
);

$client_secret = array(
    'name' => 'client_secret',
    'id' => 'client_secret',
    'class' => 'form-control',
    'placeholder' => 'Client Secret',
    'value' => $form_vars['client_secret']
);

$save = array(
    'name' => 'save',
    'id' => 'save',
    'value' => 'Save Settings',
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
    <title><?php echo $page_data['title']; ?> | <?php echo $page_data['page_title']; ?></title>
</head>
    
<body class = "flat-back">

<?php echo form_open($this->uri->uri_string()); ?>
<?php echo $this->dx_auth->get_auth_error(); ?>


    <!-- begin #content -->
    <div id="content" class="content">

        <!-- begin col-12 -->
        <div class="col-12">
            <!-- begin panel -->
            <div class="panel panel-inverse"  data-sortable-id="table-basic-4">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Manage NationBuilder Integration</h4>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success <? if($form_vars['token_success'] !== true) { echo 'hidden'; } ?>">
                        <strong>Success!</strong>
                        Your NationBuilder token has been stored!
                        <span class="close" data-dismiss="alert">×</span>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <?php echo form_label('Enabled', $slug['id']); ?>
                            <?php echo form_checkbox($enabled) ?>
                            <?php echo form_error($enabled['name']); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Slug', $slug['id']); ?>
                            <?php echo form_input($slug) ?>
                            <?php echo form_error($slug['name']); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Client ID', $client_id['id']); ?>
                            <?php echo form_input($client_id) ?>
                            <?php echo form_error($client_id['name']); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_label('Client Secret', $client_secret['id']); ?>
                            <?php echo form_input($client_secret) ?>
                            <?php echo form_error($client_secret['name']); ?>
                        </div>
                        <div class="form-group">
                            <label>Access Token</label>
                            <p class="form-control-static"><? echo $form_vars['access_token'] ?></p>
                        </div>
                        <div class="form-group">
                            <label>Token Management</label>
                            <p class="form-control-static"><a class="btn" href="<? echo $form_vars['auth_url'] ?>">Retrieve Token</a></p>
                        </div>
                        <?php echo form_submit($save); ?>
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