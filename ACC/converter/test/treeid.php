<?php

$curltree = curl_init();

curl_setopt_array($curltree, array(
  CURLOPT_URL => 'https://api.accdistribution.net/v1/GetTreeBranches',
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
        "Locale": "lt"
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json; charset=UTF-8'
  ),
));

$epictree = curl_exec($curltree);

$trarray = json_decode($epictree,true);
$treess = $trarray['TreeBranches'];
$treearray = array();
for ($branchnr = 0; $branchnr <= count($treess)-1; $branchnr++){
  $single = $treess[$branchnr]['Id'];
  $single = json_encode($single, true);
  array_push($treearray, $single);
}
curl_close($curltree);
?>
