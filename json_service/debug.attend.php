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
//$_DAYTODAY = date("D");
// $_TIMENOW = date("h:i:s");


//DATE TIME SPOOF
$_DAYTODAY = "Thu";
$_FAKETIME = new DateTime("4:14 pm");
$_TIMENOW = $_FAKETIME->format('h:i:s');
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
  $longitude_x = 18.187629;
  $latitude_y = 120.567669;

  //SAMPLE FINANCE
  // $longitude_x = 18.185575;
  // $latitude_y = 120.566982;

  //SAMPLE CEAT
  // $longitude_x = 18.187005;
  // $latitude_y = 120.571120;

  //UNIT TESTING VALUES
  $_POST['username'] = "13-00857";
  $_POST['qrcodescanned'] = "AA 204-Mega";
  $_POST['lat'] = $longitude_x;
  $_POST['longi'] = $latitude_y;

  //CHECK POST VALUES !
  if (isset($_POST['username']) && isset($_POST['qrcodescanned']) && isset($_POST['lat']) && isset($_POST['longi'])){
    //START LOCATION FUNCTION
    if(getLoc($points_polygon, $mega_x, $mega_y, $longitude_x, $latitude_y)){echo "User Location: Mega"; $location="Mega";}
    elseif(getLoc($points_polygon, $ahs_x, $ahs_y, $longitude_x, $latitude_y)){echo "User Location: AHS"; $location="AHS";}
    elseif(getLoc($points_polygon, $science_x, $science_y, $longitude_x, $latitude_y)){echo "User Location: Science"; $location="Science";}
    elseif(getLoc($points_polygon, $sc_x, $sc_y, $longitude_x, $latitude_y)){echo "User Location: Students Center"; $location="Students Center";}
    elseif(getLoc($points_polygon, $finance_x, $finance_y, $longitude_x, $latitude_y)){echo "User Location: Finance"; $location="Finance";}
    elseif(getLoc($points_polygon_ceat, $ceat_x, $ceat_y, $longitude_x, $latitude_y)){echo "User Location: Ceat"; $location="Ceat";}
    //END LOCATION FUNCTION

    //GET STUDENT_ID
    $cin = $_POST['username'];
    $stud_id = getStudID($cin);
    echo "<br/ >stud_id: $stud_id";
    //GET ROOM ID
    $room = $_POST['qrcodescanned'];
    if(substr_count($room,'-')){//CHECK IF STRING HAS HYPENS
      $room_ex = explode("-",$room);
      $room_name = $room_ex[0];
      $building_name = $room_ex[1];
      $building_id = getBuildingID($building_name);
      $room_id = getRoomID($room_name,$building_id);
      echo "<br />building_name: $building_name";
      echo "<br />room_id: $room_id";
    }else{//DELETE THIS IF NO RETURNS
      echo "<br />Please scan room a QRCODE!";
    }//END ROOM IF
    if($building_name == $location)://CHECK IF USER LOCATION IS EQUAL TO BUILDING NAME
    //GET ALL SCHEDULE
    $sched_ids = getSchedIDS($stud_id);
      foreach($sched_ids as $sched_id){
        $sched_infos = getSchedInfo($sched_id);
        $sched_days = $sched_infos[0];
        $sched_start_time = new DateTime($sched_infos[1]);
        $sched_end_time = new DateTime($sched_infos[2]);
        $ins_id = $sched_infos[3];
        $subject_id = $sched_infos[4];
        $class_room_id = $sched_infos[5];
        $semester = $sched_infos[6];
        $_SY = $sched_infos[7];
        //FORMAT TIME
        $start_time = $sched_start_time->format('h:i:s');
        $end_time = $sched_end_time->format('h:i:s');
        if($class_room_id == $room_id){
          //IF (DAY TODAY) EXIST ON SCHED DAYLIST
          if(strpos($sched_days,$_DAYTODAY) !== false){
            //CHECK IF TIME NOW IS IN BETWEEN START TIME AND END TIME
            if($_TIMENOW >= $start_time && $_TIMENOW <= $end_time){
              $FINAL_SCHED_ID = $sched_id;
              $FINAL_SUBJECT_ID = $subject_id;
              $FINAL_STUD_ID = $stud_id;
              $FINAL_INS_ID = $ins_id;
              $FINAL_ROOM_ID = $class_room_id;
              $FINAL_SEMESTER = $semester;
              $FINAL_SY = $_SY;
              $classcount +=1;
            }//END CHECK TIME
          }//END DAY CHECK
        }//END ROOM ID CHECK
      }//END MAIN LOOP
      if($classcount == 1){//HAS VERIFIED ALL
         echo "<br /><br /> success";
         echo "<br /> semester: $FINAL_SEMESTER";
         echo "<br /> school_year: $FINAL_SY";
         echo "<br /> STUD_ID: $FINAL_STUD_ID";
         echo "<br /> sched_id: $FINAL_SCHED_ID";
         echo "<br /> INS ID: $FINAL_INS_ID";
         echo "<br />subject_id: $FINAL_SUBJECT_ID";
         echo "<br />class room id: $FINAL_ROOM_ID";
        //  echo "<br />START TIME: $start_time";
        //  echo "<br />END TIME: $end_time";
        //  echo "<br />TIME NOW: $_TIMENOW";
         echo "<br />DATE TIME NOW: $_NOW";

      }else{
        echo "<br />You don't have any class today at this time in this room.";
      }

    else:
      echo "<br/ >Not in proper location!";
    endif;//END LOCATION CHECKING
  }//END MAIN IF

  //GETSCHEDULE INFORMATION
  function getSchedInfo($sched_id){
    global $_CON;
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    subject_id,
    ins_id,
    room_id,
    semester,
    school_year,
    days,
    start_time,
    end_time
    FROM
    sched_table
    WHERE
    sched_id='$sched_id'");
    $row = $sqlSearch->fetch_array();
    $subject_id = $row['subject_id'];
    $semester = $row['semester'];
    $_SY = $row['school_year'];
    $ins_id = $row['ins_id'];
    $room_id = $row['room_id'];
    $sched_days = $row['days'];//FETCH DAYS OF THE SPECIFIC SCHEDULE
    $sched_start_time = $row['start_time'];
    $sched_end_time = $row['end_time'];
    return array ($sched_days,$sched_start_time,$sched_end_time,$ins_id,$subject_id,$room_id,$semester,$_SY);
  }
  //GET BUILDING ID
  function getBuildingID($building_name){
    global $_CON;
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    building_id
    FROM
    building
    WHERE
    building_name='$building_name' ");
    if($sqlSearch->num_rows == 1):
      $row = $sqlSearch->fetch_array();
      $building_id = $row['building_id'];
      return $building_id;
    else:
        return false;
    endif;
  }
  //GET ROOM ID
  function getRoomID($room_name,$building_id){
    global $_CON;
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    room_id
    FROM
    rooms
    WHERE
    room_name='$room_name'
    AND
    building_id='$building_id' ");
    if($sqlSearch->num_rows > 0):
      $row = $sqlSearch->fetch_array();
      $room_id = $row['room_id'];
      return $room_id;
    else:
      return false;
    endif;
  }
  //GET STUDENT ID
  function getStudID($cin){
    global $_CON;
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    std_id
    FROM
    student
    WHERE
    student_cin='$cin'");
    if($sqlSearch->num_rows > 0):
      $row = $sqlSearch->fetch_array();
      $stud_id = $row['std_id'];
      return $stud_id;
    else:
      return false;
    endif;
  }
  //GET SCHED ID'S
  function getSchedIDS($stud_id){
    global $_CON;
    $sqlSearch = mysqli_query($_CON,
    "SELECT
    sched_id
    FROM
    class_table
    WHERE
    std_id='$stud_id'");
    if($sqlSearch->num_rows > 0):
      $sched_ids = array();
      while($row = $sqlSearch->fetch_array()):
        $sched_ids[] = $row['sched_id'];
      endwhile;//END MAIN LOOP
      return $sched_ids;
    else:
      return false;
    endif;
  }
