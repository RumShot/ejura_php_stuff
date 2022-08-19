<?php
$curl = curl_init();
$savedata = fopen('products from ACC.json', 'w');
$treefile = file_get_contents("tree.json", "r");
$trarray = json_decode($treefile,true);
$tree = $trarray['Treearray'];

//for every tree ID
for ($sk = 0; $sk <= count($tree)-1; $sk++){
  $i = 0;
  $treeid = $tree[$sk];
  echo $tree[$sk]."<br>";

  do {
  curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.accdistribution.net/v1/GetProducts',
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
        "Offset": "'.$i.'",
        "Limit": "10",
        "Filters": [{
                "id": "branch",
                "values": ["'.$treeid.'"]
}]
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json; charset=UTF-8'
  ),
));

$response = curl_exec($curl);
$result = json_decode($response, true);
fwrite($savedata, json_encode($result));
    echo $i."<br>";
    $i = $i + 10;
  //} while ($i < 100);
  } while ($result['Products'] !== null);

}

fclose($savedata);

echo "----------------------------";

curl_close($curl);
