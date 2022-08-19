<?php
ob_start();
//file change to POST data
$string = file_get_contents("attribute.json");
//decoding to understandable data
$array = json_decode($string,true);
// creating object of SimpleXMLElement
$xml_main = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Attributes></Attributes>');

mkdir('ACC_DL '. date("Y_m_d_h_i") , 0777, true);
$path = 'ACC_DL '. date("Y_m_d_h_i");
//creates arrayttribute-parrent
$xml_data = $xml_main->addChild("Attribute");
//childs elements
$piroduct = $array['Product'];
$piid = $piroduct['PID'];
$xml_data->addChild('PID', $piid);
$mpn = $piroduct['MPN'];
$xml_data->addChild('MPN', $mpn);


echo $piid." ".$mpn;
//images
for ($y = 0; $y <= count($piroduct['Medias'])-1; $y++){
  $imgurl = json_encode($piroduct['Medias'][$y],true);
  $imgurls =json_decode($imgurl,true);
  $imgage = $imgurls['OriginalUri'];
  $xml_data->addChild('ImgURL'.$y, $imgage);

  echo "<br>". $y.$imgage . "<br>";
}
//Parameters
for ($x = 0; $x <= count($piroduct['Parameters'])-1; $x++){
  // $piara = json_encode($piroduct['Parameters'][$x],true);
  // $piarameter =json_decode($piara,true);
  $piarameter = $piroduct['Parameters'][$x];
  $piarametername = $piarameter['ParameterName'];
  $attribute = $piarameter['ParameterName'];
  $value = $piarameter['Value'];
  $measureabbr = $piarameter['MeasureAbbr'];
  //remove unwanted simbols
  $piarametername = str_replace( array(")", "'", "(", "/", "„","“","\"",",","_","Ø"), '', $piarametername);
  $piarametername = str_replace( ' ', '_', $piarametername);
  $group = $piarameter['ParameterGroupName'];

  $add = $xml_data->addChild($piarametername,htmlspecialchars($attribute) .": ".$value." ".$measureabbr);

  function xml_child_exists($xml_data, $piarametername){
    $resultss = $xml_data->xpath($piarametername);
    if(!empty($resultss ))
    {
        echo 'the node is available';
    }
    else
    {
        echo 'the node is not available';
    }
    }

  //remove unwanted simbols
  $group = str_replace( ' ', '', $group);
  $group = str_replace( '&', 'and', $group);
  //if group exsists
  if(empty($xml_data->$group)){
    $mainnode = $xml_data->addChild($group);
    $add = $mainnode->addChild($piarametername,$attribute .": ".$value." ".$measureabbr);
    //$add->addAttribute("descr", $attribute);
    echo "groupso nera";
  }else{
    $add = $xml_data->$group->addChild($piarametername,$attribute .": ".$value." ".$measureabbr);
    //$add->addAttribute("descr", $attribute);
    echo "groupsas yra";
  }

  echo $group."------------>". $piarametername. "  " .$value . " ". $measureabbr. "<br>";

}

//print_r($xml_main);
//var_dump($xml_main);
function deleteAttr2($xml_data,$seckey){
  foreach($xml_data as $key => $value){
    unset($xml_data->$seckey);
  }
}

$pi = 1;
foreach($xml_data as $key => $value){
  $count = count($xml_data->$key);

  if($count == 2){
    unset($xml_data->$key);
    $seckey = $key;
    $xml_data->addChild($key."_".$pi, $value);
    $parser = xml_parser_create();
    xml_parse_into_struct($parser, $key, $value);
    xml_parser_free($parser);
    $key = $key."_".$pi;
    replaceChild($key."_".$pi, $key);
    echo " DELETED ".$key.$count[1];
    $xml_data->addChild($key."_1",$value);
    unset($xml_data->$key);
    echo $key." sitas ";
    $pi += 1;
    echo $key." ".$value ." <br>";
    deleteAttr2($xml_data,$seckey);
  }
}

$result = $xml_main->asXML($path.'/product attributes.xml');

file_put_contents('LOG '. date("Y_m_d_h_i") .'.htm', ob_get_contents());

ob_end_flush();

?>
