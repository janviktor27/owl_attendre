<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
	function loginUser(){
		if (isset($_POST['btn_login'])){
			require_once('./../connection.php');
			$inpUSER = mysqli_real_escape_string($_CON, $_POST['inpUSER']);
			$password = mysqli_real_escape_string($_CON, $_POST['inpPWD']);
			$pass = md5($password);
			$query = "SELECT  * FROM instructor WHERE ins_ein='$inpUSER' AND ins_pwd='$pass' ";
			$result = mysqli_query($_CON,$query) or die(mysqli_connect_error());
			$count = mysqli_num_rows($result);
			if($count == 1){
				$row = mysqli_fetch_array($result);
				$_ID = $row['ins_id'];
				$_SESSION['ins_id'] = $_ID;
			}else{
				header("location: login.php?credentials=false");
				ob_end_clean();
			}
		}
		///////////
		//Check if Session is Set Then redirects to index?session=true
		if(isset($_SESSION['ins_id'])){
		$_ID = $_SESSION['ins_id'];
		setcookie("ins_id", $_ID, strtotime( '+30 days' ), "/", "", "", TRUE);
		header("location: ./index.php?session=loggedin");
		}
	}