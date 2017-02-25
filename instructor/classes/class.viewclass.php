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
include'globalfunctions.php';
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

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //View Subjects
  	function delMod(){
/*  		global $_CON;
  		global $ins_id;
  		$_SY = getYear();
  		$regularSem = RegularSem();
  		$triSem = TriSem();
  		$sqlSearch = mysqli_query($_CON,
  		"SELECT
  		sched_id,
  		subject_id,
  		room_id,
  		course_id,
  		sched_code,
  		days,
  		start_time,
  		end_time
  		FROM
  		sched_table
  		WHERE
  		school_year='$_SY'
  		AND
  		ins_id='$ins_id'
  		AND
  		semester='$regularSem'
  		OR
  		semester='$triSem'");
  		$count = mysqli_num_rows($sqlSearch);
  		if($count > 0){
  			while($row=mysqli_fetch_array($sqlSearch)){
  				$_ID = mysqli_real_escape_string($_CON, $row['sched_id']);
  				$subject_id = mysqli_real_escape_string($_CON, $row['subject_id']);
  				$subject_name = getSubjectName($subject_id);
  				$room_id = mysqli_real_escape_string($_CON, $row['room_id']);
  				$buildRoom = getBuiRoom($room_id);
  				$course_id = mysqli_real_escape_string($_CON, $row['course_id']);
  				$course_name = getCourse($course_id);
  				$sched_code = mysqli_real_escape_string($_CON, $row['sched_code']);
  				$days = mysqli_real_escape_string($_CON, $row['days']);
  				$start_time = New DateTime($row['start_time']);
  				$forStartTime = date_format($start_time,"h:i:A");
  				$end_time = New DateTime($row['end_time']);
  				$forEndTime = date_format($end_time,"h:i:A");*/
  				echo"
  				<div aria-hidden='true' id='del$_ID' aria-labelledby='myModalLabel' class='modal fade'  role='dialog' tabindex='-1'>
  					<div class='modal-dialog'>
  						<div class='modal-content'>
  							<div class='modal-header'>
  								<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
  								<h4 class='modal-title'>Are you sure you want to delete?</h4>
  							</div>
  							<form action='' class='form-horizontal bucket-form' method='post'>
  							<div class='modal-body'>
  								<table class='table table-bordered table-hover'>
  									<tbody>
  									 <tr>
  									  <th>Subject</th>
  									  <th>$subject_name</th>
  									 </tr>
  									 <tr>
  									  <th>Building-Room</th>
  									  <th>$buildRoom</th>
  									 </tr>
  									 <tr>
  									  <th>Course</th>
  									  <th>$course_name</th>
  									 </tr>
  									 <tr>
  									  <th>Days & Time</th>
  									  <th>$days | $forStartTime - $forEndTime</th>
  									 </tr>
  									 <tr>
  									 <tr>
  									  <th>Class Code</th>
  									  <th>$sched_code</th>
  									 </tr>
  									</tbody>
  								</table>
  							</div>
  							<div class='modal-footer'>
  								<input type='hidden' name='DEL_ID' value='$_ID'>
  								<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
  								<button class='btn btn-danger' name='btn_del' type='submit'>Yes</button>
  							</div>
  							</form>
  						</div>
  					</div>
  				</div>";
  			/*}
  		}*/
  	}

  /////////////////////////////////////////////
  //DELETE MODAL
  	function delAction(){
  		global $_CON;
  		if(isset($_POST['btn_del'])){
  			$_ID = mysqli_real_escape_string($_CON, $_POST['DEL_ID']);
  			$sqlDel = mysqli_query($_CON, "DELETE FROM sched_table WHERE sched_id='$_ID' ");
  			if($sqlDel){
  				ob_end_clean();
  				header("location: schedules.php?del=true");
  			}else{
  				ob_end_clean();
  				header("location: schedules.php?del=false");
  			}
  		}
  	}
