<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';

    if(isset($_POST['etUsername']) && isset($_POST['etPassword'])){
      $cin = mysqli_real_escape_string($_CON,$_POST['etUsername']);
      $password = mysqli_real_escape_string($_CON,$_POST['etPassword']);
      $pw = md5($password);
      login($cin,$pw);
    }

    function login($cin,$password){
      global $_CON;

   	  $result = mysqli_query($_CON,
      "SELECT
       std_id
       FROM
       student
       WHERE
       student_cin='$cin'
       AND
       std_pwd='$password'");

    	if($result -> num_rows > 0){
    		echo'success';
    		exit;
    	}
    	else{
    		echo'failed';
    		exit;
    	}
    }
