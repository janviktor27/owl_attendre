<?php include'includes/header.php'; ?>
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
      <div class="col-md-3">
          <div class="profile-nav alt">
              <section class="panel text-center">
                  <div class="user-heading alt wdgt-row terques-bg">
                      <i class="fa fa-user"></i>
                  </div>

                  <div class="panel-body">
                      <div class="wdgt-value">
                        <a href="addclass.php?ref=quicklinks">
                          <h1 class="count">4</h1>
                          <p>Classes</p>
                        </a>
                      </div>
                  </div>

              </section>
          </div>
      </div>
		</div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->
<?php include'includes/rightsidebar.php';?>
</section>
<?php include'includes/footer.php'; ?>
