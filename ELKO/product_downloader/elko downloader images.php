<?php

$curlimg = curl_init();
//
// $elkocode = 1236611;
// $barear = file_get_contents("barear.txt", "r");
//
curl_setopt_array($curlimg, array(
  CURLOPT_URL => 'https://api.elko.cloud/v3.0/api/Catalog/MediaItems/' . $elkocode,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: ' . $barear . ''
  ),
));

$imgresponse = curl_exec($curlimg);
$imgresponse = json_decode($imgresponse, true);
if ($imgresponse != null or $imgresponse != []){
  $imgarray = $imgresponse[0];
  //var_dump($imgarray);
  $media = $imgarray['mediaFiles'];
  for ($img = 0; $img <= count($media)-1; $img++){
    $link = $media[$img]['link'];
    $sequence = $media[$img]['sequence'];
    //echo $sequence." " . $link."<br>";
    $attrmainnode->addChild("imgurl_".$img,$link);
  }
}else{
  echo "No img";
}

curl_close($curlimg);
 ?>
