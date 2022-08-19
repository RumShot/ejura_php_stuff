<?php

$curlattr = curl_init();

curl_setopt_array($curlattr, array(
  CURLOPT_URL => 'https://api.elko.cloud/v3.0/api/Catalog/Products/' . $elkocode . '/Description',
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

$responseattr = curl_exec($curlattr);
//$responseattr = json_decode(file_get_contents('attr.json'), true);
$responseattr = json_decode($responseattr, true);
$parrentarray = $responseattr[0];
$description = $parrentarray['description'];
// echo count($description);
$attrmainnode = $xml_attr->addChild("Atribute");

$attrmainnode->addChild('elkoCode', $elkocode);
for ($h = 0; $h <= count($description)-1; $h++){
  $keycriteria = $criteria = $description[$h]['criteria'];
  $value = $description[$h]['value'];
  $measurement = $description[$h]['measurement'];
  echo $h." ". $criteria . " ". $value . " " . $measurement . "<br>";

  $keycriteria = str_replace( array("(", "/", "„","“","\"",",","_","Ø","•","°","’",",","&quot;","%","_%",".","*"), '', $keycriteria);
  $keycriteria = str_replace( array("\\",":","^",")", "'","&#13;","@","360 ", "180 ","+","-","<",">","="), '', $keycriteria);
  $keycriteria = str_replace( '&', 'and', $keycriteria);
  $keycriteria = str_replace( '0', 'zero', $keycriteria);
  $keycriteria = str_replace( '1', 'one', $keycriteria);
  $keycriteria = str_replace( '2', 'two', $keycriteria);
  $keycriteria = str_replace( '3', 'three', $keycriteria);
  $keycriteria = str_replace( '4', 'four', $keycriteria);
  $keycriteria = str_replace( '5', 'five', $keycriteria);
  $keycriteria = str_replace( '6', 'six', $keycriteria);
  $keycriteria = str_replace( '7', 'seven', $keycriteria);
  $keycriteria = str_replace( '8', 'eight', $keycriteria);
  $keycriteria = str_replace( '9', 'nine', $keycriteria);
  $keycriteria = str_replace( ' ', '_', $keycriteria);
  $keycriteria = preg_replace('/\d/', '', $keycriteria );
  $keycriteria = str_replace( array("&","&amp;"), 'and', $keycriteria);
  $criteria = str_replace( array("&#13;",")", "'", "(", "/", "„","“","”","\"",",","_","Ø","•","°","’","&quot;","","*","@"), '', $criteria);
  $criteria = str_replace( array("","&","&amp;", " &" ,"& "), 'and', $criteria);
  $criteria = str_replace(';', ' ', $criteria);
  $criteria = str_replace('¼', 'quarter', $criteria);
  $criteria = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $criteria);
  $criteria = str_replace('/[^A-Za-z0-9\-]/', '', $criteria);
  // $criteria = preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $criteria);

  $attrmainnode->addChild($keycriteria,htmlspecialchars($criteria) .": ".json_decode($value)." ".$measurement);
  usleep(50000);
}

include('elko downloader images.php');
//var_dump($description);
//echo $responseattr;
// $seckey = [];
// $pi = 1;
// foreach($attrmainnode as $key => $value){
//   $count = count($keycriteria->$key);
//   if($count == 2 or $count == 3 or $count == 4 or $count == 5 or $count == 6 or $count == 7 or $count == 8 ){
//     array_push($seckey, $key);
//     $attrmainnode->addChild($key."_".$pi,$value);
//     $pi += 1;
//   }
// }
curl_close($curlattr);
 ?>
