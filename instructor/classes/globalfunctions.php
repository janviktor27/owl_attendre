<?php
/* Copyright (C) :JAN VIKTOR ADORA|CHRISTIAN ACE JOHN ASENCION CACOT: - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by JAN VIKTOR ADORA & CHRISTIAN ACE JOHN ASENCION CACOT, FEB 2017
 */
    function getYear(){
      global $_CON;
      $GETYEAR = mysqli_query($_CON,"SELECT * FROM cur_school_yr");
      $_row = mysqli_fetch_array($GETYEAR);
      $year_1 = $_row['year_1'];
      $year_2 = $_row['year_2'];
      $_SY = "$year_1-$year_2";
      return $_SY;
    }

    function RegularSem(){
    	global $_CON;
    	$sqlSearch = mysqli_query($_CON,
    	"SELECT
    	value
    	FROM
    	semester_type
    	WHERE
    	type='Regular' ");
    	$count = mysqli_num_rows($sqlSearch);
    	if($count == 1){
    		$row = mysqli_fetch_array($sqlSearch);
    		$value = $row['value'];
    		return $value;
    	}
    }

    function TriSem(){
    	global $_CON;
    	$sqlSearch = mysqli_query($_CON,
    	"SELECT
    	value
    	FROM
    	semester_type
    	WHERE
    	type='Trisem' ");
    	$count = mysqli_num_rows($sqlSearch);
    	if($count == 1){
    		$row = mysqli_fetch_array($sqlSearch);
    		$value = $row['value'];
    		return $value;
    	}
    }
