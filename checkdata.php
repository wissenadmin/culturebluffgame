<?php
	if(!empty($_GET['lat']) && !empty($_GET['long']) ){
		returnData($_GET['lat'],$_GET['long'],$_GET['radius'],$_GET['type']);
	}else{
		$return = array('success'=>0,'error_msg'=>"Please check data.");
		echo json_encode($return);
	}

	function returnData($lat = "",$long="",$radius="",$type_str=""){
		switch ($type_str) {
			case 'monster':				
				$type = "restaurant|hotel|food";
				break;
			case 'shop':				
				$type="school|police|post_office";
				break;
			default:
				$type = "restaurant|hotel|food";
				break;
		}

		$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/xml?location=$lat,$long&radius=$radius&type=$type&key=AIzaSyAzWhjycsPL0YNJPfE5q3YZLc1wFIJy3ck";
		
		$getData = file_get_contents($url);
		print_r($getData);
		
		die();
	}
?>