<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
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
				$_ID = mysqli_real_escape_string($_CON, $row['class_id']);
				$std_id = mysqli_real_escape_string($_CON, $row['std_id']);
				$student_name = studName($std_id);
				$student_name = explode(',',$student_name);
				$studentfullname = $student_name[0];
				$studentCY = $student_name[1];
				$sqlSched = mysqli_query($_CON,
				"SELECT
				attend_id
				FROM
				attendance_table
				WHERE
				sched_id='$sched_id'
				AND
				stud_id='$std_id'");
				if($sqlSched->num_rows > 0):
					$dynaButton = "<button class='btn btn-danger btn-xs disabled'> <i class='fa fa-times'></i></button>";
				else:
					$dynaButton = "<button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#del$_ID'> <i class='fa fa-times'></i></button>";
				endif;
				echo"
				 <tr>
				  <td>$studentfullname</td>
				  <td>$studentCY</td>
				  <td>$dynaButton</td>
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
					$_ID = mysqli_real_escape_string($_CON, $row['class_id']);
					$std_id = mysqli_real_escape_string($_CON, $row['std_id']);
					$student_name = studName($std_id);
					$student_name = explode(',',$student_name);
					$studentfullname = $student_name[0];
					$studentCY = $student_name[1];
					echo"
					<div aria-hidden='true' id='del$_ID' aria-labelledby='myModalLabel' class='modal fade'  role='dialog' tabindex='-1'>
  					<div class='modal-dialog'>
  						<div class='modal-content'>
  							<div class='modal-header'>
  								<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
  								<h4 class='modal-title'>Are you sure you want to remove ?</h4>
  							</div>
  							<form action='"; delAction(); echo"' class='form-horizontal bucket-form' method='post'>
  							<div class='modal-body'>
									<h3>$studentfullname</h3>
									<h4>$studentCY</h4>
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
				}
			}
		}

  /////////////////////////////////////////////
  //DELETE MODAL
  	function delAction(){
  		global $_CON;
			$sched_id = urlencode(base64_encode(sched_id()));
			$subj_id = $_GET['subj'];
  		if(isset($_POST['btn_del'])){
  			$_ID = mysqli_real_escape_string($_CON, $_POST['DEL_ID']);
  			$sqlDel = mysqli_query($_CON,
				"DELETE
				FROM
				class_table
				WHERE
				class_id='$_ID'");
  			if($sqlDel){
  				header("location: view.thisclass.php?sched=$sched_id&&subj=$subj_id&&del=true");
					ob_end_clean();
					exit;
  			}else{
  				header("location: view.thisclass.php?sched=$sched_id&&subj=$subj_id&&del=false");
					ob_end_clean();
					exit;
  			}
  		}
  	}
