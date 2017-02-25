<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';

    if(isset($_GET['user'])){
      $ein = mysqli_real_escape_string($_CON,$_GET['user']);
      insInfo($ein);
    }

    function insInfo($ein){
      global $_CON;
      $result = mysqli_query($_CON,
      "SELECT
       ins_ein,
       ins_fname,
       ins_lname,
       ins_status,
       dep_acc
       FROM
       instructor
       LEFT JOIN
       department
       ON instructor.dept_id=department.dep_id
       WHERE
       ins_ein='$ein'
      ");

      if($result->num_rows > 0){
        $myarray = array();
        while($row = $result->fetch_array(MYSQL_ASSOC)){
        	$myarray[] = $row;
        }
        echo json_encode($myarray);
      }
      $result->close();
    }
