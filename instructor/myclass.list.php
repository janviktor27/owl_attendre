<?php include_once'includes/header.php'; ?>
<?php include_once'classes/class.myclasslist.php'; ?>
<body>
<section id="container" >
<!--header start-->
<?php include'includes/top-nav.php';?>
<!--header end-->

<aside>
    <div id="sidebar" class="nav-collapse">
        <?php include'includes/sidebar.php';?>
    </div>
</aside>
<!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
		<div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            My Classes
                        </header>
                        <div class="panel-body">
						<section class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Course</th>
                                    <th>Building-Room</th>
                                    <th>Days & Time</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
									               <?php view(); ?>
                                </tbody>
                            </table>
						</section>
                        </div>
					</section>
                </div>
		</div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->

<?php include'includes/rightsidebar.php';?>
</section>
<?php include_once'includes/footer.php'; ?>
