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
			$inpRoom = mysqli_real_escape_string($_CON, $_POST['inpRoom']);
			$inpBuilding = mysqli_real_escape_string($_CON, $_POST['inpBuilding']);
			//Check if  exist
			$sqlSearch = mysqli_query($_CON,
			"SELECT
			room_name
			FROM
			rooms
			WHERE
			room_name='$inpRoom'");
			$count = mysqli_num_rows($sqlSearch);
			if($count > 0){
				ob_end_clean();
				header("location: room.php?add=exist");
			}else{
				$insertsql = mysqli_query($_CON,
				"INSERT
				INTO
				rooms
				(room_name,
				building_id)
				VALUES
				('$inpRoom',
				'$inpBuilding')");
				ob_end_clean();
				header("location: room.php?add=true");
			}
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//View Subjects
	function view(){
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM rooms ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$id = mysqli_real_escape_string($_CON, $row['room_id']);
				$room_name = mysqli_real_escape_string($_CON, $row['room_name']);
				$building_id = mysqli_real_escape_string($_CON, $row['building_id']);
				$building_name = buildName($building_id);
        $merged_name = "$room_name-$building_name";
        $encode_name = urlencode(base64_encode($merged_name));
				echo"
				 <tr>
				  <td>$room_name</td>
				  <td>$building_name</td>
          <td class='text-center'>
            <img src='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=$merged_name' />
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
			  <td colspan='3'>No subjects yet.</td>
			 </tr>
			";
		}
	}
	function buildName($building_id){
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
			$buildName = $row['building_name'];
			return $buildName;
		}
	}
	function getbuilding(){
		global $_CON;
		$sqlsearch = "SELECT * FROM building";
		$run = mysqli_query($_CON, $sqlsearch);
		while ($row = mysqli_fetch_array($run)){
			$bui_id = $row['building_id'];
			$course = $row['building_name'];
			echo "
				<option value='$bui_id'>$course</option>
			";
		}
	}

	function delMod(){
		include_once'class.delete.php';
		global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM rooms ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
		$_ID = mysqli_real_escape_string($_CON, $row['room_id']);
		$name = mysqli_real_escape_string($_CON, $row['room_name']);
				$tbl_name = "rooms";
				$row_name = "room_id";
				echo "
										<div class='modal fade' id='del$_ID' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'> &times; </button>
											<h4 class='modal-title' id='myModalLabel'> Delete</h4>
										</div>
									<div class='modal-body'> Are you Sure you want to delete <b> $name </b>in the database?</div>
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
							</div>
							</div>";
		}
		}

	}

	function updMod(){
				global $_CON;
		$sqlSearch = mysqli_query($_CON, "SELECT * FROM rooms ");
		$count = mysqli_num_rows($sqlSearch);
		if($count > 0){
			while($row=mysqli_fetch_array($sqlSearch)){
				$_ID = mysqli_real_escape_string($_CON, $row['room_id']);
				$room_name = mysqli_real_escape_string($_CON, $row['room_name']);
				$building_id = mysqli_real_escape_string($_CON, $row['building_id']);
				$building_name = buildName($building_id);
				echo"
				<div aria-hidden='true' aria-labelledby='myModalLabel' class='modal fade' id='upd$_ID' role='dialog' tabindex='-1'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>&times;</button>
								<h4 class='modal-title' id='myModalLabel'>Edit Room</h4>
							</div>
							<form action='";updAction(); echo"' class='form-horizontal bucket-form' method='post'>
								<div class='modal-body'>
									<div class='form-group'>
										<label class='col-sm-3 control-label'>Room Name</label>
										<div class='col-sm-4'>
											<input class='form-control' name='inpRoom' type='text' value='$room_name' required>
										</div>
									</div>
									<div class='form-group'>
										<label class='col-sm-3 control-label col-lg-3' for='inputSuccess'>Building</label>
										<div class='col-sm-8'>
											<select class='form-control m-bot15' name='inpBuilding' required>
												<option value='$building_id'>$building_name</option>
												";getbuilding(); echo"
											</select>
										</div>
									</div>
								</div>
								<div class='modal-footer'>
									<input name='UPD_ID' type='hidden' value='$_ID'>
									<button class='btn btn-default' data-dismiss='modal' type='button'>Close</button>
									<button class='btn btn-primary' name='btn_upd' type='submit'>Update</button>
								</div>
							</form>
						</div>
					</div>
				</div>";
			}
		}
	}

/////////////////////////////////////////////
//UPDATE METHOD
	function updAction(){
		global $_CON;
		if(isset($_POST['btn_upd'])){
			$_ID = mysqli_real_escape_string($_CON, $_POST['UPD_ID']);
			$inpRoom = mysqli_real_escape_string($_CON, $_POST['inpRoom']);
			$inpBuilding = mysqli_real_escape_string($_CON, $_POST['inpBuilding']);

			//CHECK IF DUPLICATED
			$sqlSearch = mysqli_query($_CON,
			"SELECT
			room_name
			FROM
			rooms
			WHERE
			room_id='$_ID'");
			$_row = mysqli_fetch_array($sqlSearch);
			$_GETEIN = $_row['room_name'];
			if($inpRoom == $_GETEIN){
				//UPDATE QUERY
				$sqlUpdate = mysqli_query($_CON,
				"UPDATE
				rooms
				SET
				building_id='$inpBuilding'
				WHERE
				room_id='$_ID'");
				header("location: room.php?upd=true");
				ob_end_clean();
				exit;
			}else{
				//CHECK IF EIN EXIST
				$sqlCheck = mysqli_query($_CON, "SELECT room_name FROM roooms WHERE room_name='$inpRoom'");
				$count = mysqli_num_rows($sqlCheck);
				if($count == 1){
					header("location: room.php?upd=exist");
					ob_end_clean();
					exit;
				}else{
					//UPDATE QUERY
					$sqlUpdate = mysqli_query($_CON,
					"UPDATE
					rooms
					SET
					room_name='$inpRoom',
					building_id='$inpBuilding'
					WHERE
					room_id='$_ID'");
					header("location: room.php?upd=true");
					ob_end_clean();
					exit;
				}
			}
		}
	}
