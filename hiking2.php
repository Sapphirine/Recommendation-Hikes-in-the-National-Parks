<?php
if (!empty($_GET['location'])){

  //Access Google Maps API 
  $maps_url = 'https://'.
  'maps.googleapis.com/'.
  'maps/api/geocode/json'.
  '?address=' . urlencode($_GET['location']);
  $maps_json = file_get_contents($maps_url);
  $maps_array = json_decode($maps_json, true);
  $lat = $maps_array['results'][0]['geometry']['location']['lat'];
  $lng = $maps_array['results'][0]['geometry']['location']['lng'];

  //Instagram API request 	
  $instagramtag_url='https://api.instagram.com/v1/tags/nationalpark/media/recent?client_id=d49da08a520f47cbb6e7618f077f33ef&count=99';//tag national parks' images
  $instagramtag_json = file_get_contents($instagramtag_url);
  $instagram_array = json_decode($instagramtag_json, true);
  $lat_plus = $lat+ 0.34;//200miles radius
  $lat_minus = $lat -0.34;
  $lng_plus = $lng +2.62;
  $lng_minus = $lng -2.62; 

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Hiking</title>
  </head>
  <body>
  
  <form action="/hiking2.php" method="get">
    <input type="text" name="location"/>
    <button type="submit">Enter a location</button>
	<h1>Popular National Parks</h1> 	
  </form>
  <form action="temp.php" method="post">
    <input type="text" name="parktrails"/>
    <button type="submit">Find Recommended Trails</button>
  </form>		

    <br/>
    <?php
					
    if(!empty($instagram_array)){
		//print 'Latitude'. $lat .'<br>';
		//print 'Longitude'. $lng . '<br>';
		//Pagination Starts here
		$counter =1;
		$nextpage_url = $instagram_array['pagination']['next_url'];
		$max = 0;
		do {
			
			$nextpage_json = file_get_contents($nextpage_url);
			$nextpage_array = json_decode($nextpage_json, true);
						
			foreach($nextpage_array['data'] as $item){
				
			$image_link = $item['images']['low_resolution']['url'];
			$locationlink = $item['location']['name'];
			$userlink = $item['user']['username'];
			$datetime = $item['created_time'];
			$commentcount = $item['comments']['count'];
			$likecounts = $item['likes']['count'];
			$location_lat = $item['location']['latitude'];
			$location_lng = $item['location']['longitude'];
			

			if($location_lat >= $lat_minus && $location_lat <= $lat_plus && $location_lng >= $lng_minus && $location_lng <= $lng_plus && $likecounts >= $max)
			{
				
				$max = $likecounts;
				$newimage_link = $image_link; 
				$newlocationlink = $locationlink; 
				$newuserlink  = $userlink; 
				$newdatetime = $datetime; 
				$newcommentcount = $commentcount; 
				$newlikecounts = $likecounts; 
				$newlocation_lat = $location_lat; 
				$newlocation_lng = $location_lng; 
	
			}
			else{

			
			}
			
			}
			
			$nextpage_url = $nextpage_array['pagination']['next_url'];
			$counter++;
			
		
		} while ($counter <=30);//while ($instagram_array['pagination'] !== " ");//while ($counter <=5);
				
		foreach($instagram_array['data'] as $item){
			
		$image_link = $item['images']['thumbnail']['url'];
        $locationlink = $item['location']['name'];
		$userlink = $item['user']['username'];
		$datetime = $item['created_time'];
		$commentcount = $item['comments']['count'];
		$likecounts = $item['likes']['count'];
		$location_lat = $item['location']['latitude'];
		$location_lng = $item['location']['longitude'];
		if($location_lat >= $lat_minus && $location_lat <= $lat_plus && $location_lng >= $lng_minus && $location_lng <= $lng_plus && $likecounts >$max)
		{
			$max = $likecounts;
			$newimage_link = $image_link; 
			$newlocationlink = $locationlink; 
			$newuserlink  = $userlink; 
			$newdatetime = $datetime; 
			$newcommentcount = $commentcount; 
			$newlikecounts = $likecounts; 
			$newlocation_lat = $location_lat; 
			$newlocation_lng = $location_lng;
			//print ('This is new ' . $max .' likes ') . '<br>';	
		}
		else{

		}
			
		}
		
		//print ('There are ' . $max .' likes ') . '<br>';
		echo '<li style="display: inline-block; padding: 25px"><a href="' . 
		$newimage_link  . '"><img src="' . $newimage_link . '" /></a> <br/>';
		//echo 'By: <em>' . $userlink . '</em> <br/>';
		echo 'At: <em>' . $newlocationlink . '</em> <br/>';
		echo 'Date: ' . date ('d M Y h:i:s', $newdatetime) . '<br/>';
		echo 'Latitude: <em>' . $newlocation_lat. " , " . 'Longitude: <em>' . $newlocation_lng . '</em> <br/>';
		echo $newcommentcount . ' comment(s). ' . $newlikecounts . ' likes. </li>';
	
		
    }
	
    ?>
  </body>
</html>