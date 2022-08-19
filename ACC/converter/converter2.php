<?php
//file change to POST data
$string = file_get_contents("products from ACC.json");
//decoding to understandable data
$array = json_decode($string,true);
// creating object of SimpleXMLElement
$xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Products></Products>');
//for every product in json-data
if (!empty($array['Products'])) {


for ($x = 0; $x <= count($array['Products'])-1; $x++){
  $data = $array['Products'][$x];
  //product to xml
  $mainnode = $xml_data->addChild("Product");
  //required data for Shadow
  $pid = $data['PID'];
  $mainnode->addAttribute('PID', $pid);
  $ean = $data['EAN'];
  $mainnode->addAttribute('EAN', $ean);
  $mpn = $data['MPN'];
  $mainnode->addAttribute('MPN', $mpn);
  $name = $data['Name'];
  $mainnode->addAttribute('Name', $name);
  $picture = $data['Picture'];
  $mainnode->addAttribute('Picture', $picture);
  $producer = $data['Producer']['Name'];
  $mainnode->addAttribute('Producer_name', $producer);
  $price = $data['Price']['Value'];
  $mainnode->addAttribute('Price_Value', $price);
  $warranty = $data['Warranty'];
  $mainnode->addAttribute('Warranty', $warranty);
  //Stocks array
  $stocks = json_encode($data['Stocks'],true);
  $stock =json_decode($stocks,true);
  //Takes from Stock all Child elements and bring SALES->Amount
  for ($y = 0; $y <= count($stock)-1; $y++){
    //current amount
    if($stock[$y]['WhId'] === "SALES"){
      $amount = $stock[$y]['Amount'];
      $mainnode->addAttribute('Amount', $amount);
      }
    //expected amount for arriving
    if($stock[$y]['ExpectedDate'] !== null){
      $expecteddate = $stock[$y]['ExpectedDate'];
      $mainnode->addAttribute('ExpectedDate', $expecteddate);
      $amountarriving = $stock[$y]['AmountArriving'];
      $mainnode->addAttribute('AmountArriving', $amountarriving);
    }else{
      $expecteddate = "No expected date";
      //$mainnode->addAttribute('ExpectedDate', $expecteddate);
      $amountarriving = "No amount arriving";
      //$mainnode->addAttribute('AmountArriving', $amountarriving);
    }
  }
  $branches = json_encode($data['Branches'],true);
  $branche =json_decode($branches,true);
  for ($z = 0; $z <= count($branche)-1; $z++){
    $boid[$z] = $branche[$z]['OId'];
    $mainnode->addAttribute('Branche_OId_'.$z,$boid[$z]);
    $bname[$z] = $branche[$z]['Name'];
    $mainnode->addAttribute('Branche_Name_'.$z, $bname[$z]);
    //echo $boid."  ". $bname." ".$z. "<br>";
  }

 echo "Product ".$x."<br>".$ean."<br>".$mpn."<br>".$name."<br>".$picture."<br>".$producer."<br>".$price."<br>".$warranty."<br>".$expecteddate."<br>".$amountarriving."<br>";
 echo $boid[0]." ".$bname[0]."<br>".$boid[1]." ".$bname[1]."<br>".$boid[2]." ".$bname[2]."<br>"."<br>";
  //echo $boid[3]." ".$bname[3]."<br>".$boid[4]." ".$bname[4]."<br>"."<br>";
}
} else {
  echo "EMPTY !!!!!!!!!!!!!!!!!!";
}
$result = $xml_data->asXML('json to xml.xml');

?>
