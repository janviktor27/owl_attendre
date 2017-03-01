<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
include'./../connection.php';
include'./../globalfunctions.php';
//INITIALIZE COORDINATE POINTS
$mega_x = array(18.18807, 18.18772, 18.18697, 18.18739);
$mega_y = array(120.56729, 120.56704, 120.56847, 120.56869);
$ahs_x = array(18.18838, 18.18814, 18.187, 18.18727);
$ahs_y = array(120.56946, 120.56994, 120.56906, 120.56872);
$science_x = array(18.18737, 18.18704, 18.18667, 18.18707);
$science_y = array(120.57087, 120.57091, 120.56962, 120.56961);
$sc_x = array(18.18704, 18.18665, 18.18557, 18.1859);
$sc_y = array(120.56762, 120.56833, 120.56762, 120.56687);
$finance_x = array(18.18578, 18.18545, 18.18554, 18.18523);
$finance_y = array(120.56679, 120.56667, 120.56759, 120.56748);
$ceat_x = array(18.18725, 18.18675, 18.18693, 18.18721, 18.18716);
$ceat_y = array(120.57092, 120.57092, 120.57206, 120.57201, 120.5715);
//INITIALIZE
$points_polygon =  4;
$points_polygon_ceat =  5;
$location = "";
$classcount = 0;

//////////////////////////////////////////////////////////////////////////////
//GET LOC FUNCTION
  function getLoc($points_polygon, $x, $y, $longitude_x, $latitude_y){
    $c = 0;
    for ($i = 0, $j = $points_polygon - 1; $i < $points_polygon; $j = $i++){
      if((($y[$i] > $latitude_y != ($y[$j] > $latitude_y)) && ($longitude_x < ($x[$j] - $x[$i]) * ($latitude_y - $y[$i]) / ($y[$j] - $y[$i]) + $x[$i]))){
        $c = !$c;
      }
    }//LOOP END
    return $c;
  }
  //POST METHODS SAMPLES
  //SAMPLE AHS
  // $longitude_x = 18.187513;
  // $latitude_y = 120.569206;

  //SAMPLE SC
  // $longitude_x = 18.185859;
  // $latitude_y = 120.567386;

  //SAMPLE MEGA
  // $longitude_x = 18.187629;
  // $latitude_y = 120.567669;

  //SAMPLE FINANCE
  // $longitude_x = 18.185575;
  // $latitude_y = 120.566982;

  //SAMPLE CEAT
  // $longitude_x = 18.187005;
  // $latitude_y = 120.571120;

  //UNIT TESTING VALUES
  // $_POST['username'] = "13-00123";
  // $_POST['status'] = "On Leave";
  // $_POST['lat'] = $longitude_x;
  // $_POST['longi'] = $latitude_y;

  //CHECK POST VALUES !
  if (isset($_POST['username']) && isset($_POST['status']) && isset($_POST['lat']) && isset($_POST['longi'])){
    $longitude_x = $_POST['lat'];
    $latitude_y = $_POST['longi'];
    //START LOCATION FUNCTION
    if(getLoc($points_polygon, $mega_x, $mega_y, $longitude_x, $latitude_y)){$location="Mega";}
    elseif(getLoc($points_polygon, $ahs_x, $ahs_y, $longitude_x, $latitude_y)){$location="AHS";}
    elseif(getLoc($points_polygon, $science_x, $science_y, $longitude_x, $latitude_y)){$location="Science";}
    elseif(getLoc($points_polygon, $sc_x, $sc_y, $longitude_x, $latitude_y)){$location="Students Center";}
    elseif(getLoc($points_polygon, $finance_x, $finance_y, $longitude_x, $latitude_y)){$location="Finance";}
    elseif(getLoc($points_polygon_ceat, $ceat_x, $ceat_y, $longitude_x, $latitude_y)){$location="Ceat";}
    //END LOCATION FUNCTION

    //GET INSTRUCTOR ID
    $ein = $_POST['username'];
    $ins_id = getInsID($ein);
    $status = $_POST['status'];
      $sqlUpdate = mysqli_query($_CON,
      "UPDATE
      instructor
      SET
      ins_status='$status',
      ins_last_loc='$location'
      WHERE
      ins_id='$ins_id'");
      if($sqlUpdate){
        echo "success";
      }else{
        echo "failed";
      }
  }//END MAIN IF

  //GET STUDENT ID
  function getInsID($ein){
    global $_CON;
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    ins_id
    FROM
    instructor
    WHERE
    ins_ein='$ein'");
    if($sqlSearch->num_rows > 0):
      $row = $sqlSearch->fetch_array();
      $ins_id = $row['ins_id'];
      return $ins_id;
    else:
      return false;
    endif;
  }
