<?php

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', F9_LOG_PATH . 'LOG/prod_errors_'.date("Y-m-d H:i:s").'.log');
set_time_limit(999000);

$savedattr = json_decode(file_get_contents(F9_PATH . 'PID_list.json'), true);
$catarray = json_decode(file_get_contents(F9_PATH . 'ClassID.json'), true);

if (file_exists(F9_PATH . 'F9 attributes.xml')){
  $doc1 = new DOMDocument('1.0','UTF-8');
  $doc1->load(F9_PATH . 'F9 attributes.xml');
}else{
  $doc1 = new DOMDocument('1.0','utf-8');
  $element = $doc1->createElement('Attributes','');
  $doc1->appendChild($element);
  $doc1->save(F9_PATH . 'F9 attributes.xml');
  $doc1->load(F9_PATH . 'F9 attributes.xml');
}

for ($x = 0; $x <= count($catarray)-1; $x++) {
  usleep(300000);
  $maincateg = $catarray[$x];
  $url = "http://www.f9baltic.com/scripts/XML_Interface.dll?MfcISAPICommand=Default";
  $request = '%3CCatalogRequest%3E%3CDate%3E2021-10-11T12:00:00%3C/Date%3E%3CRoute%3E%3CFrom%3E%3CClientID%3E12723%3C/ClientID%3E%3C/From%3E%3CTo%3E%3CClientID%3E1%3C/ClientID%3E%3C/To%3E%3C/Route%3E%3CFilters%3E%3CFilter%20FilterID=%22ClassID%22%20Value=%22'.$maincateg.'%22/%3E%3C/Filters%3E%3C/CatalogRequest%3E';
  $postinone = $url."&USERNAME=".$user."&PASSWORD=".$pass."&XML=".$request;
  $finalurl = mb_convert_encoding($postinone, "Windows-1252", "UTF-8");

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $finalurl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_HTTPHEADER => array(
      'contect-type: text/xml'
    ),
  ));

  $response = curl_exec($curl);
  $xmlcat = simplexml_load_string($response);

  curl_close($curl);

  if (strpos($response, 'ParseError') !== false) {
    echo 'No attributes';
  }

  foreach ($xmlcat->xpath('ListofCatalogDetails') as $cat_list){
    foreach ($cat_list->xpath('CatalogItem') as $sin_product){
      //var_dump($sin_product);
      foreach ($sin_product->xpath('Product') as $proinner){
        $proid = $proinner['ProductID'];
        foreach ($proinner->xpath('PartNumber') as $xml){
          $partnr = (string) $xml;
          //echo $partnr."<br>";
          if (!in_array($partnr, $savedattr)){
	      //echo "in array" . "<br>";
              usleep(100000);
              include(F9_PATH . 'F9 attributes downloader.php');
              array_push($savedattr, $partnr);
              file_put_contents('PID_list.json', json_encode($savedattr));
          }
        }
      }
    }
  }
}
echo "!!COMPLETE!!";
