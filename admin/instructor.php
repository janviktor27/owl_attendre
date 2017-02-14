<?php include_once'includes/header.php'; ?>
<?php include_once'classes/class.instructor.php'; ?>
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
                            Instructors
							<button data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i></button>
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>EIN</th>
                                    <th>Fullname</th>
                                    <th>Department</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
									<?php view(); ?>
                                </tbody>
                            </table>
                        </div>
					</section>
                </div>
		</div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->
          
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="myModal" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
				<h4 class="modal-title">Add Instructor</h4>
			</div>
			<form action="<?php add(); ?>" class="form-horizontal bucket-form" method="post">
			<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Employee ID Number</label>
						<div class="col-sm-8">
							<input class="form-control" name="Emp_Cin" placeholder="Enter Employye ID Number" type="text" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Full Name</label>
						<div class="col-sm-8">
							<input class="form-control" name="Emp_Fname" placeholder="Enter First Name" type="text" required><br>
							<input class="form-control" name="Emp_Lname" placeholder="Enter Last Name" type="text" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Department</label>
						<div class="col-sm-8">
							<select class="form-control" name="inpDepartment" required>
								<option value="" default>Select department</option>
								<?php optDept();?>
							</select>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
				<button class="btn btn-info" name="btn_add" type="submit">Add</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php include'includes/rightsidebar.php';?>
</section>
<?php updMod(); ?>
<?php delMod(); ?>
<?php include_once'includes/footer.php'; ?>