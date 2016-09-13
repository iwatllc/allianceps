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

<head>
    <title><?php echo $title; ?></title>
</head>

<body class = "flat-back">


<div id="content" class="content">

    <div class="row">
        <!-- begin col-12 -->
        <div class="col-12">
            <div class="panel panel-inverse" >
                <div class="panel-heading">
                    <h4 class="panel-title">RECURRING TRANSACTIONS</h4>
                </div>
                <div class="panel-body">
                    <?php
                        if(isset($Delete_Success)){
                            if($Delete_Success == 1){
                                echo "<div class='alert alert-success'>Recurring Transaction was Successfully Deleted</div>";
                            } elseif ($Delete_Success == 0) {
                                echo "<div class='alert alert-error'>Recurring Transaction was NOT Successfully Deleted</div>";
                            }
                        }

                    ?>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered tablesorter">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Transaction Amount</th>
                                <th>CC Last 4</th>
                                <th>Card Type</th>
                                <th>Date</th>
                                <th>Satus</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $results = $query;
                            foreach ($results->result() as $result)
                            {
                                echo "<tr>";
                                echo "<td>";
                                echo $result->first_name . ' ' . $result->last_name;
                                echo "</td>";
                                echo "<td width='200px'>";
                                echo $result->address . '<br>';
                                echo $result->city . ' ' . $result->state . ' ' . $result->zip;
                                echo "</td>";
                                echo "<td>";
                                echo $result->email;
                                echo "</td>";
                                echo "<td align='right'>";
                                echo sprintf('$%01.2f', $result->plan_amount);
                                echo "</td>";
                                echo "<td align='right'>";
                                echo $result->creditcard;
                                echo "</td>";
                                echo "<td>";
                                echo $result->cardtype;
                                echo "</td>";
                                echo "<td>";
                                echo date_conversion_notime($result->created);
                                echo "</td>";
                                echo "<td>";
                                echo $result->status;
                                echo "</td>";
                                echo "<td>";
                                if ($result->status == 'Active'){
                                    echo anchor('recurring/cancelrecurring/'.$result->subscription_id, 'Cancel', 'class="canclerecurring"' );
                                } else {
                                    echo "&nbsp;";
                                }
                                echo "</td>";
                                echo "</tr>";
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end #content -->
    <input id="transactionid" type="hidden"/>
    <div id="dialog-confirm-void" title="Void Transaction?"></div>
    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->

</div>
<!-- end page container -->

</body>

<?php $this->load->view('footer'); ?>

</html>

<div id="dialog" title="Confirmation Required">
    Are you sure you want to cancel the recurring transaction?
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#dialog").dialog({
            autoOpen: false,
            modal: true
        });
    });

    $(".canclerecurring").click(function(e) {
        e.preventDefault();
        var targetUrl = $(this).attr("href");

        $("#dialog").dialog({
            buttons : {
                "Confirm" : function() {
                    window.location.href = targetUrl;
                },
                "Cancel" : function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#dialog").dialog("open");
    });
</script>
