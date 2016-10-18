

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{ base_url()}}/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="{{ base_url()}}/assets/crossbrowserjs/html5shiv.js"></script>
        <script src="{{ base_url()}}/assets/crossbrowserjs/respond.min.js"></script>
        <script src="{{ base_url()}}/assets/crossbrowserjs/excanvas.min.js"></script>
    <![endif]-->
    <script src="{{ base_url()}}/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="{{ base_url()}}/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="{{ base_url()}}/assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/masked-input/masked-input.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/password-indicator/js/password-indicator.js"></script>
    <script src="{{ base_url()}}/assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
    <script src="{{ base_url()}}/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
    <script src="{{ base_url()}}/assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/parsley/dist/parsley.js"></script>
    <!-- <script src="assets/js/form-plugins.demo.min.js"></script> -->
    <script src="{{ base_url()}}/assets/js/form-plugins.demo.js"></script>
    <script src="{{ base_url()}}/assets/js/apps.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/maskMoney/jquery.maskMoney.min.js"></script>
    <script src="{{ base_url()}}/assets/plugins/cardswipe/jquery.cardswipe.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <!-- ================== GOOGLE ANALYTICS CODE ================== -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-68634784-1', 'auto');
        ga('send', 'pageview');

    </script>
    <!-- ================== END GOOGLE ANALYTICS CODE ================== -->

    <script>
        $(document).ready(function() {
            App.init();
            FormPlugins.init();
        });
    </script>