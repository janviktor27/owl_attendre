<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ADD INSTRUCTOR
	function add(){
		global $_CON;
		if(isset($_POST['btn_add'])){
			$cin = mysqli_real_escape_string($_CON, $_POST['Emp_Cin']);
			$fname = mysqli_real_escape_string($_CON, $_POST['Emp_Fname']);
			$lname = mysqli_real_escape_string($_CON, $_POST['Emp_Lname']);
			$inpDepartment = mysqli_real_escape_string($_CON, $_POST['inpDepartment']);
			$defaultPass = md5("123456");
			
			//Check if subj_code exist
			$sqlSearch = mysqli_query($_CON, "SELECT * FROM instructor WHERE ins_ein='$cin' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: instructor.php?added=exist");
			}else{
				$insertsql = mysqli_query($_CON, 
				"INSERT
				INTO
				instructor
				(ins_ein,
				ins_fname,
				ins_lname,
				dept_id,
				ins_pwd) 
				VALUES
				('$cin',
				'$fname',
				'$lname',
				'$inpDepartment',
				'$defaultPass')");
				ob_end_clean();
				header("location: instructor.php?added=true");
			}
		}
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//DEPARTMENT OPTION
	function optDept(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, 
		"SELECT *
		FROM 
		department");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = $row['dep_id'];
				$dep_acc = $row['dep_acc'];
				echo"<option value='$_ID'>$dep_acc</option>";
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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM instructor ORDER BY ins_lname ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$id = mysqli_real_escape_string($_CON, $row['ins_id']);
				$ein = mysqli_real_escape_string($_CON, $row['ins_ein']);
				$fname = mysqli_real_escape_string($_CON, $row['ins_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['ins_lname']);
				$dept_id = mysqli_real_escape_string($_CON, $row['dept_id']);
				$dept_name = deptName($dept_id);
				echo"
				 <tr>
				  <td>$ein</td>
				  <td>$lname, $fname</td>
				  <td>$dept_name</td>
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
			  <td colspan='4'>No subjects yet.</td>
			 </tr>
			";
		}
	}
function deptName($dept_id){
	global $_CON;
	$sqlSearch = mysqli_query($_CON, 
	"SELECT
	dep_acc
	FROM
	department
	WHERE
	dep_id='$dept_id'");
	$count = mysqli_num_rows($sqlSearch);
	if($count == 1){
		$row = mysqli_fetch_array($sqlSearch);
		$dep_acc = $row['dep_acc'];
		return $dep_acc;
	}
}
function delMod(){
	
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM instructor ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
		$_ID = mysqli_real_escape_string($_CON, $row['ins_id']);
		$cin = mysqli_real_escape_string($_CON, $row['ins_ein']);
		$tbl_name = "instructor";
		$row_name = "ins_id";
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
										<form method='post' action='"; echo"'>
										<button type='button' class='btn btn-default' data-dismiss='modal'>Close </button>
										<input class='form-control' type='hidden' value='$_ID' class='form-control' name='id'>
										<input class='form-control' type='hidden' value='$tbl_name' class='form-control' name='tbl_name'>
										<input class='form-control' type='hidden' value='$row_name' class='form-control' name='row_name'>
										<button type='submit' name='delete' class='btn btn-danger'> Delete </button>
										</form>
									</div>
								</div>
							</div>
							</div>";
		}
		}
}

function updMod(){
	
	global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM instructor ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['ins_id']);
				$ein = mysqli_real_escape_string($_CON, $row['ins_ein']);
				$fname = mysqli_real_escape_string($_CON, $row['ins_fname']);
				$lname = mysqli_real_escape_string($_CON, $row['ins_lname']);
				$dept_id = mysqli_real_escape_string($_CON, $row['dept_id']);
				$dept_name = deptName($dept_id);
				echo "
			<div aria-hidden='true' aria-labelledby='myModalLabel' class='modal fade' id='upd$_ID' role='dialog' tabindex='-1'>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
							<h4 class='modal-title' id='myModalLabel'>Edit Instructor</h4>
						</div>
						<form action='"; updAction(); echo"' class='form-horizontal bucket-form' method='post'>
						<div class='modal-body'>
								<div class='form-group'>
									<label class='col-sm-3 control-label'>Employee ID Number</label>
									<div class='col-sm-4'>
										<input class='form-control' name='Emp_Cin' type='text' value='$ein'>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-sm-3 control-label'>Full Name</label>
									<div class='col-sm-7'>
										<input class='form-control' name='Emp_Fname' type='text' value='$fname'><br>
										<input class='form-control' name='Emp_Lname' type='text' value='$lname'>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-sm-3 control-label'>Department</label>
									<div class='col-sm-8'>
										<select class='form-control' name='inpDepartment' required>
											<option value='$dept_id' default>$dept_name</option>
											"; optDept();echo"
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
			$cin = mysqli_real_escape_string($_CON, $_POST['Emp_Cin']);
			$fname = mysqli_real_escape_string($_CON, $_POST['Emp_Fname']);
			$lname = mysqli_real_escape_string($_CON, $_POST['Emp_Lname']);
			$inpDepartment = mysqli_real_escape_string($_CON, $_POST['inpDepartment']);
			
			//CHECK IF INSTRUCTOR EIN ARE THE SAME FROM TEXTBOX AND DATABASE
			$sqlSearch = mysqli_query($_CON, "SELECT ins_ein FROM instructor WHERE ins_id='$_ID' ");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['ins_ein'];
			if($cin == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				instructor
				SET
				ins_fname='$fname',
				ins_lname='$lname',
				dept_id='$inpDepartment'
				WHERE
				ins_id='$_ID' ");
				header("location: instructor.php?upd=true");
				ob_end_clean();
				exit;
			}else{
				//CHECK IF EIN EXIST
				$sqlCheck = mysqli_query($_CON, "SELECT ins_ein FROM instructor WHERE ins_ein='$cin' ");
				$count = mysqli_num_rows($sqlCheck);
				if($count == 1){
					header("location: instructor.php?upd=exist");
					ob_end_clean();
					exit;
				}else{
					$sqlUpdate = mysqli_query($_CON,
					"UPDATE
					instructor
					SET
					ins_ein='$cin',
					ins_fname='$fname',
					ins_lname='$lname',
					dept_id='$inpDepartment'
					WHERE
					ins_id='$_ID'");
					ob_end_clean();
					header("location: instructor.php?upd=true");
					exit;
				}
			}
		}
	}