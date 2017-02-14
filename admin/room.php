<?php include'includes/header.php'; ?>
<?php include'classes/class.room.php'; ?>
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
                            ROOMS
							<button data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i></button>
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Room Name</th>
                                    <th>Building</th>
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
				<h4 class="modal-title">Add Rooms</h4>
			</div>
			<form action="<?php add(); ?>" class="form-horizontal bucket-form" method="post">
			<div class="modal-body">
				<div class="form-group">
					<label class="col-sm-3 control-label">Room Name</label>
					<div class="col-sm-4">
						<input class="form-control" name="inpRoom" placeholder="Enter Room Name" type="text" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" >Building</label>
					<div class="col-sm-8">
						<select class="form-control" name="inpBuilding" required>
							<option value="" default>Select building</option>
							<?php getbuilding(); ?>
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
<?php include'includes/footer.php'; ?>