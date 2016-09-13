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
                    <h4 class="panel-title">Prospects Matching Contributions File</h4>
                </div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered tablesorter">
                            <thead>
                            <tr>
                                <th>LAST NAME</th>
                                <th>FIRST NAME</th>
                                <th>CITY, STATE ZIP</th>
                                <th>TRANSACTION AMOUNT</th>
                                <th>TRANSACTION TYPE</th>
                                <th>PARTY AFF.</th>
                            </tr>
                            </thead>
                            <?php foreach($results->result() as $prospect) { ?>
                                <tr>
                                    <td><?php echo $prospect->lastname; ?></td>
                                    <td><?php echo $prospect->firstname; ?></td>
                                    <td><?php echo $prospect->city . ', ' . $prospect->state . ' ' . $prospect->zip_code ; ?></td>
                                    <td><?php echo $prospect->transaction_amt; ?></td>
                                    <td><?php echo $prospect->report_type; ?></td>
                                    <td><?php echo $prospect->CMTE_PTY_AFFILIATION; ?></td>
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