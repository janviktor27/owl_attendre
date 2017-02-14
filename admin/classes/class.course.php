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
			$Course_name = mysqli_real_escape_string($_CON, $_POST['Course_name']);
			$Course_accronym = mysqli_real_escape_string($_CON, $_POST['Course_accronym']);
			$Course_definition = mysqli_real_escape_string($_CON, $_POST['Course_definition']);
			
			//Check if subj_code exist
			$sqlSearch = mysqli_query($_CON, "SELECT * FROM course WHERE course_acc='$Course_accronym' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: course.php?added=exist");
			}else{
				$insertsql = mysqli_query($_CON, "INSERT INTO course (course_name, course_acc, course_fulldef)  VALUES ('$Course_name', '$Course_accronym','$Course_definition' )");
				if(!$insertsql){
					ob_end_clean();
					header("location: course.php?added=failed");
				}else{
					ob_end_clean();
					header("location: course.php?added=success");
				}
			}
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
	function view(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM course ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$id = mysqli_real_escape_string($_CON, $row['course_id']);
				$course_name = mysqli_real_escape_string($_CON, $row['course_name']);
				$course_acc = mysqli_real_escape_string($_CON, $row['course_acc']);
				$course_fulldef = mysqli_real_escape_string($_CON, $row['course_fulldef']);
				$tbl_name = "course";
				$row_name = "course_id";
				echo"
				 <tr>
				  <td>$course_name</td>
				  <td>$course_acc</td>
				  <td>$course_fulldef</td>
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

	function delMod(){
		include_once'class.delete.php';
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM course ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
		$_ID = mysqli_real_escape_string($_CON, $row['course_id']);
		$name = mysqli_real_escape_string($_CON, $row['course_name']);
		$tbl_name = "course";
		$row_name = "course_id";
		echo "
							<div class='modal fade' id='del$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'> 
								<div class='modal-dialog'>
									<div class='modal-content'> 
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'> &times; </button> 
											<h4 class='modal-title' id='myModalLabel'> Delete</h4> 
										</div> 
									<div class='modal-body'> Are you Sure you want to delete <b>$name</b> in the database?</div> 
									<div class='modal-footer'> 
										<form method='post' action='";del();echo"'>
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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM course ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['course_id']);
				$name = mysqli_real_escape_string($_CON, $row['course_name']);
				$acc = mysqli_real_escape_string($_CON, $row['course_acc']);
				$def = mysqli_real_escape_string($_CON, $row['course_fulldef']);
				echo "
			<div aria-hidden='true' aria-labelledby='myModalLabel' class='modal fade' id='upd$_ID' role='dialog' tabindex='-1'>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
							<h4 class='modal-title' id='myModalLabel'>Edit $name</h4>
						</div>
						<form action='";updAction(); echo"' class='form-horizontal bucket-form' method='post'>
						<div class='modal-body'>
								<div class='form-group'>
									<label class='col-sm-3 control-label'>Course Name</label>
									<div class='col-sm-8'>
										<input class='form-control' name='Course_name' type='text' value='$name'>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-sm-3 control-label'>Course Accronym</label>
									<div class='col-sm-8'>
										<input class='form-control' name='Course_accronym' type='text' value='$acc'>
									</div>
								</div>
								<div class='form-group'>
									<label class='col-sm-3 control-label'>Course Definition</label>
									<div class='col-sm-8'>
										<input class='form-control' name='Course_definition' type='textarea' value='$def'>
									</div>
								</div>
						</div>
						<div class='modal-footer'>
							<input class='form-control' name='id' type='hidden' value='$_ID'>
							<button class='btn btn-default' data-dismiss='modal' type='button'>Close</button>
							<button class='btn btn-primary' name='btn_upd' type='submit'>Update </button> 
						</div>
						</form>
					</div>
				</div>
			</div>";
		}}
}

/////////////////////////////////////////////
//UPDATE METHOD
	function updAction(){
		global $_CON;
		if(isset($_POST['btn_upd'])){
			$_ID = mysqli_real_escape_string($_CON, $_POST['id']);
			$name = mysqli_real_escape_string($_CON, $_POST['Course_name']);
			$acc = mysqli_real_escape_string($_CON, $_POST['Course_accronym']);
			$def = mysqli_real_escape_string($_CON, $_POST['Course_definition']);
			
			//CHECK IF DUPLICATED
			$sqlSearch = mysqli_query($_CON, "SELECT course_acc FROM course WHERE course_id='$_ID' ");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['course_acc'];
			if($acc == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				course
				SET
				course_name='$name',
				course_fulldef='$def'
				WHERE
				course_id='$_ID' ");
				header("location: course.php?upd=true");
				ob_end_clean();
				exit;
			}else{
				//CHECK DUPLICATED
				$sqlCheck = mysqli_query($_CON, "SELECT course_acc FROM course WHERE course_acc='$acc' ");
				$count = mysqli_num_rows($sqlCheck);
				if($count == 1){
					header("location: course.php?upd=exist");
					ob_end_clean();
					exit;
				}else{
					$sqlUpdate = mysqli_query($_CON,
					"UPDATE
					course
					SET
					course_name='$name',
					course_acc='$acc',
					course_fulldef='$def'
					WHERE
					course_id='$_ID' ");
					header("location: course.php?upd=true");
					ob_end_clean();
					exit;
				}
			}
		}
	}