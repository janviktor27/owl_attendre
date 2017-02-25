<?php

    include'connection.php';
    
    if(isset($_POST['scannedqrcode']) && isset($_POST['username'])){
    $qrcode = $_POST['scannedqrcode'];
    $username = $_POST['username'];
    	
    	$query = "UPDATE student SET student_qr_generated='$qrcode' WHERE student_cin='$username'";
    	$qwe = mysqli_query($_CON, $query);
    	if (!$qwe){
    		echo'failed';
    		exit;
    	}
    	else{
    		echo 'success';
    		exit;
    	}
    }

?>
