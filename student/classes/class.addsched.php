<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
include'./../globalfunctions.php';
date_default_timezone_set('Asia/Manila');
$_NOW = date("Y-m-d h:i:s");
$_YEAR = date("Y");
$student_id = $_SESSION['student_id'];
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ADD INSTRUCTOR
	function add(){
		global $_CON;
		global $_NOW;
		global $student_id;
		$regSem = RegularSem();
		$triSem = TriSem();
		if(isset($_POST['btn_add'])){
			$inpClassCode = mysqli_real_escape_string($_CON, $_POST['inpClassCode']);

			//CHECK IF SCHED CODE EXIST
			$sqlGet = mysqli_query($_CON,
			"SELECT
			sched_id,
			subject_id,
			ins_id,
			semester,
			school_year
			FROM
			sched_table
			WHERE
			sched_code='$inpClassCode' ");
			$countGet = mysqli_num_rows($sqlGet);
			if($countGet == 1){
				$rowGet = mysqli_fetch_array($sqlGet);
				$sched_id = $rowGet['sched_id'];
				$subject_id = $rowGet['subject_id'];
				$ins_id = $rowGet['ins_id'];
				$semester = $rowGet['semester'];
				$school_year = $rowGet['school_year'];
			}else{
				header("location: addclass.php?errno=403_$inpClassCode");
				ob_end_clean();
				exit;
			}

			//CHECK IF SCHEDULE EXIST
			$sqlSearch = mysqli_query($_CON,
			"SELECT
			class_id
			FROM
			class_table
			WHERE
			sched_id='$sched_id'
			AND
			std_id='$student_id'
			AND
			ins_id='$ins_id'
			AND
			school_year='$school_year'
			AND
			current_sem='$regSem'
			OR
			current_sem='$triSem'");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: addclass.php?added=exist");
			}else{
				$insertsql = mysqli_query($_CON,
				"INSERT
				INTO
				class_table
				(sched_id,
				std_id,
				ins_id,
				subject_id,
				current_sem,
				school_year,
				date_added)
				VALUES
				('$sched_id',
				'$student_id',
				'$ins_id',
				'$subject_id',
				'$semester',
				'$school_year',
				'$_NOW')");
				ob_end_clean();
				header("location: addclass.php?added=true");
			}
		}
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
	function view(){
		global $_CON;
		global $student_id;
		$_SY = getYear();
		$regSem = RegularSem();
		$triSem = TriSem();
		$sqlSearch = mysqli_query($_CON,
		"SELECT
		class_id,
		sched_id,
		ins_id,
		subject_id
		FROM
		class_table
		WHERE
		std_id='$student_id'
		AND
		school_year='$_SY'
		AND
		current_sem='$regSem'
		OR
		current_sem='$triSem'");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['class_id']);
				$sched_id = mysqli_real_escape_string($_CON, $row['sched_id']);
				$sqlSched = mysqli_query($_CON,
				"SELECT
				room_id,
				days,
				start_time,
				end_time
				FROM
				sched_table
				WHERE
				sched_id='$sched_id'");
				$rowSched = mysqli_fetch_array($sqlSched);
				$room_id = $rowSched['room_id'];
				$roomBuild = getRoomBuild($room_id);
				$days = $rowSched['days'];
				$start_time = New DateTime($rowSched['start_time']);
				$format_STIME = date_format($start_time, "h:i:A");
				$end_time = New DateTime($rowSched['end_time']);
				$format_ETIME = date_format($end_time, "h:i:A");
				$ins_id = mysqli_real_escape_string($_CON, $row['ins_id']);
				$ins_name = getINS($ins_id);

				$subject_id = mysqli_real_escape_string($_CON, $row['subject_id']);
				$sqlSubj = mysqli_query($_CON, "SELECT subj_name, subj_units, subj_code FROM subject WHERE subj_id='$subject_id' ");
				$rowSubj = mysqli_fetch_array($sqlSubj);
				$subj_name = $rowSubj['subj_name'];
				$subj_units = $rowSubj['subj_units'];
				$subj_code = $rowSubj['subj_code'];
				echo"
				 <tr>
				  <td>$subj_code</td>
				  <td>$subj_name</td>
				  <td>$subj_units</td>
				  <td>$format_STIME-$format_ETIME/$days</td>
				  <td>$roomBuild</td>
				  <td class='col-md-2'>$ins_name</td>
				 </tr>
				";
			}
		}else{
			echo"
			 <tr>
			  <td colspan='7'>No data yet.</td>
			 </tr>
			";
		}
	}

function getRoomBuild($room_id){
	global $_CON;
	$sqlSearch = mysqli_query($_CON,
	"SELECT
	room_name,
	building_id
	FROM
	rooms
	WHERE
	room_id='$room_id'");
	$count = mysqli_num_rows($sqlSearch);
	if($count == 1){
		$row = mysqli_fetch_array($sqlSearch);
		$room_name = $row['room_name'];
		$building_id = $row['building_id'];
		$getBuilding = buildName($building_id);
		return "$getBuilding-$room_name";
	}
}

function buildName($building_id){
	global $_CON;
	$sqlSearch = mysqli_query($_CON,
	"SELECT
	building_name
	FROM
	building
	WHERE
	building_id='$building_id' ");
	$count = mysqli_num_rows($sqlSearch);
	if($count == 1){
		$row = mysqli_fetch_array($sqlSearch);
		$building_name = $row['building_name'];
		return $building_name;
	}
}
function getINS($ins_id){
	global $_CON;
	$sqlSearch = mysqli_query($_CON,
	"SELECT
	ins_fname,
	ins_lname
	FROM
	instructor
	WHERE
	ins_id='$ins_id' ");
	$count = mysqli_num_rows($sqlSearch);
	if($count == 1){
		$row = mysqli_fetch_array($sqlSearch);
		$ins_fname = $row['ins_fname'];
		$ins_lname = $row['ins_lname'];
		return "$ins_lname, $ins_fname";
	}
}
