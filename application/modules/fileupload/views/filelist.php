<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
    table, th, td {
        border-collapse: separate;
        border-spacing:5em;
    }
    th, td {
        padding: 5px;
    }
</style>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->


<?php $this->load->view('navbar'); ?>

<html>
<head>
    <title><?php echo $title; ?></title>
</head>
<body>


<body class = "flat-back">

<div id="content" class="content">

    <div class="row">
        <!-- begin col-12 -->
        <div class="col-12">

            <div class="panel panel-inverse" >
                <div class="panel-heading">
                    <h4 class="panel-title">Select A File To Upload</h4>
                </div>
                <div class="panel-body">
                    <?php if(isset($message)){ ?>
                    <div class="alert alert-success fade in m-b-15">
                        <strong><?php echo $message['message']; ?></strong>
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>
                    <?php } ?>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered tablesorter">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php foreach($map as $file) { ?>
                            <tr>
                                <td><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;<?php echo $file; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>fileupload/file_import/<?php echo $file; ?>">
                                        <i class="fa fa-sign-in fa-lg"></i>
                                        <span>Import</span>
                                    </a>
                                </td>
                                <td>

                                    <a href="<?php echo base_url(); ?>fileupload/file_delete/<?php echo $file; ?>">
                                        <i class="fa fa-trash-o fa-lg"></i>
                                        <span>Delete</span>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>


</body>
</html>