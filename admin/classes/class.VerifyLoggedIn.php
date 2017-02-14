<?php 
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
///////////////////////////////////////////////////////////////////////////////////
//Authentication
///////////////////////////////////////////////////////////////////////////////////
	function onlineChecker(){
		if (!isset($_SESSION['admin_id'])){
			header("location: login.php?session=false");
			ob_end_clean();
		}		
	}	
