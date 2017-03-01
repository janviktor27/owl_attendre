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

    if(insID($_GET['user']) != '')://CHECK IF USER EXIST
      $ins_id = insID($_GET['user']);
      if(isset($_POST['inpYear']) && isset($_POST['inpCourse']))://CHECK IF INPUTS HAS VALUES
        $inpCourse = $_POST['inpCourse'];

        //GET ALL SCHEDULES
        $sqlSched = mysqli_query($_CON,
        "SELECT
        sched_id
        FROM
        sched_table
        WHERE
        ins_id='$ins_id'
        AND
        course_id='$inpCourse' ");

        if($sqlSched->num_rows > 0)://IF HAS SCHEDULE
          while($row=$sqlSched->fetch_array())://START SCHEDULE LOOP
            //GET SCHED ID'S
            $sched_id = $row['sched_id'];
            //echo"SCHEDID: $sched_id <br>";
            getStudents($sched_id);

          endwhile;//END SCHEDULE LOOP
        else://NO SCHEDULE MATCH
          echo "You don't have any schedules on this course.";
        endif;//IF HAS SCHEDULE
      endif;//CHECK IN INPUTS HAS VALUES
    endif;//CHECK IF CIN EXIST
  }
  //GET STUDENTS
  function getStudents($sched_id){
    global $_CON;
    // GET ALL STUDENTS FROM CLASS
    $sqlClass = mysqli_query($_CON,
    "SELECT
    std_id
    FROM
    class_table
    WHERE
    sched_id='$sched_id'
    GROUP BY std_id");
    while($row=$sqlClass->fetch_array())://GET CLASS STUDS LOOP
      $std_id = $row['std_id'];
      getStudInfo($std_id);
    endwhile;//STOP CLASS LOOP
    exit;
  }

  //GET STUDENT INFORMATION
  function getStudInfo($std_id){
    global $_CON;
    $inpYear = $_POST['inpYear'];
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    student_fname
    FROM
    student
    WHERE
    std_id='$std_id'
    AND
    student_yrlvl='$inpYear'");
    $row = $sqlSearch->fetch_array();
    $student_fname = $row['student_fname'];
    echo $student_fname."<br/>";
  }
  function insID($ein){
    global $_CON;
    $clean_ein = mysqli_real_escape_string($_CON, $ein);
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    ins_id
    FROM
    instructor
    WHERE
    ins_ein='$clean_ein'");
    if($count = $sqlSearch->num_rows == 1):
      $row = $sqlSearch->fetch_array();
      $ins_id = $row['ins_id'];
      return $ins_id;
    else:
      $ins_id = '';
      return $ins_id;
    endif;
  }
