
<center>
	<h3> Input your Location </h3>
	<form method="POST">
Username:

					<input type="text" name="username">
						<br>
X:

		<input type="number" step="0.000001" name="N">
			<br>
				<br>
Y:

					<input type="number" step="0.000001" name="E">
						<br>
							<br>
								<input type="submit" name="Submit">
									<br>
<?php
include '../connection.php';

if (isset($_POST['username']) && isset($_POST['qrcodescanned']) && isset($_POST['lat']) && isset($_POST['longi'])){
	$mega_x = array(
		18.18807, 18.18772, 18.18697, 18.18739
	);
	$mega_y = array(
		120.56729, 120.56704, 120.56847, 120.56869
	);
	$ahs_x = array(
		18.18838, 18.18814, 18.187, 18.18727
	);
	$ahs_y = array(
		120.56946, 120.56994, 120.56906, 120.56872
	);
	$science_x = array(
		18.18737, 18.18704, 18.18667, 18.18707
	);
	$science_y = array(
		120.57087, 120.57091, 120.56962, 120.56961
	);
	$sc_x = array(
		18.18704, 18.18665, 18.18557, 18.1859
	);
	$sc_y = array(
		120.56762, 120.56833, 120.56762, 120.56687
	);
	$finance_x = array(
		18.18578, 18.18545, 18.18554, 18.18523
	);
	$finance_y = array(
		120.56679, 120.56667, 120.56759, 120.56748
	);
	$ceat_x = array(
		18.18725, 18.18675, 18.18693, 18.18721, 18.18716
	);
	$ceat_y = array(
		120.57092, 120.57092, 120.57206, 120.57201, 120.5715
	);
	$points_polygon =  4; //count($x); //- 1;
	$points_polygon_ceat =  5; //count($x); //- 1;
	$longitude_x = $_POST["lat"];
	$latitude_y = $_POST["longi"];
	$building = "";

	/////start
	function mega($points_polygon, $mega_x, $mega_y, $longitude_x, $latitude_y){
		$i = $j = $c = 0;
		for ($i = 0, $j = $points_polygon - 1; $i < $points_polygon; $j = $i++){
			if ((($mega_y[$i] > $latitude_y != ($mega_y[$j] > $latitude_y)) && ($longitude_x < ($mega_x[$j] - $mega_x[$i]) * ($latitude_y - $mega_y[$i]) / ($mega_y[$j] - $mega_y[$i]) + $mega_x[$i]))) $c = !$c;
		}
		return $c;
	}
	if (mega($points_polygon, $mega_x, $mega_y, $longitude_x, $latitude_y)){
		$location = "Mega";
	}
	////end

		/////start
	function ahs($points_polygon, $ahs_x, $ahs_y, $longitude_x, $latitude_y)
		{
		$i = $j = $c = 0;
		for ($i = 0, $j = $points_polygon - 1; $i < $points_polygon; $j = $i++)
			{
			if ((($ahs_y[$i] > $latitude_y != ($ahs_y[$j] > $latitude_y)) && ($longitude_x < ($ahs_x[$j] - $ahs_x[$i]) * ($latitude_y - $ahs_y[$i]) / ($ahs_y[$j] - $ahs_y[$i]) + $ahs_x[$i]))) $c = !$c;
			}

		return $c;
		}
	if (ahs($points_polygon, $ahs_x, $ahs_y, $longitude_x, $latitude_y))
		{
		$location = "AHS";
		}
	////end

		/////start
	function science($points_polygon, $science_x, $science_y, $longitude_x, $latitude_y)
		{
		$i = $j = $c = 0;
		for ($i = 0, $j = $points_polygon - 1; $i < $points_polygon; $j = $i++)
			{
			if ((($science_y[$i] > $latitude_y != ($science_y[$j] > $latitude_y)) && ($longitude_x < ($science_x[$j] - $science_x[$i]) * ($latitude_y - $science_y[$i]) / ($science_y[$j] - $science_y[$i]) + $science_x[$i]))) $c = !$c;
			}

		return $c;
		}
	if (science($points_polygon, $science_x, $science_y, $longitude_x, $latitude_y))
		{
		$location = "Science";
		}
	////end

		/////start
	function sc($points_polygon, $sc_x, $sc_y, $longitude_x, $latitude_y)
		{
		$i = $j = $c = 0;
		for ($i = 0, $j = $points_polygon - 1; $i < $points_polygon; $j = $i++)
			{
			if ((($sc_y[$i] > $latitude_y != ($sc_y[$j] > $latitude_y)) && ($longitude_x < ($sc_x[$j] - $sc_x[$i]) * ($latitude_y - $sc_y[$i]) / ($sc_y[$j] - $sc_y[$i]) + $sc_x[$i]))) $c = !$c;
			}

		return $c;
		}
	if (sc($points_polygon, $sc_x, $sc_y, $longitude_x, $latitude_y))
		{
		$location = "Students Center";
		}
	////end

		/////start
	function finance($points_polygon, $finance_x, $finance_y, $longitude_x, $latitude_y)
		{
		$i = $j = $c = 0;
		for ($i = 0, $j = $points_polygon - 1; $i < $points_polygon; $j = $i++)
			{
			if ((($finance_y[$i] > $latitude_y != ($finance_y[$j] > $latitude_y)) && ($longitude_x < ($finance_x[$j] - $finance_x[$i]) * ($latitude_y - $finance_y[$i]) / ($finance_y[$j] - $finance_y[$i]) + $finance_x[$i]))) $c = !$c;
			}

		return $c;
		}
	if (finance($points_polygon, $finance_x, $finance_y, $longitude_x, $latitude_y))
		{
		$location = "Finance";
		}
	////end

		/////start
	function ceat($points_polygon_ceat, $ceat_x, $ceat_y, $longitude_x, $latitude_y)
		{
		$i = $j = $c = 0;
		for ($i = 0, $j = $points_polygon_ceat - 1; $i < $points_polygon_ceat; $j = $i++){
			if ((($ceat_y[$i] > $latitude_y != ($ceat_y[$j] > $latitude_y)) && ($longitude_x < ($ceat_x[$j] - $ceat_x[$i]) * ($latitude_y - $ceat_y[$i]) / ($ceat_y[$j] - $ceat_y[$i]) + $ceat_x[$i]))){
        $c = !$c;
      }
		}

		return $c;
		}
	if (ceat($points_polygon_ceat, $ceat_x, $ceat_y, $longitude_x, $latitude_y))
		{
		$location = "Ceat";
		}
	////end


	echo $location . $longitude_x . ", " . $latitude_y;
	if ($location == null){
		echo "
					<br> Not in School";
					$location = "Not is School";
		}

    $qrcode = $_POST['qrcodescanned'];
    $username = $_POST['username'];

    	$query = "UPDATE student SET student_qr_generated='$qrcode', std_location='$location' WHERE student_cin='$username'";
    	$qwe = mysqli_query($_CON, $query);
    	if (!$qwe){
    		echo'failed';
    		exit;
    	}
    	else{
    		echo 'success';
    		exit;
    	}

	}

?>
