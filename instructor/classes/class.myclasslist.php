<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
date_default_timezone_set('Asia/Manila');
include'globalfunctions.php';
$ins_id = $_SESSION['ins_id'];

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//CLASS LIST
	function view(){
		global $_CON;
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
		ins_id='$ins_id'
		AND
		school_year='$_SY'
		AND
		semester='$regularSem'
		OR
		semester='$triSem'
		");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['sched_id']);
				$enc_ID = urlencode(base64_encode($_ID));
				$getClass = getClass($_ID);
				$subject_id = mysqli_real_escape_string($_CON, $row['subject_id']);
				$enc_subj = urlencode(base64_encode($subject_id));
				if($getClass > 0){
					$dynaButton = "
				   <a href='view.myclass.php?sched=$enc_ID&&subj=$enc_subj' class='btn btn-primary btn-xs'> <i class='glyphicon glyphicon-list'></i></a>
					";
				}else{
					$dynaButton = "
				   <button class='btn btn-primary btn-xs disabled'> <i class='glyphicon glyphicon-list'></i></button>
					";
				}
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
				$forEndTime = date_format($end_time,"h:i:A");
				echo"
				 <tr>
				  <td>$subject_name</td>
          <td>$course_name</td>
				  <td>$buildRoom</td>
				  <td>$days | $forStartTime-$forEndTime</td>
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//COUNT CLASS
	function getClass($_ID){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT
		class_id
		FROM
		class_table
		WHERE
		sched_id='$_ID' ");
		$count = mysqli_num_rows($sqlSearch);
		return $count;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//SUBJECT GET
	function getSubjectName($subject_id){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT
		subj_name
		FROM
		subject
		WHERE
		subj_id='$subject_id'");
		$count = mysqli_num_rows($sqlSearch);
		if($count == 1){
			while($row=mysqli_fetch_array($sqlSearch)){
				$subj_name = $row['subj_name'];
				return $subj_name;
			}
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ROOM GET
	function getBuiRoom($room_id){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT
		room_name,
		building_id
		FROM
		rooms
		WHERE
		room_id='$room_id' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count == 1){
			while($row=mysqli_fetch_array($sqlSearch)){
				$room_name = $row['room_name'];
				$building_id = $row['building_id'];
				$building_name = buildingName($building_id);
				return "$building_name - $room_name";
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ROOM OPTION
	function getCourse($course_id){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT
		course_acc
		FROM
		course
		WHERE
		course_id='$course_id' ");
		$count = mysqli_num_rows($sqlSearch);
		if($count == 1){
			while($row=mysqli_fetch_array($sqlSearch)){
				$course_acc = $row['course_acc'];
				return $course_acc;
			}
		}
	}

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //GET BUILDING NAME
  function buildingName($building_id){
  	global $_CON;
  	$sqlSearch = mysqli_query($_CON,
  	"SELECT
  	building_name
  	FROM
  	building
  	WHERE
  	building_id='$building_id'");
  	$count = mysqli_num_rows($sqlSearch);
  	if($count == 1){
  		$row = mysqli_fetch_array($sqlSearch);
  		$building_name = $row['building_name'];
  		return $building_name;
  	}
  }
