<?php include'includes/header.php'; ?>
<?php include'connection.php'; ?>
<?php include'classes/class.login.php'; ?>
<body>
<section id="container" >
<br><br>
	<form method='post' class="form-horizontal" action="<?php logIn(); ?>" role="form">
	<div class="form-group">
		<label for="username" class="col-md-4 control-label">CIN: </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="user" placeholder="Enter CIN">
      </div>
	</div>
	<div class="form-group">
		<label for="password" class="col-md-4 control-label">Password: </label>
      <div class="col-sm-5">
        <input type="password" class="form-control" name="pass" placeholder="Enter password">
      </div>
	</div>
			<div class="col-md-offset-4 col-md-1">
				<input type="submit" class="btn btn-default" name="submit" value="Submit">
			</div>
</form>
</section>
<?php include'includes/footer.php'; ?>