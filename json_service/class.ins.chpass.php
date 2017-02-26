<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';

    if(isset($_POST['ein']) && isset($_POST['etOldpass']) && isset($_POST['etNewPass']) && isset($_POST['etConfirmPass'])){
      $ein = mysqli_real_escape_string($_CON,$_POST['ein']);
      $etOldpass = mysqli_real_escape_string($_CON,$_POST['etOldpass']);
      $etNewPass = mysqli_real_escape_string($_CON,$_POST['etNewPass']);
      $etConfirmPass = mysqli_real_escape_string($_CON,$_POST['etConfirmPass']);
      changePW($ein,$etOldpass,$etNewPass,$etConfirmPass);
    }

    function changePW($ein,$inpOldPass,$inpNewPass,$inpConfirm){
      global $_CON;
      if($inpNewPass == $inpConfirm){
        $result = mysqli_query($_CON,
        "SELECT
         ins_pwd
         FROM
         instructor
         WHERE
         ins_ein='$ein' ");
         $row = $result->fetch_array();
         $oldpassword = $row['ins_pwd'];
         if($oldpassword == md5($inpOldPass)){
           $inpNewPass = md5($inpNewPass);
           $sqlUpdate = mysqli_query($_CON,
           "UPDATE
           instructor
           SET
           ins_pwd='$inpNewPass'
           WHERE
           ins_ein='$ein'");
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
