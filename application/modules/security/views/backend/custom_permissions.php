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
    <title><?php echo 'EZOLP | Custom Permissions'; ?></title>
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
                    <h4 class="panel-title">MANAGE CUSTOM PERMISSIONS</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-inline">
                            <?php
                                echo '<b>Here is an example how to use custom permissions</b><br/><br/>';
                                
                                $show = array(
                                    'name' => 'show',
                                    'id' => 'show',
                                    'value' => 'Show permissions',
                                    'class' => 'btn btn-sm btn-success'  
                                );
                                
                                // Build drop down menu
                                foreach ($roles as $role)
                                {
                                    $options[$role->id] = $role->name;
                                }
                        
                                // Change allowed uri to string to be inserted in text area
                                if ( ! empty($allowed_uri))
                                {
                                    $allowed_uri = implode("\n", $allowed_uri);
                                }
                                
                                if (empty($edit))
                                {
                                    $edit = FALSE;
                                }
                                    
                                if (empty($delete))
                                {
                                    $delete = FALSE;
                                }
                                
                                // Build form
                                echo form_open($this->uri->uri_string());
                                
                                echo form_label('Role', 'role_name_label');
                                echo form_dropdown('role', $options); 
                                echo form_submit($show); 
                                
                                echo form_label('', 'uri_label');
                                        
                                echo '<hr/>';
                                
                                echo form_checkbox('edit', '1', $edit);
                                echo form_label('Allow edit', 'edit_label');
                                echo '<br/>';
                                
                                echo form_checkbox('delete', '1', $delete);
                                echo form_label('Allow delete', 'delete_label');
                                echo '<br/>';
                                            
                                echo '<br/>';

                                    
                            ?>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php
                                $save = array(
                                    'name' => 'save',
                                    'id' => 'save',
                                    'value' => 'Save Permissions',
                                    'class' => 'btn btn-sm btn-success'  
                                );
                                
                                echo form_submit($save);
                              
                            ?>  
                        </div>
                    </div>
                    <div class="col-md-12">
                            <?php
                                echo '<br/>';
                                
                                echo 'Open '.anchor('/security/backend/users/').' to see the result, try to login using user that you have changed.<br/>';
                                echo 'If you change your own role, you need to relogin to see the result changes.';
                                
                                echo form_close();
                            ?>
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