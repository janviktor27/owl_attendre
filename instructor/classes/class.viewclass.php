<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
date_default_timezone_set('Asia/Manila');
$_NOW = date("Y-m-d h:i:s");
$_YEAR = date("Y");
$previousyear = $_YEAR - 1;
$_SY = "$previousyear-$_YEAR";
$ins_id = $_SESSION['ins_id'];

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
	function view(){
		global $_CON;
		global $ins_id;
		global $_SY;
		$sched_id = sched_id();
		$sqlSearch = mysqli_query($_CON, 
		"SELECT
		class_id,
		std_id
		FROM
		class_table
		WHERE
		sched_id='$sched_id'
		AND
		ins_id='$ins_id'");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$std_id = mysqli_real_escape_string($_CON, $row['std_id']);
				$student_name = studName($std_id);
				$student_name = explode(',',$student_name);
				$studentfullname = $student_name[0];
				$studentCY = $student_name[1];
				echo"
				 <tr>
				  <td>$studentfullname</td>
				  <td>$studentCY</td>
				  <td>
				   <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#del$std_id'> <i class='glyphicon glyphicon-trash'></i></button>
				  </td>
				 </tr>
				";
			}
		}else{
			echo"
			 <tr>
			  <td colspan='6'>No data yet.</td>
			 </tr>
			";
		}
	}
	
	function sched_id(){
		global $_CON;
		if(isset($_GET['sched'])){
			$sched_id = urldecode(base64_decode($_GET['sched']));
			$sqlSearch = mysqli_query($_CON,
			"SELECT 
			subject_id
			FROM
			sched_table
			WHERE
			sched_id='$sched_id'");
			$count = mysqli_num_rows($sqlSearch);
			if($count == 1){
				return $sched_id;
			}else{
				header("location: schedules.php?class=false");
				exit;
			}
		}
	}
	
	function studName($std_id){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT	
		student_fname,
		student_lname,
		course_id,
		student_yrlvl
		FROM
		student
		WHERE
		std_id='$std_id'");
		$row = mysqli_fetch_array($sqlSearch);
		$student_fname = $row['student_fname'];
		$student_lname = $row['student_lname'];
		$course_id = $row['course_id'];
		$getCourse = getCourse($course_id);
		$student_yrlvl = $row['student_yrlvl'];
		$myimplode = "$student_fname $student_lname,$getCourse - $student_yrlvl";
		return $myimplode;
	}

	function getCourse($course_id){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT	
		course_acc
		FROM
		course
		WHERE
		course_id='$course_id'");
		$row = mysqli_fetch_array($sqlSearch);
		$course_acc = $row['course_acc'];
		return $course_acc;
	}