<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
    // $_POST['cin'] = '13-00857';
    // $_POST['etOldpass'] = '654321';
    // $_POST['etNewPass'] = '123456';
    // $_POST['etConfirmPass'] = '123456';
    if(isset($_POST['cin']) && isset($_POST['etOldpass']) && isset($_POST['etNewPass']) && isset($_POST['etConfirmPass'])){
      $cin = mysqli_real_escape_string($_CON,$_POST['cin']);
      $etOldpass = mysqli_real_escape_string($_CON,$_POST['etOldpass']);
      $etNewPass = mysqli_real_escape_string($_CON,$_POST['etNewPass']);
      $etConfirmPass = mysqli_real_escape_string($_CON,$_POST['etConfirmPass']);
      changePW($cin,$etOldpass,$etNewPass,$etConfirmPass);
    }

    function changePW($cin,$inpOldPass,$inpNewPass,$inpConfirm){
      global $_CON;
      if($inpNewPass == $inpConfirm){
        $result = mysqli_query($_CON,
        "SELECT
         std_pwd
         FROM
         student
         WHERE
         student_cin='$cin' ");
         $row = $result->fetch_array();
         $oldpassword = $row['std_pwd'];
         if($oldpassword == md5($inpOldPass)){
           $inpNewPass = md5($inpNewPass);
           $sqlUpdate = mysqli_query($_CON,
           "UPDATE
           student
           SET
           std_pwd='$inpNewPass'
           WHERE
           student_cin='$cin'");
           echo'success';
           exit;
         }else{
           echo'failed';
       	   exit;
         }
      }else{
        echo'failed';
    		exit;
      }
    }
