<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include_once('./../connection.php');

/////////////////////////////////////////////
//Add pupils
	function add(){
		global $_CON;
		if(isset($_POST['btn_add'])){
			$inpDepartment = mysqli_real_escape_string($_CON, $_POST['inpDepartment']);
			//CHECK IF SUBJECT EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT dep_acc FROM department WHERE dep_acc='$inpDepartment' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				header("location: department.php?add=exist");
				ob_end_clean();
				exit;
			}else{
				$sqlInsert = mysqli_query($_CON, 
				"INSERT
				INTO
				department
				(dep_acc)
				VALUES
				('$inpDepartment')");
				header("location: department.php?add=true");
				ob_end_clean();
				exit;
			}
		}
	}

/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM department ORDER BY dep_acc ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['dep_id']);
				$dep_acc = mysqli_real_escape_string($_CON, $row['dep_acc']);
				echo"
				 <tr>
				  <td>$dep_acc</td>
				  <td align='center'>
				   <button class='btn btn-info btn-xs' data-toggle='modal' data-target='#updMod$_ID'><i class='glyphicon glyphicon-edit'></i></button>
				   <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delMod$_ID'><i class='glyphicon glyphicon-trash'></i></button>
				  </td>
				 </tr>
				";
			}
		}else{
			echo"
			 <tr>
			  <td colspan='5'>No data yet. </td>
			 </tr>
			";
		}
	}

/////////////////////////////////////////////
//UPDATE MODAL
	function updMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM department ORDER BY dep_acc ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['dep_id']);
				$dep_acc = mysqli_real_escape_string($_CON, $row['dep_acc']);
				echo"
				<div aria-hidden='true' aria-labelledby='myModalLabel' class='modal fade' id='updMod$_ID' role='dialog' tabindex='-1'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
								<h4 class='modal-title'>Update Department</h4>
							</div>
							<form action='"; updAction(); echo"' class='form-horizontal bucket-form' method='post'>
							<div class='modal-body'>
									<div class='form-group'>
										<label class='col-sm-3 control-label'>Department</label>
										<div class='col-sm-8'>
											<input value='$dep_acc' class='form-control' name='inpDepartment' placeholder='Department Name' type='text'>
										</div>
									</div>
							</div>
							<div class='modal-footer'>
								<input type='hidden' value='$_ID' name='UPD_ID'>
								<button class='btn btn-default' data-dismiss='modal' type='button'>Cancel</button>
								<button class='btn btn-info' name='btn_upd' type='submit'>Update</button>
							</div>
							</form>
						</div>
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
			$inpDepartment = mysqli_real_escape_string($_CON, $_POST['inpDepartment']);

			//CHECK IF PUPIL_CIN ARE THE SAME FROM TEXTBOX AND DATABASE
			$sqlSearch = mysqli_query($_CON, "SELECT dep_acc FROM department WHERE dep_id='$_ID' ");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['dep_acc'];
			if($inpDepartment == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				department
				SET
				dep_acc='$inpDepartment'
				WHERE dep_id='$_ID' ");
				ob_end_clean();
				header("location: department.php?upd=true");
				exit();
			}else{
				//CHECK IF EIN EXIST
				$sqlSearch = mysqli_query($_CON, "SELECT dep_acc FROM department WHERE dep_acc='$inpDepartment' ");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
					ob_end_clean();
					header("location: department.php?upd=exist");
					exit();
				}else{
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				department
				SET
				dep_acc='$inpDepartment'
				WHERE dep_id='$_ID' ");
				ob_end_clean();
				header("location: department.php?upd=true");
				exit();
				}
			}
		}
	}

/////////////////////////////////////////////
//DELETE MODAL AND ACTION
	function delMod(){
	include_once'class.delete.php';
	global $_CON;
	$sqlSearch = mysqli_query($_CON, "SELECT * FROM department ");
	$count = mysqli_num_rows($sqlSearch);
	if($count > 0){
		while($row=mysqli_fetch_array($sqlSearch)){
		$_ID = mysqli_real_escape_string($_CON, $row['dep_id']);
		$dep_acc = mysqli_real_escape_string($_CON, $row['dep_acc']);
		$tbl_name = "department";
		$row_name = "dep_id";
		echo"
		<div aria-hidden='true' aria-labelledby='myModalLabel' class='modal fade' id='delMod$_ID' role='dialog' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
						<h4 class='modal-title' id='myModalLabel'>Are you sure you want to delete?</h4>
					</div>
					<div class='modal-body'>
						$dep_acc
					</div>
					<div class='modal-footer'>
						<form action='"; del(); echo"' method='post'>
							<button class='btn btn-default' data-dismiss='modal' type='button'>Close</button>
							<input class='form-control' name='id' type='hidden' value='$_ID'>
							<input class='form-control' name='tbl_name' type='hidden' value='$tbl_name'>
							<input class='form-control' name='row_name' type='hidden' value='$row_name'>
							<button class='btn btn-danger' name='delete' type='submit'>Delete</button>
						</form>
					</div>
				</div>
			</div>
		</div>";
		}
	}
}