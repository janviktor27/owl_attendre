<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';

    if(isset($_GET['user'])){
      // $CIN = mysqli_real_escape_string($_CON,$_GET['user']);
      $CIN = '13-00857';
      studInfo($CIN);
    }

    function studInfo($CIN){
      global $_CON;
      $result = mysqli_query($_CON,
      "SELECT
       student_cin,
       student_fname,
       student_lname,
       course_acc,
       student_yrlvl
       FROM
       student
       LEFT JOIN
       course
       ON student.course_id=course.course_id
       WHERE
       student_cin='$CIN'
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
