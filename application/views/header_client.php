
    <meta charset="utf-8" />
    <title><?php echo $page_data['title']; ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content=<?php // echo $page_data['description']; ?> name="description" />
    <meta content=<?php // echo $page_data['author']; ?> name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/css/animate.min.css" rel="stylesheet" />

    <!-- ================== REMOVE THE STANDARD CSS  ==================
    <link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/css/theme/default.css" rel="stylesheet" id="theme" />
    -->


    <link href="<?php echo base_url(); ?>/assets/css/ezolp_print.css" rel="stylesheet" id="stylesheettheme" media="print" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/ionRangeSlider/css/ion.rangeSlider.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->

	<!-- Overrides -->
	<?php if (isset($asset) && ! empty($asset)) { ?>
	
	<link type="text/css" rel="stylesheet" href="<?php echo  Modules::run('kmassets/asset_create/index', $asset); ?>" media="all" />
	
	<?php } ?>
	

    <!-- ================== BEGIN BASE JS ================== -->
    <!--<script src="<?php //echo base_url(); ?>/assets/plugins/pace/pace.min.js"></script>-->
    <!-- ================== END BASE JS ================== -->
