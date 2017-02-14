<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'../connection.php';
date_default_timezone_set('Asia/Manila');
$_NOW = date("Y-m-d h:i:s");
$_YEAR = date("Y");
$previousyear = $_YEAR - 1;
$_SY = "$previousyear-$_YEAR";
$ins_id = 12;

function tester(){
	global $_CON;
	global $ins_id;
	global $_SY;
	global $_NOW;
	//CHECK IF HAS CONFLICT WITH ROOMS
	/*
	ins_id
	room_id
	semester
	school_year
	
	
	days
	
	start_time
	end_time
	*/	
	$inpRoom = 9;
	$inpSemester = 4;
	$inpStartTime = strtotime("9:29am");
	$inpEndTime = strtotime("10:30am");	
	$daylist = "Mon,Wed,Fri";
	$exp_day = explode(',',$daylist);
	//$inpStartTime 
	//$inpEndTime
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
				echo "Exist<br>";
				print_r($exp_day);
				echo"<br> Row count ". $count;
				$daysCount = 0;
				$conflictCount = 0;
				while($row=mysqli_fetch_array($sqlSearch)){
					$days = $row['days'];
					$sched_code = $row['sched_code'];
					$compareStart = strtotime($row['start_time']);
					$compareEnd = strtotime($row['end_time']);
					$exp_DAYS = explode(',',$days);
					if(array_intersect($exp_day,$exp_DAYS)){
						//$res = array_intersect($exp_day,$exp_DAYS);//echo "<br>has the day :RESULT ";//print_r($res);
						if($inpStartTime > $compareStart && $inpStartTime < $compareEnd OR $inpStartTime < $compareStart && $inpStartTime > $compareEnd OR $inpEndTime > $compareStart && $inpEndTime < $compareEnd OR $inpEndTime < $compareStart && $inpEndTime > $compareEnd){
						//echo"<br>Conflict with: ".$sched_code;
							$conflictCount++;
						}/*else{
							//INSERT NOW
							//echo"<br>No Conflict with: ".$sched_code;
						}*/
						$daysCount++;
					}/*else{
						//$res = array_intersect($exp_day,$exp_DAYS);//echo "<br>No problem :RESULT ";
						//print_r($res);
					}*/
				}
				////////////////////////
				//IF HAS THE DAY
				if($daysCount > 0){
					//echo $daysCount;
				}else{
					//INSERT DATA HERE!
				}
			}else{
				//echo "0";
				//print_r($exp_day);
				//INSERT DATA HERE!
			}
}
//tester();

//WORKING LOGIC OF TIME
//$start_time = strtotime("8:59am");
//$end_time = strtotime("10:30am");
/*
if jay 7(startTIMe) ket ada jay baet ti compareStart ken compareEnd

$compareStart = strtotime("8:00am");
$compareEnd = strtotime("9:00am");

	if($start_time > $compareStart &&  $start_time < $compareEnd OR $start_time < $compareStart && $start_time > $compareEnd
	OR 
	  $end_time > $compareStart &&  $end_time < $compareEnd OR $end_time < $compareStart && $end_time > $compareEnd){
		echo"1";
	}else{
		echo"0";
	}
*/
