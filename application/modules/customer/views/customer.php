<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('navbar'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ezolp-dialog-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ezolp-switch.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/dropzone.css">

<style type="text/css">
    /* For some reason the button colors are not changing so we are overriding them here */
    .btn-success, .btn-success:hover, .btn-success:active, .btn-success:visited, .btn-success:focus {
        background-color: forestgreen !important;
        border-color: green !important;
    }
    .btn-info, .btn-info:hover, .btn-info:active, .btn-info:visited, .btn-info:focus {
        background-color: steelblue !important;
        border-color: royalblue !important;
    }
    .btn-default, .btn-default:hover, .btn-default:active, .btn-default:visited, .btn-default:focus {
        background-color: mediumpurple !important;
        border-color: rebeccapurple !important;
    }

</style>

<head>
    <title><?php echo $title; ?></title>
</head>

<body>

    <div id="modal-dialog"></div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body">
              <p>Accepted Image Formats: JPEG, PNG, GIF</p>
              <div id="myDropzone" class="dropzone"></div> <!-- This is the dropzone element -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <div class="content" style="border:5px solid #eee;">
        
        <!-- begin CUSTOMER SEARCH -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">&nbsp;</h4>
            </div>
            <div class="panel-body">

                <button type="button" class="btn btn-success addcustomer-btn"><span class="glyphicon glyphicon-plus"></span> Add Customer</button>
                <!--<button type="button" class="btn btn-danger delcustomer-btn"><span class="glyphicon glyphicon-trash"></span> Delete</button>-->

                <span style="float:right">
                    <div id="data-table_filter" class="dataTables_filter">
                        <label>
                            Search:
                            <input type="search" class placeholder aria-controls="data-table no-footer" role="grid" aria-describedby="" id="customersearch">
                        </label>
                        <br/>
                    </div>
                </span>

            </div>
        </div>
        <!-- end CUSTOMER SEARCH -->

        <!-- begin CUSTOMER TABLE -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">Customers</h4>
            </div>
            <div class="panel-body">

                <br/>

                <div class="table-responsive">
                    <table id="customer-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Customer Name</th>
                                        <th>Slug Name</th>
                                        <th>CF1</th>
                                        <th>CF2</th>
                                        <th>CF3</th>
                                        <th>Logo</th>
                                        <th>Enabled</th>
                                    </tr>
                                </thead>
                                <tbody id="fbody">
                                    <?php foreach ($customers -> result() as $customer) { ?>
                                        <tr id="<?php echo $customer->id; ?>">
                                            <td>
                                                <button type="button" class="btn btn-info editcustomer-btn" data-id="<?php echo $customer -> id ?>"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
                                            </td>
                                            <td><?php echo $customer -> customername ?></td>
                                            <td>
                                                <a href="<?php echo base_url('paymentform/'.$customer->slugname) ?>" target="_blank"><?php echo $customer -> slugname ?></a></td>
                                            </td>
                                            <td bgcolor="<?php if ($customer->cf1enabled == 1) {echo '#e5ffe5';} else {echo '#ffe5e5';} ?>">
                                                <?php
                                                echo $customer -> cf1name;
                                                if ($customer->cf1required)
                                                {
                                                    echo ' <strong>*</strong>';
                                                }
                                                ?>
                                            </td>
                                            <td bgcolor="<?php if ($customer->cf2enabled == 1) {echo '#e5ffe5';} else {echo '#ffe5e5';} ?>">
                                                <?php
                                                    echo $customer -> cf2name;
                                                    if ($customer->cf2required)
                                                    {
                                                        echo ' <strong>*</strong>';
                                                    }
                                                ?>
                                            </td>
                                            <td bgcolor="<?php if ($customer->cf3enabled == 1) {echo '#e5ffe5';} else {echo '#ffe5e5';} ?>">
                                                <?php
                                                echo $customer -> cf3name;
                                                if ($customer->cf3required)
                                                {
                                                    echo ' <strong>*</strong>';
                                                }
                                                ?>
                                            </td>
                                            <td style="width:100px; text-align:center; vertical-align:middle">
                                                <?php if ($customer->logofile != '') { ?>
                                                    <a class="addlogo-btn" data-id="<?php echo $customer -> id ?>" data-cname="<?php echo $customer -> customername ?>" style="cursor: pointer;" title="Click to update logo">
                                                        <img src="<?php echo site_url("client/uploads/".$customer->logofile); ?>" style="max-height:100%; max-width:100%" />
                                                    </a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default addlogo-btn" data-id="<?php echo $customer -> id ?>" data-cname="<?php echo $customer -> customername ?>"><span class=" glyphicon glyphicon-upload"></span> Upload</button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                  <input type="checkbox" class="disablecustomer-switch" <?php if($customer->enabled == 1){ echo 'checked';} ?> data-id="<?php echo $customer->id; ?>">
                                                  <div class="slider"></div>
                                                </label>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                </div>

            </div>
        </div>
        <!-- end CUSTOMER TABLE -->

    </div>

</body>

<?php $this->load->view('footer'); ?>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/customer/customer.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/dropzone.js"></script>

<script type="text/javascript">

Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("div#myDropzone", {
    url: "customer/upload_image",
    dictDefaultMessage: "Drop or click here to upload an image",
    acceptedFiles: "image/*",
    init: function() {
        this.on("addedfile", function()
        {
            if (this.files[1]!=null)
            {
                this.removeFile(this.files[0]);
            }
        }),
        this.on("sending", function(file, xhr, formData){
            var cid = $("#myModal").attr("customerid");
            formData.append("cid", cid);
        }),
        this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
            {
                $('#myModal').modal("hide");
                location.reload();
                done();
            }
        });
    }
});

</script>

</html>