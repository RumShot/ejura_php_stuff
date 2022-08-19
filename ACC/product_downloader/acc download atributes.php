<?php
$curlattr = curl_init();
$file = 'item.xml';
//Curl request

$xml_attr = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Attributes></Attributes>');

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
    "LicenseKey": "'.$apikey.'",
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
//var_dump($string);
//decoding to understandable data
$attrarray = json_decode($string,true);

$attrmainnode = $xml_attr->addChild("Attribute");
$product = $attrarray['Product'];
$prodid = $product['PID'];
$attrmpn = $product['MPN'];
//Parameters
for ($h = 0; $h <= count($product['Parameters'])-1; $h++){
  $para = json_encode($product['Parameters'][$h],true);
  $parameter =json_decode($para,true);
  $parametername = $paramvalue = $parameter['ParameterName'];
  $value = $parameter['Value'];
  $measureabbr = $parameter['MeasureAbbr'];
  // replacing @keys, @values to correct xml
  $parametername = str_replace( array(")", "'", "(", "/", "„","“","\"",",","_","Ø","•","°","’",",","&quot;","%","_%",".","*"), '', $parametername);
  $parametername = str_replace( array("&#13;","&quot;","&amp;","&lt;","&gt;","@","360 ", "180 ","+","-","<",">","="), '', $parametername);
  $parametername = str_replace( '0 ', 'zero', $parametername);
  $parametername = str_replace( '1 ', 'one', $parametername);
  $parametername = str_replace( '2 ', 'two', $parametername);
  $parametername = str_replace( '3 ', 'three', $parametername);
  $parametername = str_replace( '4 ', 'four', $parametername);
  $parametername = str_replace( '5 ', 'five', $parametername);
  $parametername = str_replace( '6 ', 'six', $parametername);
  $parametername = str_replace( '7 ', 'seven', $parametername);
  $parametername = str_replace( '8 ', 'eight', $parametername);
  $parametername = str_replace( '9 ', 'nine', $parametername);
  $parametername = str_replace( ' ', '_', $parametername);
  $parametername = preg_replace('/\d/', '', $parametername );
  $parametername = str_replace( array("&","&amp;"), 'and', $parametername);
  $paramvalue = str_replace( array("&quot;","&amp;","&lt;","&gt;",")", "'", "(", "/", "„","“","”","\"",",","_","Ø","•","°","’","&quot;","","*","@"), '', $paramvalue);
  $paramvalue = str_replace( array("&","&amp;", " &" ,"& "), 'and', $paramvalue);
  $paramvalue = str_replace(';', ' ', $paramvalue);
  $paramvalue = str_replace('¼', 'quarter', $paramvalue);
  $paramvalue = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $paramvalue);
  $value = str_replace( array("&#13;","&amp;","&lt;","&gt;",")", "'", "(", "/", "„","“","\"",",","_","Ø","•","°","’","&quot;","&#x001e;"), '', $value);
  $value = str_replace( array("&","&amp;", " &" ,"& ","&gt;"), 'and', $value);
  $value = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value);

  $addedattribute = $attrmainnode->addChild($parametername,htmlspecialchars($paramvalue) .": ".htmlspecialchars($value)." ".$measureabbr);

  //echo $parametername. "  " .$value . " ". $measureabbr. "<br>";
}
//images
for ($f = 0; $f <= count($product['Medias'])-1; $f++){
  $imgurl = json_encode($product['Medias'][$f],true);
  $imgurls =json_decode($imgurl,true);
  $imgage = $imgurls['OriginalUri'];
  if($imgage != null){
      $attrmainnode->addChild('ImgURL_'.$f, $imgage);
  }
}
$attrmpn = str_replace( array("&","&amp;"), 'and', $attrmpn);
$attrmainnode->addChild('MPN', $attrmpn);
//$attrmainnode->addChild('PID', $prodid);
//echo " PID ".$prodid." ATTRIBUTE ADDED ";
//renaming dublicated values and deleting dublicates
$seckey = [];
$pi = 1;
foreach($attrmainnode as $key => $value){
  $count = count($attrmainnode->$key);
  //echo $key . " ---  " . $count . "<br>";
  if($count == 2 or $count == 3 or $count == 4 or $count == 5 or $count == 6 or $count == 7 or $count == 8 ){
    //$seckey = $key;
    //echo $count;
    array_push($seckey, $key);
    $attrmainnode->addChild($key."_".$pi,$value);
    $pi += 1;
  }
}
// echo $seckey;
foreach($seckey as $item) {
    unset($attrmainnode->$item);
}
$result = $xml_attr->asXML('item.xml');
curl_close($curlattr);

$doc2 = new DOMDocument();
$doc2->load('item.xml');

$res1 = $doc1->getElementsByTagName('Attributes')->item(0);
$items2 = $doc2->getElementsByTagName('Attribute');

for ($i = 0; $i < $items2->length; $i ++) {
    $item2 = $items2->item($i);
    // import/copy item from document 2 to document 1
    $item1 = $doc1->importNode($item2, true);
    // append imported item to document 1 'res' element
    $res1->appendChild($item1);
}
$doc1->save(ACC_PATH . 'ACC attributes.xml');
