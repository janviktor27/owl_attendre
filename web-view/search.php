<?php include'classes/class.search.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <!--Core CSS -->
    <link href="../assets/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-reset.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet" />
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="full-width">
<section id="container" class="hr-menu">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->

        <div class="row">
    			<div class="col-md-12">
    				<section class="panel">
              <header class="panel-heading">
                <?php if(insID($_GET['user']) != ''): ?>
                <div class="row">
                  <form method="post" action="">
                  <div class="col-md-6 col-xs-6">
                    <select name="inpCourse" class="form-control" required>
                      <option value="" default>Select Course</option>
                      <?php courses(); ?>
                    </select>
                  </div>
                  <div class="input-group col-md-6 col-xs-5">
            					<select class='form-control' name='inpYear' required>
                        <option value='' default>Select Year</option>
            						<option value='1'>First year</option>
            						<option value='2'>Second year</option>
            						<option value='3'>Third year</option>
            						<option value='4'>Fourth year</option>
            						<option value='5'>Fifth year</option>
            					</select>
                      <span class="input-group-btn">
                        <button name="btn_search" class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
                      </span>
                  </div>
                  </form>
                </div>
              <?php else:?>
              Please Login to app.
              <?php endif;?>
              </header>
              <div class="panel-body">
                <?php
                  searchRes();
                ?>
              </div>
    				</section>
    			</div>
        </div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->

</section>

<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="../assets/js/jquery.js"></script>
<script src="../assets/bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../assets/js/jquery.scrollTo.min.js"></script>
<script src="../assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="../assets/js/jquery.nicescroll.js"></script>
<!--Easy Pie Chart-->
<script src="../assets/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="../assets/js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="../assets/js/flot-chart/jquery.flot.js"></script>
<script src="../assets/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="../assets/js/flot-chart/jquery.flot.resize.js"></script>
<script src="../assets/js/flot-chart/jquery.flot.pie.resize.js"></script>
</body>
</html>
