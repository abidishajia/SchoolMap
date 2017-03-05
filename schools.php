<?php

$supervisor_district= $_GET["supervisor_district"];
$grade_range= $_GET["grade_range"];
$ccsf_entity= $_GET["ccsf_entity"];

include "phpsoda-1.0.0.phar";

use allejo\Socrata\SodaClient;
use allejo\Socrata\SodaDataset;
use allejo\Socrata\SoqlQuery;

$dc 		= new SodaClient("data.sfgov.org",$token="a2SZ8o7e8bGuVmJoCkl24nwyw");
$fs 		= new SodaDataset($dc,"mmsr-vumy");


$Query 		= new SoqlQuery();
$Query		->select("campus_name","grade_range","supervisor_district","ccsf_entity","campus_address", "location_1")
			->where ("supervisor_district = '". $supervisor_district . "'");		
$results = $fs->getDataset($Query);

$sqlQuery 	= new SoqlQuery();
$sqlQuery	->select("campus_name","grade_range","supervisor_district","ccsf_entity","campus_address", "location_1")
			->where ("grade_range = '". $grade_range . "'");			
$cases = $fs->getDataset($sqlQuery);

$EQuery 	= new SoqlQuery();
$EQuery	    ->select("campus_name","grade_range","supervisor_district","ccsf_entity","campus_address", "location_1")
			->where ("ccsf_entity = '". $ccsf_entity . "'");			
$answers = $fs->getDataset($EQuery);

?>


<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Schools in San Francisco</title>
	
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>
	
    
	<style>
		
		h1 {
			color: #99556d;
			font-size: 45px;
			font-family: Impact;
		}
		body {
			background-color: black;
		}
		
	</style>
  </head>
  <body>
  
	<div class="container">
	<div class="row">  
	
	 <div class="col-sm-12">
  
   <h1> San Francisco School Map</h1>
   

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
    
    <?php
	//echo '<pre>';
     //var_dump($results);
	//	echo '</pre>';
	?>
	
	<?php
    
	//  echo '<pre>';
	 // var_dump($cases) ;
	 // echo '</pre>';

	?>
	
	<?php
	//echo '<pre>';
   //  var_dump($answers);
	//echo '</pre>';
	?>
	
	<div id="mapid" style = "height:1000px;width:100%; "></div>
	
	<script>
	var mymap = L.map('mapid').setView([37.7749, -122.4194], 13);
		
	L.tileLayer('http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, Tiles courtesy of <a href="http://hot.openstreetmap.org/" target="_blank">Humanitarian OpenStreetMap Team</a>'
}).addTo(mymap);


	
	 <?php
			
			foreach ($answers as $answer)

			{
					echo ("var marker" . $i . "= L.marker([" .  $answer["location_1"]["coordinates"][1] . "," . $answer["location_1"]["coordinates"][0] .  "]).addTo(mymap);\n\rmarker" . $i . ".bindPopup(\"'" . $answer["campus_name"] . $answer["campus_address"]. "'\");\n\r");
					
					$i++;
			}
			$i = 0; 

			foreach ($cases as $case)

			{
					echo ("var marker" . $i . "= L.marker([" .  $case["location_1"]["coordinates"][1] . "," . $case["location_1"]["coordinates"][0] .  "]).addTo(mymap);\n\rmarker" . $i . ".bindPopup(\"'" . $case["campus_name"] . $case["campus_address"]. "'\");\n\r");
					
					$i++;
			}
		$i = 0; // Why does it work like this but not if I put results before cases?

			foreach ($results as $result)

			{
					echo ("var marker" . $i . "= L.marker([" .  $result["location_1"]["coordinates"][1] . "," . $result["location_1"]["coordinates"][0] .  "]).addTo(mymap);\n\rmarker" . $i . ".bindPopup(\"'" . $result["campus_name"] . $result["campus_address"]. "'\");\n\r");
					
					$i++;
			}
			
			

			?>
			
		
			
</script>
	
					
	
	</div><!-- col-sm-8 -->
	
  
	</div><!--row -->
	
	</div><!--container-->
	
  </body>
</html>
