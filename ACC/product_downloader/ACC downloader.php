<?php
// Error/Exception engine, always use E_ALL
error_reporting(E_ALL);
// always use TRUE
ini_set('ignore_repeated_errors', TRUE);
// Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment
ini_set('display_errors', TRUE);
// Error/Exception file logging engine.
ini_set('log_errors', TRUE);
// Logging file path
ini_set('error_log', ACC_LOG_PATH . 'LOG/prod_errors_'.date("Y-m-d H:i:s").'.log');

$catcurl = curl_init();

//quantity counters
$prodcount = 0;
$attrcount = 0;
$api_key = '';

$xml_prod = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Products></Products>');

curl_setopt_array($catcurl, array(
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
        "LicenseKey": "' . $api_key . '",
        "Locale": "lt"
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json; charset=UTF-8'
  ),
));

$catresponse = curl_exec($catcurl);
$catarray = json_decode($catresponse, true);

for ($ge = 0; $ge <= count($catarray)-1; $ge++){
  $treearray = $catarray['TreeBranches'];
  for ($da = 0; $da <= count($treearray)-1; $da++){
    $treebeanch =$treearray[$da];
    //var_dump($treebeanch);
    if($treebeanch['ParentId'] != null){
      $cat = $treebeanch['Id'];
      include('acc download products complete.php');
    }
  }
}

curl_close($catcurl);
