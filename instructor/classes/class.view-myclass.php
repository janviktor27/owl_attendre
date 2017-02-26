<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
include'globalfunctions.php';
$ins_id = $_SESSION['ins_id'];
$_TODAY = date("M d, Y");
$_NOW = date("Y-m-d h:i:a");

function globalDATE(){
	if(isset($_POST['btn_search'])){
		$inpDATE = $_POST['inpDATE'];
		$inpNEW = date("Y-m-d", strtotime($inpDATE));
		$_DATE = $inpNEW;
		return $_DATE;
	}else{
		$_DATE = date("Y-m-d");
		return $_DATE;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
	function view(){
		global $_CON;
		global $ins_id;
		$_DATE = globalDATE();
		global $_NOW;
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
				//CHECK FOR ATTENDANCE RECORD TODAY
				$sqlCheck = mysqli_query($_CON,
				"SELECT
				attend_id
				FROM
				attendance_table
				WHERE
				stud_id='$std_id'
				AND
				sched_id='$sched_id'
				AND
				attend_datetime LIKE '%$_DATE%' ");
				if($sqlCheck->num_rows > 0){
					$dynamicCHK = "
					<a data-toggle='modal' data-target='#del' class='btn btn-danger btn-xs'><i class='fa fa-times'></i></a>";
				}else{
					$dynamicCHK = "<input type='checkbox' value='$std_id' name='student_list[]' />";
				}
				echo"
				 <tr>
				  <td class='text-center'>
					($_NOW NOW)
					$_DATE
					$dynamicCHK
				  </td>
				  <td>$studentfullname</td>
				  <td>$studentCY</td>
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

	function createAttendance(){
		global $_CON;
		global $_NOW;
		global $ins_id;
		if(isset($_POST['btn_attend'])){
			$sched_id = sched_id();
			$enc_sched_id = urlencode(base64_encode($sched_id));
			$sqlGet = mysqli_query($_CON,
			"SELECT
			subject_id,
			room_id
			FROM
			sched_table
			WHERE
			sched_id='$sched_id'");
			$row = $sqlGet->fetch_array();
			$subject_id = $row['subject_id'];
			$enc_subj = urlencode(base64_encode($subject_id));
			$room_id = $row['room_id'];
			$student_list = $_POST['student_list'];
			foreach($student_list as $std_id => $student_id){
				$_STDID = $student_id;
				$sqlInsert = mysqli_query($_CON,
				"INSERT
				INTO
				attendance_table
				(sched_id,
				subject_id,
				stud_id,
				ins_id,
				room_id,
				attend_datetime)
				VALUES
				('$sched_id',
				 '$subject_id',
				 '$_STDID',
			   '$ins_id',
			 	 '$room_id',
			   '$_NOW')");
			}
			header("location: view.myclass.php?sched=$enc_sched_id&&subj=$enc_subj&&attend=success");
			ob_end_clean();
			exit;
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
				header("location: myclass.list.php?class=false");
				exit;
			}
		}
	}

	function getSubj(){
		global $_CON;
		if(isset($_GET['subj']) !== NULL){
			$subject_id = urldecode(base64_decode($_GET['subj']));
			$sqlSearch = mysqli_query($_CON,
			"SELECT
			subj_name
			FROM
			subject
			WHERE
			subj_id='$subject_id'");
			$count = mysqli_num_rows($sqlSearch);
			if($count == 1){
				$row = $sqlSearch->fetch_array();
				$subj_name = $row['subj_name'];
				echo $subj_name;
			}else{
				header("location: myclass.list.php?class=false");
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
	//DELETE FUNCTION
		function delMod(){
			global $_CON;
			global $ins_id;
			$count = 1;
			if($count > 0){
				// while($row=mysqli_fetch_array($sqlSearch)){
				// 	$_ID = mysqli_real_escape_string($_CON, $row['sched_id']);
					echo"
					<div aria-hidden='true' id='del' aria-labelledby='myModalLabel' class='modal fade'  role='dialog' tabindex='-1'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header'>
									<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
									<h4 class='modal-title'>Are you sure you want to delete?</h4>
								</div>
								<form action='"; delAction(); echo"' class='form-horizontal bucket-form' method='post'>
								<div class='modal-body'>
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
			// 	}
			}
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
