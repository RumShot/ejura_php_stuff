<?php
//file change to POST data
$string = file_get_contents("products from ACC.json");
//decoding to understandable data
$array = json_decode($string,true);
//for every product in json-data
//--------$x = 0
for ($x = 0; $x <= count($array['Products'])-1; $x++){
  //repeatable data
  //-----------$data = $array['Products'][$x];
  $data = $array['Products'][$x];
  //required data for Shadow
  $ean = $data['EAN'];
  $mpn = $data['MPN'];
  $name = $data['Name'];
  $picture = $data['Picture'];
  $producer = $data['Producer']['Name'];
  $price = $data['Price']['Value'];
  $warranty = $data['Warranty'];
  //Stocks array
  $stocks = json_encode($data['Stocks'],true);
  $stock =json_decode($stocks,true);
  //Takes from Stock all Child elements and bring SALES->Amount
  for ($y = 0; $y <= count($stock)-1; $y++){
    //current amount
    if($stock[$y]['WhId'] === "SALES"){
      $amount = $stock[$y]['Amount'];
      }
    //expected amount for arriving
    if($stock[$y]['ExpectedDate'] !== null){
      $expecteddate = $stock[$y]['ExpectedDate'];
      $amountarriving = $stock[$y]['AmountArriving'];
    }else{
      $expecteddate = "No expected date";
      $amountarriving = "No amount arriving";
    }
  }
  $branches = json_encode($data['Branches'],true);
  $branche =json_decode($branches,true);
  for ($z = 0; $z <= count($branche)-1; $z++){
    $boid[$z] = $branche[$z]['OId'];
    $bname[$z] = $branche[$z]['Name'];
    //echo $boid."  ". $bname." ".$z. "<br>";
  }


    //var_dump($branche);
  //echo $branche;
  echo "Product ".$x."<br>".$ean."<br>".$mpn."<br>".$name."<br>".$picture."<br>".$producer."<br>".$price."<br>".$warranty."<br>".$expecteddate."<br>".$amountarriving."<br>";
  echo $boid[0]." ".$bname[0]."<br>".$boid[1]." ".$bname[1]."<br>".$boid[2]." ".$bname[2]."<br>".$boid[3]." ".$bname[3]."<br>".$boid[4]." ".$bname[4]."<br>"."<br>";
}



?>
