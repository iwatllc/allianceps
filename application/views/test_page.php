<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php $this->load->view('header'); ?>

<body class="flat-black">

    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade in page-without-sidebar page-header-fixed">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-default navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="<?php echo current_url(); ?>" class="navbar-brand"><span class="navbar-logo"></span> EZ Online Pay</a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->


            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->


        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin page-header -->
            <h1 class="page-header"><?php echo $heading;?></h1>
            <!-- end page-header -->

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Panel Title here</h4>
                </div>
                <div class="panel-body">

                <p>
                    LEXINGTON, K.Y. — John Calipari has always been a bit of a lightning rod.

                    He knows this. He knows he has his fans who laud his on-court accomplishments and his detractors who focus on vacated victories. (On Saturday, for instance, he was the subject of a scathing Boston Globe column criticizing UMass, Calipari’s former employer, for honoring him with a retired jersey.)

                    After beating Florida, 67-50, to give Kentucky an undefeated regular season on Saturday afternoon, Calipari went on the attack, unprompted.

                    “I would imagine ‑- just saying ‑- there will be some stuff written and said,” Calipari said at his postgame news conference. “I want to tell you all, no one will steal my joy. If you want to attack what we’re doing, be nasty about it, have at it. You’re not stealing my joy. Coaching this team, with these kind of kids, you’re not stealing my joy.”

                    Calipari smiled.

                    Later in the news conference, Calipari was asked what it would mean to go 31-0 during the regular season but fall short of winning a national championship.
                    He said he doesn’t consider April 6 — the date of the title game — the end of this season or this journey.

                    “(That’s) on the 28th of June,” Calipari said. “That’s my last day. That’s draft day. We’ll see. I’ll be able to tell you after that. If eight or nine guys get drafted … I’m going to be very happy for whatever happens. I’ll be really happy.”

                </p>


                </div>
            </div>
        </div>
        <!-- end #content -->



        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->

    </div>
    <!-- end page container -->

<?php $this->load->view('footer'); ?>

</body>
</html>