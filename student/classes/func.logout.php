<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
	function logout(){
		if(isset($_GET['out'])){
			$_SESSION = array();
			if(isset($_COOKIE["student_id"])) {
				setcookie("student_id", '', strtotime( '-5 days' ), '/');
			}
			session_destroy();
			header("location: login.php?session=ended");
		}
	}