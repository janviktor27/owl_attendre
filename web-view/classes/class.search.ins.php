<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
include'./../globalfunctions.php';

  function courses(){
    global $_CON;
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    course_id,
    course_acc
    FROM
    course");
    while($row = $sqlSearch->fetch_array()){
      $course_id = $row['course_id'];
      $course_acc = $row['course_acc'];
      echo"
      <option value='$course_id'>$course_acc</option>
      ";
    }
  }

  function searchRes(){
    global $_CON;
    $_SY = getYear();
    $regSem = RegularSem();
    $triSem = TriSem();

    if(studID($_GET['user']) != ''){//CHECK IF USER EXIST
      $stud_id = studID($_GET['user']);
      $class_ids = getClass($stud_id);
    }//CHECK IF CIN EXIST
  }
  //GET STUDENTS
  function getClass($stud_id){
    global $_CON;
    $_SY = getYear();
    $RegSem = RegularSem();
    $TriSem= TriSem();
    // GET ALL STUDENTS FROM CLASS
    $sqlClass = mysqli_query($_CON,
    "SELECT
    ins_id
    FROM
    class_table
    WHERE
    std_id='$stud_id'
    AND
    school_year='$_SY'
    AND
    (current_sem='$RegSem'
    OR
    current_sem='$TriSem')
    GROUP BY ins_id");
    while($row=$sqlClass->fetch_array())://GET CLASS STUDS LOOP
      $ins_id = $row['ins_id'];
      getInsInfo($ins_id);
    endwhile;//STOP CLASS LOOP
    exit;
  }

  //GET INSTRUCTOR INFORMATION
  function getInsInfo($ins_id){
    global $_CON;
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    ins_fname,
    ins_lname,
    ins_status,
    ins_last_loc
    FROM
    instructor
    WHERE
    ins_id='$ins_id'");
    $row = $sqlSearch->fetch_array();
    $ins_fname = $row['ins_fname'];
    $ins_lname = $row['ins_lname'];
    $ins_status = $row['ins_status'];
    $ins_last_loc = $row['ins_last_loc'];
    echo "$ins_fname $ins_lname|$ins_status|$ins_last_loc<br/>";
  }

  function studID($ein){
    global $_CON;
    $clean_cin = mysqli_real_escape_string($_CON, $ein);
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    std_id
    FROM
    student
    WHERE
    student_cin='$clean_cin'");
    if($count = $sqlSearch->num_rows == 1):
      $row = $sqlSearch->fetch_array();
      $std_id = $row['std_id'];
      return $std_id;
    else:
      $std_id = '';
      return $std_id;
    endif;
  }
