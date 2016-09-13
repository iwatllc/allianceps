<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('navbar'); ?>

<head>
    <?php
        for ($i = 0; $i < sizeof($total); $i++)
        {
            if ($total[$i] == NULL)
            {
                $total[$i] = 0;
            }
        }
    ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <script src="<?php echo base_url(); ?>/assets/highcharts/js/highcharts.js"></script>
    <script src="<?php echo base_url(); ?>/assets/highcharts/js/modules/exporting.js"></script>
</head>
    
<body class = "flat-back">

<!-- begin #content -->
<div id="content" class="content">

    <!-- begin page-header -->
    <h1 class="page-header"><?php // echo $todays_date; ?>
        <small>

        </small>
    </h1>
    <!-- end page-header -->


    <!-- begin row -->
    <div class="row">
        <!-- begin col-3 -->
        <div class="col-md-6 col-sm-6">
            <div class="widget widget-stats bg-green">
                <div class="stats-icon"><i class="fa fa-users"></i></div>
                <div class="stats-info">
                    <h4>TOTAL TRANSACTIONS</h4>
                    <p><?php echo $total_customers; ?></p>
                </div>
                <div class="stats-link">
                    <a></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-6 col-sm-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-database"></i></div>
                <div class="stats-info">
                    <h4>TOTAL VOLUME</h4>
                    <p><?php echo '$' . $total_volume; ?></p>
                </div>
                <div class="stats-link">
                    <a></a>
                </div>
            </div>
        </div>        <!-- end col-3 -->
    </div>
    <!-- end row -->


    <div class="panel panel-inverse" data-sortable-id="">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title">Sort Dashboard by Date</h4>
        </div>
        <div class="panel-body">

            <?php echo form_open('dashboard/filter_date'); ?>

            <div class="form-inline m-r-10">
                <div class="input-group input-daterange">
                    <?php
                    $BegDate = array(
                        'name'          =>  'BegDate',
                        'value'         =>  set_value('BegDate', $begin_date),
                        'placeholder'   =>  date("m/d/Y", strtotime('-7 days')),
                        'class'         =>  'form-control',
                        'id'            =>  'datepicker',
                    );

                    echo form_input($BegDate)
                    ?>

                    <span class="input-group-addon">to</span>

                    <?php
                    $EndDate = array(
                        'name'          =>  'EndDate',
                        'value'         =>  set_value('EndDate', $end_date),
                        'placeholder'   =>  date('m/d/Y'),
                        'class'         =>  'form-control',
                        'id'            =>  'datepicker2',
                    );

                    echo form_input($EndDate);
                    ?>
                </div>

                <?php
                $submit = array(
                    'name' => 'search_submit',
                    'class' => "btn btn-sm btn-success",
                    'id'    => 'submit',
                    'value' => 'Apply',
                );

                echo form_submit($submit);
                echo form_close();

                ?>
            </div>

        </div>
    </div>


    <!-- begin row -->
    <div class="row">
        <!-- begin col-8 -->
        <div class="col-md-12">
            <div class="panel panel-inverse" data-sortable-id="index-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Gross Volume (by Day)</h4>
                </div>
                <div class="panel-body">

                    <div id="container"></div>

                    <?php
                    // echo the totals between the two dates specified
//                        for ($x = 0; $x < sizeof($total); $x++)
//                        {
//                            echo $days_array[$x] . ' - ';
//                            echo $total[$x];
//                            echo '<br>';
//                        }


                    ?>

                </div>
            </div>
        </div>
        <!-- end col-8 -->
    </div>
    <!-- end row -->

</div>
<!-- end #content -->


</body>

<!-- begin #footer -->
<!-- ================== BEGIN BASE JS ================== -->
<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>/assets/crossbrowserjs/html5shiv.js"></script>
<script src="<?php echo base_url(); ?>/assets/crossbrowserjs/respond.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/masked-input/masked-input.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/parsley/dist/parsley.js"></script>
<!-- <script src="assets/js/form-plugins.demo.min.js"></script> -->
<script src="<?php echo base_url(); ?>/assets/js/form-plugins.demo.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/apps.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/maskMoney/jquery.maskMoney.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/cardswipe/jquery.cardswipe.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->


<script type="text/javascript">

    var company = "<?php echo $page_data['company']; ?>";
    var current_month = "<?php echo $begin_formatted . ' - ' . $end_formatted; ?>";

    // convert php array to js array
    var js_days_array = <?php echo json_encode($days_array);?>;
    var js_total_array = <?php echo json_encode($total);?>;

    // convert array of strings to array of ints
    var js_total_array_numbers = js_total_array.map(Number);

    // whenever the document is ready to execute,
    // execute these series of functions inside of this anonymous function()
    $(document).ready(function() {
        App.init();
        FormPlugins.init();

        var chart1 = new Highcharts.Chart({

            credits: {
                enabled: false
            },

            title: {
                text: 'Gross Volume',
                x: -20 //center
            },

            subtitle: {
                text: current_month,
                x: -20
            },

            chart: {
                renderTo: 'container',
                type: 'line'
            },

            xAxis: {
                categories: js_days_array
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Dollars ($)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: 'blue'
                }]
            },

            tooltip: {
                valuePrefix: '$'
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },

            series: [{
                name: company,
                data: js_total_array_numbers,
                color:'blue'
            }]
        });
    });

</script>

<script type="text/javascript">

    $( document ).ready(function() {
        //$("#myTable").tablesorter();

        $( "#datepicker" ).datepicker({defaultDate: null});
        $( "#datepicker2" ).datepicker({defaultDate: null});
    });

</script>
<!-- end #footer -->

</html>