<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Add Subject
	function updSY(){
		global $_CON;
		$oldYear1 = getYear1();
		$oldYear2 = getYear2();
		if(isset($_POST['btn_upd'])){
			$inpYear1 = mysqli_real_escape_string($_CON, $_POST['inpYear1']);
			$inpYear2 = mysqli_real_escape_string($_CON, $_POST['inpYear2']);

			$sqlUpdate = mysqli_query($_CON, 
			"UPDATE
			cur_school_yr
			SET
			year_1='$inpYear1',
			year_2='$inpYear2'
			WHERE
			year_1='$oldYear1'
			AND
			year_2='$oldYear2'");
			header("location: globaldefaults.php?upd=true");
			ob_end_clean();
			exit;
		}
	}
	
	function getYear1(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, 
		"SELECT
		year_1
		FROM
		cur_school_yr");
		$row = mysqli_fetch_array($sqlSearch);
		$year = $row['year_1'];
		return $year;
	}

	function getYear2(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, 
		"SELECT
		year_2
		FROM
		cur_school_yr");
		$row = mysqli_fetch_array($sqlSearch);
		$year = $row['year_2'];
		return $year;
	}
	////////////////////
	/*
	1 - 1st tri
	2 - 2nd tri
	3 - 3rd tri
	4 - 1st Sem
	5 - 2nd Sem
	6 - Summer
	*/
	
	function DynamicReg(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT
		value
		FROM
		semester_type
		WHERE
		type='Regular' ");
		$row = mysqli_fetch_array($sqlSearch);
		$value = $row['value'];
		if($value == 4){
			echo"
			<div class='radio single-row'>
				<input value='4' name='inpRegSem' tabindex='3' type='radio' checked> <label>1st Semester</label>
			</div>
			<div class='radio single-row'>
				<input value='5' name='inpRegSem' tabindex='3' type='radio'> <label>2nd Semester</label>
			</div>
			<div class='radio single-row'>
				<input value='6' name='inpRegSem' tabindex='3' type='radio'> <label>Summer</label>
			</div>
			
			";
		}elseif($value == 5){
			echo"
			<div class='radio single-row'>
				<input value='4' name='inpRegSem' tabindex='3' type='radio'> <label>1st Semester</label>
			</div>
			<div class='radio single-row'>
				<input value='5' name='inpRegSem' tabindex='3' type='radio' checked> <label>2nd Semester</label>
			</div>
			<div class='radio single-row'>
				<input value='6' name='inpRegSem' tabindex='3' type='radio'> <label>Summer</label>
			</div>
			
			";
		}elseif($value == 6){
			echo"
			<div class='radio single-row'>
				<input value='4' name='inpRegSem' tabindex='3' type='radio'> <label>1st Semester</label>
			</div>
			<div class='radio single-row'>
				<input value='5' name='inpRegSem' tabindex='3' type='radio'> <label>2nd Semester</label>
			</div>
			<div class='radio single-row'>
				<input value='6' name='inpRegSem' tabindex='3' type='radio' checked> <label>Summer</label>
			</div>
			
			";
		}
	}
	
	function updReg(){
		global $_CON;
		if(isset($_POST['btn_reg'])){
			$inpRegSem = mysqli_real_escape_string($_CON, $_POST['inpRegSem']);

			$sqlUpdate = mysqli_query($_CON, 
			"UPDATE
			semester_type
			SET
			value='$inpRegSem'
			WHERE
			type='Regular' ");
			header("location: globaldefaults.php?upd=true");
			ob_end_clean();
			exit;
		}
	}

	function DynamicTri(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON,
		"SELECT
		value
		FROM
		semester_type
		WHERE
		type='Trisem' ");
		$row = mysqli_fetch_array($sqlSearch);
		$value = $row['value'];
		if($value == 1){
			echo"
			<div class='radio single-row'>
				<input value='1' name='inpTriSem' tabindex='3' type='radio' checked> <label>1st Trimester</label>
			</div>
			<div class='radio single-row'>
				<input value='2' name='inpTriSem' tabindex='3' type='radio'> <label>2nd Trimester</label>
			</div>
			<div class='radio single-row'>
				<input value='3' name='inpTriSem' tabindex='3' type='radio'> <label>3rd Trimester</label>
			</div>
			";
		}elseif($value == 2){
			echo"
			<div class='radio single-row'>
				<input value='1' name='inpTriSem' tabindex='3' type='radio'> <label>1st Trimester</label>
			</div>
			<div class='radio single-row'>
				<input value='2' name='inpTriSem' tabindex='3' type='radio' checked> <label>2nd Trimester</label>
			</div>
			<div class='radio single-row'>
				<input value='3' name='inpTriSem' tabindex='3' type='radio'> <label>3rd Trimester</label>
			</div>
			";
		}elseif($value == 3){
			echo"
			<div class='radio single-row'>
				<input value='1' name='inpTriSem' tabindex='3' type='radio'> <label>1st Trimester</label>
			</div>
			<div class='radio single-row'>
				<input value='2' name='inpTriSem' tabindex='3' type='radio'> <label>2nd Trimester</label>
			</div>
			<div class='radio single-row'>
				<input value='3' name='inpTriSem' tabindex='3' type='radio' checked> <label>3rd Trimester</label>
			</div>
			";
		}
	}
	
	function updTri(){
		global $_CON;
		if(isset($_POST['btn_tri'])){
			$inpTriSem = $_POST['inpTriSem'];

			$sqlUpdate = mysqli_query($_CON, 
			"UPDATE
			semester_type
			SET
			value='$inpTriSem'
			WHERE
			type='Trisem'");
			header("location: globaldefaults.php?upd=true_$inpTriSem");
			ob_end_clean();
			exit;
		}
	}
