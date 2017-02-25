<?php

    include'connection.php';
    
    if(isset($_POST['etUsername']) && isset($_POST['etPassword'])){
    	
    	$username = $_POST['etUsername'];
    	$password = $_POST['etPassword'];
    	
    	$query = "SELECT * FROM student WHERE student_cin = '$username'AND std_pwd = '$password'";
    	
    	$result = mysqli_query($_CON, $query);
    	
    	if($result -> num_rows > 0){
    		echo'success';
    		exit;
    	}
    	else{
    		echo'failed';
    		exit;
    	}
    }

?>
