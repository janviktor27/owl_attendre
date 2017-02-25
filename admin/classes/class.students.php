<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Add Subject
	function add(){
		global $_CON;
		if(isset($_POST['btn_add'])){
		$inpCIN = mysqli_real_escape_string($_CON, $_POST['inpCIN']);
		$inpFNAME = mysqli_real_escape_string($_CON, $_POST['inpFNAME']);
		$inpLNAME = mysqli_real_escape_string($_CON, $_POST['inpLNAME']);
		$inpCOURSE = mysqli_real_escape_string($_CON, $_POST['inpCOURSE']);
		$inpYEARLVL = mysqli_real_escape_string($_CON, $_POST['inpYEARLVL']);
		$defaultPwd = md5("123456");
			//CHECK IF CIN EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT student_cin FROM student WHERE student_cin='$inpCIN' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: students.php?added=exist");
			}else{
				$insertSql = mysqli_query($_CON,
				"INSERT
				INTO
				student
				(student_cin,
				student_fname,
				student_lname,
				course_id,
				student_yrlvl,
				std_pwd)
				VALUES
				('$inpCIN',
				'$inpFNAME',
				'$inpLNAME',
				'$inpCOURSE',
				'$inpYEARLVL',
				'$defaultPwd')");
				$sqlInsert = mysqli_query($_CON,
				"INSERT
				INTO
				parents
				(parent_cin,
				parent_password)
				VALUES
				('$inpCIN',
				'$defaultPwd')");
				header("location: students.php?add=true");
				ob_end_clean();
				exit;
			}
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
	function view(){
		include 'class.delete.php';
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM student ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
		$id = mysqli_real_escape_string($_CON, $row['std_id']);
		$cin = mysqli_real_escape_string($_CON, $row['student_cin']);
		$fname = mysqli_real_escape_string($_CON, $row['student_fname']);
		$lname = mysqli_real_escape_string($_CON, $row['student_lname']);
		$course_id = mysqli_real_escape_string($_CON, $row['course_id']);
		$year = mysqli_real_escape_string($_CON, $row['student_yrlvl']);
		$sqlCourse = mysqli_query($_CON, "SELECT course_acc FROM course WHERE course_id='$course_id'");
		$_row = mysqli_fetch_array($sqlCourse);
		$course_acc = $_row['course_acc'];
				echo"
				 <tr>
				  <td>$cin</td>
				  <td>$fname $lname</td>
				  <td>$course_acc-$year</td>
				  <td class='text-center'>
            <img src='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=$cin' />
          </td>
				  <td>
				      <button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#upd$id'><i class='glyphicon glyphicon-pencil'></i></button>
				      <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#del$id'> <i class='glyphicon glyphicon-trash'></i></button>
					</td>
				 </tr>
				";
			}
		}else{
			echo"
			 <tr>
			  <td colspan=4'>No data yet.</td>
			 </tr>
			";
		}
	}
	function getCourse(){
				global $_CON;
				$sqlsearch = "SELECT * FROM course";
				$run = mysqli_query($_CON, $sqlsearch);
				while ($row = mysqli_fetch_array($run))
				{
					$id = $row['course_id'];
					$course = $row['course_name'];
					$course_acc = $row['course_acc'];
					echo "
						<option value='$id'>$course | $course_acc</option>
					";
					}
	}

	function updMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM student ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
		$_ID = mysqli_real_escape_string($_CON, $row['std_id']);
		$cin = mysqli_real_escape_string($_CON, $row['student_cin']);
		$fname = mysqli_real_escape_string($_CON, $row['student_fname']);
		$lname = mysqli_real_escape_string($_CON, $row['student_lname']);
		$course_id = mysqli_real_escape_string($_CON, $row['course_id']);
		$year = mysqli_real_escape_string($_CON, $row['student_yrlvl']);
		$sqlCourse = mysqli_query($_CON, "SELECT course_name,course_acc FROM course WHERE course_id='$course_id'");
		$_row = mysqli_fetch_array($sqlCourse);
		$course_name = $_row['course_name'];
		$course_acc = $_row['course_acc'];
		echo"
			<div aria-hidden='true' aria-labelledby='myModalLabel' class='modal fade' id='upd$_ID' role='dialog' tabindex='-1'>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
							<h4 class='modal-title' id='myModalLabel'>Edit Student</h4>
						</div>
						<form action='"; updAction(); echo"' class='form-horizontal bucket-form' method='post'>
						<div class='modal-body'>
								<div class='form-group'>
									<label class='col-sm-3 control-label'>Student</label>
									<div class='col-sm-4'>
										<input class='form-control' name='inpCIN' type='text' value='$cin'>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-sm-3 control-label'>Full Name</label>
									<div class='col-sm-7'>
										<input class='form-control' name='inpFNAME' type='text' value='$fname'><br>
										<input class='form-control' name='inpLNAME' type='text' value='$lname'>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-sm-3 control-label col-lg-3' >Course</label>
									<div class='col-md-8'>
										<select class='form-control m-bot15' name='inpCOURSE' required>
											<option value='$course_id' default>$course_name | $course_acc</option>
											";getCourse();echo"
										</select>
									</div>
									<div class='col-sm-offset-3 col-md-8'>
										<select class='form-control m-bot15' name='inpYEARLVL'>
											<option>$year</option>
											<option value='1'>1</option>
											<option value='2'>2</option>
											<option value='3'>3</option>
											<option value='4'>4</option>
											<option value='5'>5</option>
										</select>
									</div>
								</div>
						</div>
						<div class='modal-footer'>
							<input class='form-control' name='UPD_ID' type='hidden' value='$_ID'>
							<button class='btn btn-default' data-dismiss='modal' type='button'>Close</button>
							<button class='btn btn-primary' name='btn_upd' type='submit'>Update</button>
						</div>
						</form>
					</div>
				</div>
			</div>
			";
		}
	}
}

/////////////////////////////////////////////
//UPDATE METHOD
	function updAction(){
		global $_CON;
		if(isset($_POST['btn_upd'])){
			$_ID = mysqli_real_escape_string($_CON, $_POST['UPD_ID']);
			$inpCIN = mysqli_real_escape_string($_CON, $_POST['inpCIN']);
			$inpFNAME = mysqli_real_escape_string($_CON, $_POST['inpFNAME']);
			$inpLNAME = mysqli_real_escape_string($_CON, $_POST['inpLNAME']);
			$inpCOURSE = mysqli_real_escape_string($_CON, $_POST['inpCOURSE']);
			$inpYEARLVL = mysqli_real_escape_string($_CON, $_POST['inpYEARLVL']);

			//CHECK IF DUPLICATED
			$sqlSearch = mysqli_query($_CON,
			"SELECT student_cin FROM student WHERE std_id='$_ID' ");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['student_cin'];
			if($inpCIN == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				student
				SET
				student_fname='$inpFNAME',
				student_lname='$inpLNAME',
				course_id='$inpCOURSE',
				student_yrlvl='$inpYEARLVL'
				WHERE
				std_id='$_ID'");
				header("location: students.php?upd=true");
				ob_end_clean();
				exit;
			}else{
				//CHECK IF EIN EXIST
				$sqlCheck = mysqli_query($_CON,
				"SELECT student_cin FROM student WHERE student_cin='$inpCIN'");
				$count = mysqli_num_rows($sqlCheck);
				if($count == 1){
					header("location: students.php?upd=exist");
					ob_end_clean();
					exit;
				}else{
					$sqlParent = mysqli_query($_CON,
					"SELECT parent_id,parent_cin FROM parents WHERE parent_cin='$_GETEIN'");
					$rowParent = mysqli_fetch_array($sqlParent);
					$parent_id = $rowParent['parent_id'];
					$parent_cin = $rowParent['parent_cin'];
					$sqlUpdParent = mysqli_query($_CON,
					"UPDATE
					parents
					SET
					parent_cin='$inpCIN'
					WHERE
					parent_id='$parent_id'");

					$sqlUpdate = mysqli_query($_CON,
					"UPDATE
					student
					SET
					student_cin='$inpCIN',
					student_fname='$inpFNAME',
					student_lname='$inpLNAME',
					course_id='$inpCOURSE',
					student_yrlvl='$inpYEARLVL'
					WHERE
					std_id='$_ID'");
					ob_end_clean();
					header("location: students.php?upd=true");
					exit;
				}
			}
		}
	}

function delMod(){
	global $_CON;
	$sqlSearch = mysqli_query($_CON, "SELECT * FROM student ");
	$count = mysqli_num_rows($sqlSearch);
	if($count > 0){
		while($row=mysqli_fetch_array($sqlSearch)){
		$_ID = mysqli_real_escape_string($_CON, $row['std_id']);
		$cin = mysqli_real_escape_string($_CON, $row['student_cin']);
		echo "
						<div class='modal fade' id='del$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal' aria-hidden='true'> &times; </button>
										<h4 class='modal-title' id='myModalLabel'> Delete</h4>
									</div>
								<div class='modal-body'> Are you Sure you want to delete <b>$cin</b> in the database?</div>
								<div class='modal-footer'>
									<form method='post' action='"; delStud(); echo"'>
									<input type='hidden' value='$_ID' name='STUDENT_ID'>
									<input type='hidden' value='$cin' name='STUDENT_CIN'>
									<button type='button' class='btn btn-default' data-dismiss='modal'>Close </button>
									<button type='submit' name='btn_del' class='btn btn-danger'> Delete </button>
									</form>
								</div>
							</div>
						</div>
						</div>";
		}
	}
}

	function delStud(){
		global $_CON;
		if(isset($_POST['btn_del'])){
			$STUDENT_ID = $_POST['STUDENT_ID'];
			$STUDENT_CIN = $_POST['STUDENT_CIN'];
			$sqlDelParent = mysqli_query($_CON,"DELETE FROM parents WHERE parent_cin='$STUDENT_CIN' ");
			$sqlDel = mysqli_query($_CON,"DELETE FROM student WHERE std_id='$STUDENT_ID' ");
			header("location: students.php?del=true");
			ob_end_clean();
			exit;
		}
	}
