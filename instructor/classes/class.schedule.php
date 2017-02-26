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
$ins_id = $_SESSION['ins_id'];

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ADD INSTRUCTOR
	function add(){
		global $_CON;
		global $ins_id;
		$_SY = getYear();
		global $_NOW;
		if(isset($_POST['btn_add'])){
			$inpSubject = mysqli_real_escape_string($_CON, $_POST['inpSubject']);
			$inpRoom = mysqli_real_escape_string($_CON, $_POST['inpRoom']);
			$inpCourse = mysqli_real_escape_string($_CON, $_POST['inpCourse']);
			$inpSemester = mysqli_real_escape_string($_CON, $_POST['inpSemester']);
			$inpDays = $_POST['inpDays'];
			$daylist = implode(',', $inpDays);
			//TO MAKE IT ARRAY
			$exp_day = explode(',',$daylist);
			$inpStartTime = mysqli_real_escape_string($_CON, $_POST['inpStartTime']);
			$inpEndTime = mysqli_real_escape_string($_CON, $_POST['inpEndTime']);
			$inpSchedCODE = mysqli_real_escape_string($_CON, $_POST['inpSchedCODE']);

			$sqlSearch = mysqli_query($_CON,
			"SELECT
			ins_id,
			room_id,
			semester,
			school_year,
			sched_code,
			days,
			start_time,
			end_time
			FROM
			sched_table
			WHERE
			room_id='$inpRoom'
			AND
			semester='$inpSemester'
			AND
			school_year='$_SY'");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				$daysCount = 0;
				$conflictCount = 0;
				//SCHEDULE CONFLICT CHECKING
				while($row=mysqli_fetch_array($sqlSearch)){
					$days = $row['days'];
					$sched_code = $row['sched_code'];
					$compareStart = strtotime($row['start_time']);
					$compareEnd = strtotime($row['end_time']);
					$exp_DAYS = explode(',',$days);
					if(array_intersect($exp_day,$exp_DAYS)){
						if($inpStartTime > $compareStart && $inpStartTime < $compareEnd OR $inpStartTime < $compareStart && $inpStartTime > $compareEnd OR $inpEndTime > $compareStart && $inpEndTime < $compareEnd OR $inpEndTime < $compareStart && $inpEndTime > $compareEnd){
							$conflictCount++;
						}
					$daysCount++;
					}
				}
				//SCHEDULE END

					////////////////////////
					//IF DAY EXIST
					if($daysCount > 0){
						if($conflictCount > 0){
							//EXIT IT HAS CONFLICT ROOM INUSE
							header("location: schedules.php?room=inuse&time=conflict");
							ob_end_clean();
							exit;
						}else{
							//INSERT DATA HERE HAS NO TIME CONFLICTS
							$sqlInsert = mysqli_query($_CON,
							"INSERT
							INTO
							sched_table
							(subject_id,
							ins_id,
							room_id,
							course_id,
							semester,
							school_year,
							sched_code,
							days,
							start_time,
							end_time,
							date_added)
							VALUES
							('$inpSubject',
							'$ins_id',
							'$inpRoom',
							'$inpCourse',
							'$inpSemester',
							'$_SY',
							'$inpSchedCODE',
							'$daylist',
							'$inpStartTime',
							'$inpEndTime',
							'$_NOW')");
							header("location: schedules.php?days=exist&time=noconflict");
							ob_end_clean();
							exit;
						}
					}else{
						//INSERT DATA HERE DAYS DOESN'T EXIST
						$sqlInsert = mysqli_query($_CON,
						"INSERT
						INTO
						sched_table
						(subject_id,
						ins_id,
						room_id,
						course_id,
						semester,
						school_year,
						sched_code,
						days,
						start_time,
						end_time,
						date_added)
						VALUES
						('$inpSubject',
						'$ins_id',
						'$inpRoom',
						'$inpCourse',
						'$inpSemester',
						'$_SY',
						'$inpSchedCODE',
						'$daylist',
						'$inpStartTime',
						'$inpEndTime',
						'$_NOW')");
						header("location: schedules.php?days=unique");
						ob_end_clean();
						exit;
					}
			}else{
				//INSERT DATA HERE VERY UNIQUE SCHEDULE
				$sqlInsert = mysqli_query($_CON,
				"INSERT
				INTO
				sched_table
				(subject_id,
				ins_id,
				room_id,
				course_id,
				semester,
				school_year,
				sched_code,
				days,
				start_time,
				end_time,
				date_added)
				VALUES
				('$inpSubject',
				'$ins_id',
				'$inpRoom',
				'$inpCourse',
				'$inpSemester',
				'$_SY',
				'$inpSchedCODE',
				'$daylist',
				'$inpStartTime',
				'$inpEndTime',
				'$_NOW')");
				header("location: schedules.php?schedule=unique");
				ob_end_clean();
				exit;
			}
		}
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//SUBJECT OPTION
	function optSubject(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT *
		FROM
		subject");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = $row['subj_id'];
				$subj_name = $row['subj_name'];
				echo"<option value='$_ID'>$subj_name</option>";
			}
		}else{
			echo"
			<option value=''>No data yet.</option>
			";
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ROOM OPTION
	function optRoom(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT *
		FROM
		rooms
		ORDER BY
		room_name
		ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = $row['room_id'];
				$room_name = $row['room_name'];
				$building_id = $row['building_id'];
				$building_name = buildingName($building_id);
				echo"<option value='$_ID'>$building_name - $room_name</option>";
			}
		}else{
			echo"
			<option value=''>No data yet.</option>
			";
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ROOM OPTION
	function optCourse(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT *
		FROM
		course
		ORDER BY
		course_name
		ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = $row['course_id'];
				$course_name = $row['course_name'];
				$course_acc = $row['course_acc'];
				echo"<option value='$_ID'>$course_acc - $course_name</option>";
			}
		}else{
			echo"
			<option value=''>No data yet.</option>
			";
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
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
				if($getClass > 0){
					$dynaButton = "
				   <a href='view.thisclass.php?sched=$enc_ID' class='btn btn-primary btn-xs'> <i class='glyphicon glyphicon-list'></i></a>
				   <button class='btn btn-danger btn-xs disabled'> <i class='glyphicon glyphicon-trash'></i></button>
					";
				}else{
					$dynaButton = "
				   <button class='btn btn-primary btn-xs disabled'> <i class='glyphicon glyphicon-list'></i></button>
				   <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#del$_ID'> <i class='glyphicon glyphicon-trash'></i></button>
					";
				}
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
				$forEndTime = date_format($end_time,"h:i:A");
				echo"
				 <tr>
				  <td>$subject_name</td>
				  <td>$buildRoom</td>
				  <td>$course_name</td>
				  <td>$days | $forStartTime-$forEndTime</td>
				  <td>$sched_code</td>
				  <td class='col-md-2'>$dynaButton</td>
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
//SUBJECT GET
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

function RegularSem(){
	global $_CON;
	$sqlSearch = mysqli_query($_CON,
	"SELECT
	value
	FROM
	semester_type
	WHERE
	type='Regular' ");
	$count = mysqli_num_rows($sqlSearch);
	if($count == 1){
		$row = mysqli_fetch_array($sqlSearch);
		$value = $row['value'];
		return $value;
	}
}

function TriSem(){
	global $_CON;
	$sqlSearch = mysqli_query($_CON,
	"SELECT
	value
	FROM
	semester_type
	WHERE
	type='Trisem' ");
	$count = mysqli_num_rows($sqlSearch);
	if($count == 1){
		$row = mysqli_fetch_array($sqlSearch);
		$value = $row['value'];
		return $value;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
	function delMod(){
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
				$forEndTime = date_format($end_time,"h:i:A");
				echo"
				<div aria-hidden='true' id='del$_ID' aria-labelledby='myModalLabel' class='modal fade'  role='dialog' tabindex='-1'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
								<h4 class='modal-title'>Are you sure you want to delete?</h4>
							</div>
							<form action='"; delAction(); echo"' class='form-horizontal bucket-form' method='post'>
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
			}
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


///////////////////////////////////
//GENERATE SIX RANDOM NUMBER
function unqID($length = 6) {
    $characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    echo "$randomString";
}

	function getYear(){
		global $_CON;
		$GETYEAR = mysqli_query($_CON,"SELECT * FROM cur_school_yr");
		$_row = mysqli_fetch_array($GETYEAR);
		$year_1 = $_row['year_1'];
		$year_2 = $_row['year_2'];
		$_SY = "$year_1-$year_2";
		return $_SY;
	}
