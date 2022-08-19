<?php
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', ALSO_LOG_PATH . 'LOG/prod_errors_'.date("Y-m-d H:i:s").'.log');

set_time_limit(999000);

$url = 'http://directxml.also.lt/DirectXML.svc/GetGrouping/3/'.$id;

// $profile = new DOMDocument('1.0','utf-8');
// $proelement = $profile->createElement('Products','');
// $profile->appendChild($proelement);
// $profile->save('ALSO products.xml');
// $profile->load('ALSO products.xml');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'contect-type: text/xml'
  ),
));

$response = curl_exec($curl);

$xml = simplexml_load_string($response);

foreach ($xml->xpath('GroupBy') as $category) {
  echo "<br>";
  $cat = $category['Value'];
  echo $category['Value'] ." ___ " . $category['Description'] ;
  usleep(50000);
  include('ALSO products downloader.php');
}

curl_close($curl);
