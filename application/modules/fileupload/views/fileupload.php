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
                    <h4 class="panel-title">Upload File To Be Imported</h4>
                </div>
                <div class="panel-body">

                                <?php
                                if($upload_success !=  '' ){
                                    echo $upload_success;
                                }
                                ?>

                                <?php
                                if( isset($error) ){
                                    echo $error['error'];
                                };
                                ?>

                    <?php if(isset($message)){ ?>
                        <div class="alert alert-success fade in m-b-15">
                            <strong><?php echo $message; ?></strong>
                            <span class="close" data-dismiss="alert">&times;</span>
                        </div>
                    <?php } ?>
                                <?php echo form_open_multipart('fileupload/do_upload');?>

                                <input type="file" name="userfile" size="20" />

                                <br /><br />

                                <input type="submit" value="upload" />

                                </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>

</body>
</html>