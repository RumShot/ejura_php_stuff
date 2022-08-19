<?php

// $exsfile = fopen("exs.json", "r");
// $sip = json_encode($exsfile,true);
// $exsingle = $exsfile[0]['Exspid'];

$exsfile = file_get_contents("tree.json", "+a");
$sip = json_decode($exsfile,true);
$dip = $sip['Exspid'];
$number = "1234";
for ($nr = 0; $nr <= count($dip)-1; $nr++){
  $b = $dip[$nr];
  echo "----Tree ID: ".$dip[$nr]."----"."<br>";
  file_put_contents('filename.txt', print_r($b, true));
}

// print_r($dip);
// var_dump($dip);

//fclose($dipfile);
 ?>
