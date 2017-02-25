<?php

    include'connection.php';
    
    if(isset($_POST['submit'])){
    	$username = $_POST['username'];
    	$status = $_POST['status'];
    	
    	$query = "UPDATE instructor SET status = '$status' WHERE ins_ein = '$username'";
    	
    	if(mysqli_query($connection, $query)){
    		echo'Success';
    		exit;
    	}
    	else{
    		echo'failed';
    		exit;
    	}
    }

?>
