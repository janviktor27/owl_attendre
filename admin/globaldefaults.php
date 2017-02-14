<?php include'includes/header.php'; ?>
<?php include'classes/class.globaldefaults.php'; ?>
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
                <div class="col-md-6">
                    <section class="panel">
                        <header class="panel-heading">
                            School Year
                        </header>
                        <div class="panel-body">
							<form action="<?php updSY(); ?>" method="post">
								<div class="row">
								 <div class="col-xs-6">
									<input value="<?php echo getYear1(); ?>" name="inpYear1" class="form-control" type="number" placeholder="Year 1" required>
								 </div>
								 <div class="col-xs-5 input-group m-bot15">
									<input value="<?php echo getYear2(); ?>" name="inpYear2" class="form-control" type="number" placeholder="Year 2" required>
									<span class="input-group-btn">
										<button name="btn_upd" class="btn btn-success" type="submit"><i class="fa fa-save"></i></button>
									</span>
								 </div>
								</div>
							</form>
						</div>
					</section>
                </div>
                <div class="col-md-6">
                    <section class="panel">
                        <header class="panel-heading">
                            Current Semester
                        </header>
                        <div class="panel-body">
							<form class="form-horizontal bucket-form" action="<?php updReg(); ?>" method="post">
								<div class="form-group">
									<label class="col-sm-2 control-label">Current Semester</label>
									<div class="col-sm-9 icheck minimal">
										<?php DynamicReg(); ?>
									</div>
									<label class="col-sm-2 control-label"></label>
									<button class="btn btn-primary" name="btn_reg" type="submit"><i class="fa fa-save"></i> Save</button>
								</div>
							</form>
							<hr>
							<form class="form-horizontal bucket-form" action="<?php updTri(); ?>" method="post">
								<div class="form-group">
									<label class="col-sm-2 control-label">Current Trimester</label>
									<div class="col-sm-9 icheck minimal">
										<?php DynamicTri(); ?>
									</div>
								<label class="col-sm-2 control-label"></label>
									<button class="btn btn-primary" name="btn_tri" type="submit"><i class="fa fa-save"></i> Save</button>
								</div>
							</form>
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
<?php include'includes/footer.php'; ?>