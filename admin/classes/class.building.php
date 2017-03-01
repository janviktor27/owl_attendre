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
			$inpBuilding = mysqli_real_escape_string($_CON, $_POST['inpBuilding']);
			//CHECK IF SUBJECT EXIST
			$sqlSearch = mysqli_query($_CON, "SELECT building_name FROM building WHERE building_name='$inpBuilding' ");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				header("location: building.php?add=exist");
				ob_end_clean();
				exit;
			}else{
				$sqlInsert = mysqli_query($_CON,
				"INSERT
				INTO
				building
				(building_name)
				VALUES
				('$inpBuilding')");
				header("location: building.php?add=true");
				ob_end_clean();
				exit;
			}
		}
	}

/////////////////////////////////////////////
//View employee
	function theview(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM building ORDER BY building_name ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['building_id']);
				$building_name = mysqli_real_escape_string($_CON, $row['building_name']);
				echo"
				 <tr>
				  <td>$building_name</td>
				  <td align='center'>
				   <button class='btn btn-primary btn-xs' data-toggle='modal' data-target='#updMod$_ID'><i class='glyphicon glyphicon-pencil'></i></button>
				   <button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delMod$_ID'><i class='glyphicon glyphicon-trash'></i></button>
				  </td>
				 </tr>
				";
			}
		}else{
			echo"
			 <tr>
			  <td colspan='2'>No data yet. </td>
			 </tr>
			";
		}
	}

/////////////////////////////////////////////
//UPDATE MODAL
	function updMod(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM building ORDER BY building_name ASC");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['building_id']);
				$building_name = mysqli_real_escape_string($_CON, $row['building_name']);
				echo"
				<div aria-hidden='true' aria-labelledby='myModalLabel' class='modal fade' id='updMod$_ID' role='dialog' tabindex='-1'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
								<h4 class='modal-title'>Update Building</h4>
							</div>
							<form action='"; updAction(); echo"' class='form-horizontal bucket-form' method='post'>
							<div class='modal-body'>
									<div class='form-group'>
										<label class='col-sm-3 control-label'>Building</label>
										<div class='col-sm-8'>
											<input value='$building_name' class='form-control' name='inpBuilding' placeholder='Building Name' type='text'>
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
			$inpBuilding = mysqli_real_escape_string($_CON, $_POST['inpBuilding']);

			//CHECK IF PUPIL_CIN ARE THE SAME FROM TEXTBOX AND DATABASE
			$sqlSearch = mysqli_query($_CON, "SELECT building_name FROM building WHERE building_id='$_ID' ");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['building_name'];
			if($inpBuilding == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				building
				SET
				building_name='$inpBuilding'
				WHERE building_id='$_ID' ");
				ob_end_clean();
				header("location: building.php?upd=true");
				exit();
			}else{
				//CHECK IF EIN EXIST
				$sqlSearch = mysqli_query($_CON, "SELECT building_name FROM building WHERE building_name='$inpBuilding' ");
				$count = mysqli_num_rows($sqlSearch);
				if($count == 1){
					ob_end_clean();
					header("location: building.php?upd=exist");
					exit();
				}else{
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				building
				SET
				building_name='$inpBuilding'
				WHERE building_id='$_ID' ");
				ob_end_clean();
				header("location: building.php?upd=true");
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
	$sqlSearch = mysqli_query($_CON, "SELECT * FROM building ");
	$count = mysqli_num_rows($sqlSearch);
	if($count > 0){
		while($row=mysqli_fetch_array($sqlSearch)){
		$_ID = mysqli_real_escape_string($_CON, $row['building_id']);
		$building_name = mysqli_real_escape_string($_CON, $row['building_name']);
		$tbl_name = "building";
		$row_name = "building_id";
		echo"
		<div aria-hidden='true' aria-labelledby='myModalLabel' class='modal fade' id='delMod$_ID' role='dialog' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
						<h4 class='modal-title' id='myModalLabel'>Are you sure you want to delete?</h4>
					</div>
					<div class='modal-body'>
						$building_name
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
