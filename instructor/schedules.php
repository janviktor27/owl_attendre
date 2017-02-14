<?php include_once'includes/header.php'; ?>
<?php include_once'classes/class.schedule.php'; ?>
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
                            Schedules
							<button data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i></button>
                        </header>
                        <div class="panel-body">
						<section class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Building-Room</th>
                                    <th>Course</th>
                                    <th>Days & Time</th>
                                    <th>Class Code</th>
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

<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="myModal" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
				<h4 class="modal-title">Add Schedule</h4>
			</div>
			<form action="<?php add(); ?>" class="form-horizontal bucket-form" method="post">
			<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Subject</label>
						<div class="col-sm-8">
							<select class="form-control" name="inpSubject" required>
								<option value="" default>Select subject</option>
								<?php optSubject();?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Room</label>
						<div class="col-sm-8">
							<select class="form-control" name="inpRoom" required>
								<option value="" default>Select Room</option>
								<?php optRoom();?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Course</label>
						<div class="col-sm-8">
							<select class="form-control" name="inpCourse" required>
								<option value="" default>Select Course</option>
								<?php optCourse();?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Semester</label>
						<div class="col-sm-8">
							<select class="form-control" name="inpSemester" required>
								<option value="" default>Select Semester</option>
								<option value="1">1st Trimester</option>
								<option value="2">2nd Trimester</option>
								<option value="3">3rd Trimester</option>
								<option value="4">1st Semester</option>
								<option value="5">2nd Semester</option>
								<option value="6">Summer</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Days</label>
						<div class="col-sm-9 icheck minimal">
							<div class="checkbox single-row">
								<input name="inpDays[]" value="Mon" type="checkbox"> <label>Monday</label>
							</div>
							<div class="checkbox single-row">
								<input name="inpDays[]" value="Tue" type="checkbox"> <label>Tuesday</label>
							</div>
							<div class="checkbox single-row">
								<input name="inpDays[]" value="Wed" type="checkbox"> <label>Wednesday</label>
							</div>
							<div class="checkbox single-row">
								<input name="inpDays[]" value="Thu" type="checkbox"> <label>Thursday</label>
							</div>
							<div class="checkbox single-row">
								<input name="inpDays[]" value="Fri" type="checkbox"> <label>Friday</label>
							</div>
							<div class="checkbox single-row">
								<input name="inpDays[]" value="Sat" type="checkbox"> <label>Saturday</label>
							</div>
							<div class="checkbox single-row">
								<input name="inpDays[]" value="Sun" type="checkbox"> <label>Sunday</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Start Time</label>
						<div class="col-sm-8">
							<input class="form-control" name="inpStartTime" type="time" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">End Time</label>
						<div class="col-sm-8">
							<input class="form-control" name="inpEndTime" type="time" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Schedule Code</label>
						<div class="col-sm-8">
						<strong>*Give this CODE to your class</strong>
							<input class="form-control" name="inpSchedCODE" value="<?php unqID(); ?>" type="text" readonly>
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
<?php delMod(); ?>
<?php include_once'includes/footer.php'; ?>
