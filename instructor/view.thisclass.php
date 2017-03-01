<?php include_once'includes/header.php'; ?>
<?php include_once'classes/class.viewclass.php'; ?>
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
              						<?php getSubj(); ?>- CLASS STUDENTS
              						<span class="pull-right">
              							<a href="schedules.php?ref=back" class="btn btn-info btn-xs"><i class="fa fa-arrow-left"></i> </a>
              						</span>
                        </header>
                        <div class="panel-body">
						               <section class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Course - Year</th>
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
<?php delMod(); ?>
<?php include_once'includes/footer.php'; ?>
