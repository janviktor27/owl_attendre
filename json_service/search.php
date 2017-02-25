<?php include'includes/header.php'; ?>
<?php include'connection.php'; 
		include'classes/class.search.php'?>
<body>
<section id="container" >
		<div class='col-md-4' align='center' style='background-color:#888a85'><br>
		<form method='POST' id='searchform'>
			<div class='col-sm-12'>
				<label form='type'>Course:</label>
					<select class='form-control' name='Course'>
					<?php
					    $query = "SELECT * FROM course";
					    $asd = mysqli_query($_CON, $query);
					while($row = mysqli_fetch_array($asd)){
			    		if($row>0){
			    			$acc = $row['course_acc'];
					    	$name = $row['course_name'];
					    	
					    	echo"
					    		<option value='$acc'>$name</option>
					    	";
			    		}}
					?>
					</select>
			</div>
			<div class='col-sm-12'>
				<label form='type'>Year:</label>
					<select class='form-control' name='Year'>
						<option value='1'>First year</option>
						<option value='2'>Second year</option>
						<option value='3'>Third year</option>
						<option value='4'>Fourth year</option>
						<option value='5'>Fifth year</option>
					</select>
			</div>
			<div class='col-sm-12'>
				<input type='submit' name='search' value='Search'>
			</div>
			</form>			
		</div>
		<div class='col-md-8'>
			<?php
				if (isset($_POST['search'])){
					$course = $_POST['Course'];
					$year = $_POST['Year'];
				}
			    $search = "SELECT * FROM student WHERE course_id = '$course' AND student_yrlvl = '$year'";
			    
			    $runsearch = mysqli_query($_CON, $search);
			    while($row = mysqli_fetch_array($runsearch)){
			    		if($row>0){
			    			$fname = $row['student_fname'];
					    	$lname = $row['student_lname'];
					    	$location = $row['std_location'];
					    	
					    	echo"
					    		<b>".$fname." ".$lname."</b> Last seen in ".$location."<br><br>	
					    	";
			    		}
			    		else{
			    			echo'no Results found';
			    		}

			    }
			
			?>
		
		</div>

	
	

</section>
<?php include'includes/footer.php'; ?>
