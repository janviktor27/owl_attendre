<?php

    include'connection.php';
    
    if(isset($_GET['user'])){
    $cin = $_GET['user'];
    $query = "SELECT * FROM student WHERE student_cin = '$cin'";
    $result= mysqli_query($_CON, $query);
    
    $myarray = array();
    
    while($row = $result->fetch_array(MYSQL_ASSOC)){
    
    //takenote edit to display cin, fnme, lname, course
    	$myarray[] = $row;
    }
    
    echo json_encode($myarray);
    
    $result->close();
    }

    

?>
