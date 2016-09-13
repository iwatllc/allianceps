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
                    <h4 class="panel-title">Manage Users</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-inline">
                            <?php
                                $ban = array(
                                    'name' => 'ban',
                                    'id' => 'ban',
                                    'value' => 'Ban user',
                                    'class' => 'btn btn-sm btn-success'  
                                );
                                
                                $unban = array(
                                    'name' => 'unban',
                                    'id' => 'unban',
                                    'value' => 'Unban user',
                                    'class' => 'btn btn-sm btn-success'  
                                );
                                
                                $reset_pass = array(
                                    'name' => 'reset_pass',
                                    'id' => 'reset_pass',
                                    'value' => 'Reset password',
                                    'class' => 'btn btn-sm btn-success'  
                                );

                                $delete_user = array(
                                    'name' => 'delete_user',
                                    'id' => 'delete_user',
                                    'value' => 'Delete User',
                                    'class' => 'btn btn-sm btn-success'
                                );
                                
                            // Show reset password message if exist
                            if (isset($reset_message))
                                echo $reset_message;
                            
                            // Show error
                            echo validation_errors();
                            
                            // Table options
                            $tmpl = array (
                                'table_open'  => '<table class="table  table-stripped">',
                                'table_close' => '</table>'
                            );
                            $this->table->set_template($tmpl);
                            
                            $this->table->set_heading('', 'Username', 'Email', 'Role', 'Banned', 'Last IP', 'Last login', 'Created');
                            
                            foreach ($users as $user) 
                            {
                                $banned = ($user->banned == 1) ? 'Yes' : 'No';
                                
                                $this->table->add_row(
                                    form_checkbox('checkbox_'.$user->id, $user->id),
                                    $user->username, 
                                    $user->email, 
                                    $user->role_name,           
                                    $banned, 
                                    $user->last_ip,
                                    date('Y-m-d', strtotime($user->last_login)), 
                                    date('Y-m-d', strtotime($user->created)));
                            }
                            
                            echo form_open($this->uri->uri_string());
                                    
                            echo form_submit($ban);
                            echo form_submit($unban);
                            echo form_submit($reset_pass);
                            echo form_submit($delete_user);
                            
                            echo '<hr/>';
                            
                            echo $this->table->generate(); 
                            
                            echo form_close();
                            
                            echo $pagination;
                            ?>
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