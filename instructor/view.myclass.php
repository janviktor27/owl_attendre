<?php include_once'includes/header.php'; ?>
<?php include_once'classes/class.view-myclass.php'; ?>
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
                          <div class="row">
                            <div class="col-md-8 col-xs-6 pull-left">
                              <a href="myclass.list.php?ref=back" class="btn btn-info btn-xs"><i class="fa fa-arrow-left"></i> </a>
                              <?php getSubj(); ?><span class="hidden-xs"> - CLASS STUDENTS</span>
                            </div>
                            <form method="get" action="<?php globalDATE(); ?>">
`                            <div class="input-group col-md-4 col-xs-6 pull-right">
                                <input type="date" name="inpDATE" class="form-control input-sm"/>
                                <span class="input-group-btn">
                                  <button name="btn_search" class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                           </form>
                          </div>
                        </header>
                        <div class="panel-body">
						               <section class="table-responsive">
                           <form method="post" action="<?php createAttendance(); ?>">
                            <table class="table table-hover table-bordered">
                                <thead>
                                  <tr>
                                    <td colspan="2">
                                      <span class="pull-right">
                                        Please save to apply changes.
                                      </span>
                                    </td>
                                    <td>
                                      <span class="pull-right">
                                        <button type="submit" name="btn_attend" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                                      </span>
                                    </td>
                                  </tr>
                                <tr>
                                    <th></th>
                                    <th>Student Name</th>
                                    <th>Course - Year</th>
                                </tr>
                                </thead>
                                <tbody>
									               <?php view(); ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="2">
                                      <span class="pull-right">
                                        Please save to apply changes.
                                      </span>
                                    </td>
                                    <td>
                                      <span class="pull-right">
                                        <button type="submit" name="btn_attend" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                                      </span>
                                    </td>
                                  </tr>
                                </tfoot>
                            </table>
                           </form>
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
