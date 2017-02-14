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
			$name = mysqli_real_escape_string($_CON, $_POST['Subj_name']);
			$unit = mysqli_real_escape_string($_CON, $_POST['Subj_units']);
			$code = mysqli_real_escape_string($_CON, $_POST['Subject_code']);
			
			//Check if subj_code exist
			$sqlSearch = mysqli_query($_CON, "SELECT * FROM subject WHERE subj_code='$code' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: subject.php?added=exist");
			}else{
				$insertsql = mysqli_query($_CON, "INSERT INTO subject (subj_name, subj_units, subj_code)  VALUES ('$name', '$unit','$code' )");
				if(!$insertsql){
					ob_end_clean();
					header("location: subject.php?added=failed");
				}else{
					ob_end_clean();
					header("location: subject.php?added=success");
				}
			}
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
	function view(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM subject ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$id = mysqli_real_escape_string($_CON, $row['subj_id']);
				$subj_name = mysqli_real_escape_string($_CON, $row['subj_name']);
				$subj_units = mysqli_real_escape_string($_CON, $row['subj_units']);
				$subj_code = mysqli_real_escape_string($_CON, $row['subj_code']);
				$tbl_name = "subject";
				$row_name = "subj_id";
				echo"
				 <tr>
				  <td>$subj_code</td>
				  <td>$subj_name</td>
				  <td>$subj_units</td>
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
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM subject ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
		$_ID = mysqli_real_escape_string($_CON, $row['subj_id']);
		$code = mysqli_real_escape_string($_CON, $row['subj_code']);
		$tbl_name = "subject";
		$row_name = "subj_id";
		echo "
							<div class='modal fade' id='del$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'> 
								<div class='modal-dialog'>
									<div class='modal-content'> 
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'> &times; </button> 
											<h4 class='modal-title' id='myModalLabel'> Delete</h4> 
										</div> 
									<div class='modal-body'> Are you Sure you want to delete <b>$code</b> in the database?</div> 
									<div class='modal-footer'> 
										<form method='post' action='"; del(); echo"'>
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
	}}}
	
	function updMod(){
		
				global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM subject ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$id = mysqli_real_escape_string($_CON, $row['subj_id']);
				$subj_name = mysqli_real_escape_string($_CON, $row['subj_name']);
				$subj_units = mysqli_real_escape_string($_CON, $row['subj_units']);
				$subj_code = mysqli_real_escape_string($_CON, $row['subj_code']);
			echo "
											<div class='modal fade' id='upd$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'> 
								<div class='modal-dialog'>
									<div class='modal-content'> 
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'> &times; </button> 
											<h4 class='modal-title' id='myModalLabel'> Edit $subj_code</h4> 
										</div>									
									<div class='modal-body'>
									
									<form class='form-horizontal bucket-form' method='POST' action='"; updAction(); echo"'>
									
                            <div class='form-group'>
                                <label class='col-sm-3 control-label'>Subject Code</label>
                                <div class='col-sm-9'>
                                    <input type='text'  class='form-control' value='$subj_code' name='Subject_code'>
                                </div>
                            </div> 
                            <div class='form-group'>
                                <label class='col-sm-3 control-label'>Subject Name</label>
                                <div class='col-sm-9'>
                                    <input type='text'  class='form-control' value='$subj_name' name='Subj_name'>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-sm-3 control-label'>Subject Units</label>
                                <div class='col-sm-4'>
                                    <input type='number'  class='form-control' value='$subj_units' name='Subj_units'>
                                </div>
                            </div> 
									
									</div> 
									<div class='modal-footer'> 
										<button type='button' class='btn btn-default' data-dismiss='modal'>Close </button>
										<input class='form-control' type='hidden' value='$id' class='form-control' name='id'>
										<button type='submit' name='btn_upd' class='btn btn-primary'> Submit changes </button>
										</form>
									</div>
								</div>
							</div>
						</div>
			";
	}}}

/////////////////////////////////////////////
//UPDATE METHOD
	function updAction(){
		global $_CON;
		if(isset($_POST['btn_upd'])){
			$_ID = mysqli_real_escape_string($_CON, $_POST['id']);
			$name = mysqli_real_escape_string($_CON, $_POST['Subj_name']);
			$unit = mysqli_real_escape_string($_CON, $_POST['Subj_units']);
			$code = mysqli_real_escape_string($_CON, $_POST['Subject_code']);
			
			//CHECK IF DUPLICATED
			$sqlSearch = mysqli_query($_CON, "SELECT subj_code FROM subject WHERE subj_id='$_ID' ");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['subj_code'];
			if($code == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				subject
				SET
				subj_name='$name',
				subj_units='$unit'
				WHERE
				subj_id='$_ID'");
				header("location: subject.php?upd=true");
				ob_end_clean();
				exit;
			}else{
				//CHECK IF EIN EXIST
				$sqlCheck = mysqli_query($_CON, "SELECT subj_code FROM subject WHERE subj_code='$code' ");
				$count = mysqli_num_rows($sqlCheck);
				if($count == 1){
					header("location: subject.php?upd=exist");
					ob_end_clean();
					exit;
				}else{
					$sqlUpdate = mysqli_query($_CON,
					"UPDATE
					subject
					SET
					subj_name='$name',
					subj_units='$unit',
					subj_code='$code'
					WHERE
					subj_id='$_ID'");
					ob_end_clean();
					header("location: subject.php?upd=true");
					exit;
				}
			}
		}
	}