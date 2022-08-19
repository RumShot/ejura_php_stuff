<?php

$curlattr = curl_init();

curl_setopt_array($curlattr, array(
  CURLOPT_URL => 'https://api.accdistribution.net/v1/GetProduct',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
"request": {
    "LicenseKey": "",
    "Locale": "lt",
    "Currency": "EUR",
    "CompanyId": "_al",
    "ProductId": "'.$pid.'"
}
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json; charset=UTF-8'
  ),
));

$string = curl_exec($curlattr);

//decoding to understandable data
$array = json_decode($string,true);
// creating object of SimpleXMLElement
$xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Attributes></Attributes>');
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

  $parametername = str_replace( array(")", "'", "(", "/"), '', $parametername);
  $parametername = str_replace( ' ', '_', $parametername);
  //$parametername =json_encode($parametername,true);
  $mainnode->addAttribute($parametername, $value.$measureabbr);

  echo $parametername. "  " .$value . " ". $measureabbr. "<br>";

}

$result = $xml_data->asXML('json to xml attribute.xml');







curl_close($curlattr);
