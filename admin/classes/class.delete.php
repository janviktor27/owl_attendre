<?php	
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
	///////////////////////////////////////////////////////////////////
	//Delete
	//////////////////////////////////////////////////////////////
	function del(){
		global $_CON;
		if(isset($_POST['delete'])){
			$id = $_POST['id'];
			$tbl = $_POST['tbl_name'];
			$row = $_POST['row_name'];
				$insertsql = "DELETE FROM $tbl WHERE $row = $id";
				mysqli_query($_CON, $insertsql);
				header("location: #");
		}
	}
	?>