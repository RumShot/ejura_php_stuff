<?php
//file change to POST data
$string = file_get_contents("attribute.json");
//decoding to understandable data
$array = json_decode($string,true);
// creating object of SimpleXMLElement
$xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Attributes xmlns:sql="urn:schemas-microsoft-com:xml-sql"></Attributes>');
//for every product in json-data

$mainnode = $xml_data->addChild("Atribute");

$product = $array['Product'];
$pid = $product['PID'];
$mainnode->addAttribute('PID', $pid);
$mpn = $product['MPN'];
$mainnode->addAttribute('MPN', $mpn);

echo $pid." ".$mpn;
//images
for ($y = 0; $y <= count($product['Medias'])-1; $y++){
  $imgurl = json_encode($product['Medias'][$y],true);
  $imgurls =json_decode($imgurl,true);
  $imgage = $imgurls['OriginalUri'];
  $mainnode->addAttribute('ImgURL_'.$y, $imgage);

  echo "<br>". $y.$imgage . "<br>";
}
//Parameters
for ($x = 0; $x <= count($product['Parameters'])-1; $x++){
  $para = json_encode($product['Parameters'][$x],true);
  $parameter =json_decode($para,true);
  $parametername = $parameter['ParameterName'];

  $value = $parameter['Value'];
  $measureabbr = $parameter['MeasureAbbr'];
  // trim($parametername, "(");
  // trim($parametername, ")");
  $indesc = $parameter['UseInDescription'];

  $parametername = str_replace( array(")", "'", "(", "/"), '', $parametername);
  $parameterfixname = str_replace( ' ', '_', $parametername);
  //$parametername =json_encode($parametername,true);
  //$mainnode->addAttribute($parameterfixname, $value.$measureabbr);
  if($indesc != null){
    $mainnode->addAttribute($parameterfixname, $value.$measureabbr);
    echo "yra";
    echo $indesc;
  }
  echo $parametername. "  " .$value . " ". $measureabbr. "<br>";
$result = $xml_data->asXML('attribute.xml');
}



?>
