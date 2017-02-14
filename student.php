<?php include'includes/header.php'; ?>
<?php include'connection.php'; ?>
<?php include'classes/class.login.php'; ?>
<body>
<section id="container" >
<br><br>
	<form method='post' class="form-horizontal" action="" role="form">
	<div class="form-group">
		<label for="username" class="col-md-4 control-label">CIN: </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="cin" placeholder="CIN">
      </div>
	</div>	<div class="form-group">
		<label for="username" class="col-md-4 control-label">QR Code Text Scanned: </label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="qr" placeholder="QR Code Text">
      </div>
	</div>
	<div class="form-group">
		<label for="password" class="col-md-4 control-label">N: </label>
      <div class="col-sm-5">
<input type="number" step="0.000001" name="N" class="form-control" placeholder="18.xxxxxxx">
      </div>
	</div>	<div class="form-group">
		<label for="password" class="col-md-4 control-label">E </label>
      <div class="col-sm-5">
<input type="number" step="0.000001" name="E" class="form-control" placeholder="120.xxxxxxx">
      </div>
	</div>
			<div class="col-md-offset-4 col-md-1">
				<input type="submit" class="btn btn-default" name="submit" value="Submit">
			</div>
			
			<?php		
	global $_CON;
	if(isset($_POST['submit']))
	{

			$mega_x = array(18.18794,  18.18731, 18.18714, 18.18775);   
			$mega_y = array(120.56733, 120.56849,120.5684,120.56722);
			$pres_x = array(18.18807,  18.18794, 18.18724, 18.18739);   
			$pres_y = array(120.56703, 120.56733,120.56693,120.5667);
			$mifo_x = array(18.18733,  18.187, 18.18686, 18.18724);   
			$mifo_y = array(120.56699, 120.5676,120.56751,120.56693);
			$pool_x = array(18.18775, 18.18743, 18.187, 18.18733);   
			$pool_y = array(120.56722, 120.56787,120.5676,120.56699);
			$sl_x = array (18.18743,18.18714,18.1867,18.187);
			$sl_y = array (120.56787,120.5684,120.56813,120.5676);
			$sc_x = array(18.186203, 18.186846,18.186706,18.186071); 
			$sc_y = array(120.567377, 120.567768,120.568006,120.567628);
			$pres_x = array(18.188069, 18.187948, 18.187387, 18.187507);
			$pres_y = array(120.567046, 120.567308, 120.567010, 120.566807);
			$points_polygon = count($mega_x); //- 1; 
					$cin = $_POST['cin'];
		$qr =$_POST['qr'];
			$longitude_x = $_POST["N"];
			$latitude_y = $_POST["E"];
			$location = null;
			
				function mega($points_polygon, $mega_x, $mega_y, $longitude_x, $latitude_y)
				{
				  $i = $j = $c = 0;
				  for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
					if ( (($mega_y[$i] > $latitude_y != ($mega_y[$j] > $latitude_y)) &&
					($longitude_x < ($mega_x[$j] - $mega_x[$i]) * ($latitude_y - $mega_y[$i]) / ($mega_y[$j] - $mega_y[$i]) + $mega_x[$i]) ) ) 
					   $c = !$c;
				  }
				  return $c;
				}
						
				function pool($points_polygon, $pool_x, $pool_y, $longitude_x, $latitude_y)
				{
				  $i = $j = $c = 0;
				  for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
					if ( (($pool_y[$i] > $latitude_y != ($pool_y[$j] > $latitude_y)) &&
					($longitude_x < ($pool_x[$j] - $pool_x[$i]) * ($latitude_y - $pool_y[$i]) / ($pool_y[$j] - $pool_y[$i]) + $pool_x[$i]) ) ) 
					   $c = !$c;
				  }
				  return $c;
				}
						
				function sl($points_polygon, $sl_x, $sl_y, $longitude_x, $latitude_y)
				{
				  $i = $j = $c = 0;
				  for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
					if ( (($sl_y[$i] > $latitude_y != ($sl_y[$j] > $latitude_y)) &&
					($longitude_x < ($sl_x[$j] - $sl_x[$i]) * ($latitude_y - $sl_y[$i]) / ($sl_y[$j] - $sl_y[$i]) + $sl_x[$i]) ) ) 
					   $c = !$c;
				  }
				  return $c;
				}
						
				function mifo($points_polygon, $mifo_x, $mifo_y, $longitude_x, $latitude_y)
				{
				  $i = $j = $c = 0;
				  for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
					if ( (($mifo_y[$i] > $latitude_y != ($mifo_y[$j] > $latitude_y)) &&
					($longitude_x < ($mifo_x[$j] - $mifo_x[$i]) * ($latitude_y - $mifo_y[$i]) / ($mifo_y[$j] - $mifo_y[$i]) + $mifo_x[$i]) ) ) 
					   $c = !$c;
				  }
				  return $c;
				}


				function sc($points_polygon, $sc_x, $sc_y, $longitude_x, $latitude_y)
				{
				  $i = $j = $c = 0;
				  for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
					if ( (($sc_y[$i] > $latitude_y != ($sc_y[$j] > $latitude_y)) &&
					($longitude_x < ($sc_x[$j] - $sc_x[$i]) * ($latitude_y - $sc_y[$i]) / ($sc_y[$j] - $sc_y[$i]) + $sc_x[$i]) ) ) 
						$c = !$c;
				  }
				  return $c;
				}

				function pres($points_polygon, $pres_x, $pres_y, $longitude_x, $latitude_y)
				{
				  $i = $j = $c = 0;
				  for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
					if ( (($pres_y[$i] > $latitude_y != ($pres_y[$j] > $latitude_y)) &&
					($longitude_x < ($pres_x[$j] - $pres_x[$i]) * ($latitude_y - $pres_y[$i]) / ($pres_y[$j] - $pres_y[$i]) + $pres_x[$i]) ) ) 
						$c = !$c;
				  }
				  return $c;
				}
						
				//echo's        
				if (mega($points_polygon, $mega_x, $mega_y, $longitude_x, $latitude_y)){
				  $location = "Mega";
				}
						
				 if (sc($points_polygon, $sc_x, $sc_y, $longitude_x, $latitude_y)){
				  $location = "SC";
				}
						
				 if (pool($points_polygon, $pool_x, $pool_y, $longitude_x, $latitude_y)){
				  $location = "Pool";
				}
						
				 if (sl($points_polygon, $sl_x, $sl_y, $longitude_x, $latitude_y)){
				 $location = "SL";}

				 if (pres($points_polygon, $pres_x, $pres_y, $longitude_x, $latitude_y)){
				  $location = "President's house";
				}
					echo "$location <br>
						$longitude_x .", ". $latitude_y";
					if ($location == null)
					{echo "<br> Not in School";
					}
						}
						
			

?>
			
</form>
</section>
<?php include'includes/footer.php'; ?>