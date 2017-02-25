<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';

    if(!isset($_POST['submit'])){
    	$ein = mysqli_real_escape_string($_CON,$_POST['username']);
    	$status = mysqli_real_escape_string($_CON,$_POST['status']);
      updStats($ein,$status);
    }

    function updStats($ein,$status){
      global $_CON;
    	$query = mysqli_query($_CON,
      "UPDATE
      instructor
      SET
      ins_status='$status'
      WHERE
      ins_ein='$ein'");

    	if($query){
    		echo'Success';
    		exit;
    	}else{
    		echo'failed';
    		exit;
    	}
    }
