<?php
//$catproduct = 'singleproduct.xml';
$curlpro = curl_init();

$savedattr = json_decode(file_get_contents(ALSO_PATH .'PID_list.json'), true);
$prourl = "https://directxml.also.lt/DirectXML.svc/3/scripts/XML_Interface.dll?MfcISAPICommand=Default&USERNAME=".$user."&PASSWORD=".$pass."&XML=%3C%3Fxml+version%3D%221.0%22+encoding%3D%22UTF-8%22%3F%3E%0D%0A%3CCatalogRequest%3E%0D%0A++++++++%3CDate%2F%3E%0D%0A++++++++%3CCatNumber%3E1.0%3C%2FCatNumber%3E%0D%0A++++++++%3CRoute%3E%0D%0A++++++++++++++++%3CFrom%3E%3CClientID%3E11183250%3C%2FClientID%3E%3C%2FFrom%3E%0D%0A++++++++++++++++%3CTo%3E%3CClientID%3E0%3C%2FClientID%3E%3C%2FTo%3E%0D%0A++++++++%3C%2FRoute%3E%0D%0A++++++++%3CFilters%3E%0D%0A++++++++++++++++%3CFilter+FilterID%3D%22ClassID%22+Value%3D%22".$cat."%22%2F%3E%0D%0A++++++++%3C%2FFilters%3E%0D%0A%3C%2FCatalogRequest%3E%0D%0A";

if (file_exists(ALSO_PATH . 'ALSO attributes.xml')){
  $doc1 = new DOMDocument('1.0','UTF-8');
  $doc1->load(ALSO_PATH . 'ALSO attributes.xml');
}else{
  $doc1 = new DOMDocument('1.0','utf-8');
  $element = $doc1->createElement('Attributes','');
  $doc1->appendChild($element);
  $doc1->save(ALSO_PATH . 'ALSO attributes.xml');
  $doc1->load(ALSO_PATH . 'ALSO attributes.xml');
}

curl_setopt_array($curlpro, array(
  CURLOPT_URL => $prourl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'contect-type: text/xml'),
));

$responsepro = curl_exec($curlpro);
//file_put_contents($catproduct, $responsepro);
$xmlpro = simplexml_load_string($responsepro);

curl_close($curlpro);

// $tempfile = new DOMDocument();
// $tempfile->load('singleproduct.xml');
//
// $into = $profile->getElementsByTagName('Products')->item(0);
// $from = $tempfile->getElementsByTagName('ListofCatalogDetails');
//
// for ($eta = 0; $eta < $from->length; $eta ++) {
//     $data2 = $from->item($eta);
//     $data1 = $profile->importNode($data2, true);
//     $into->appendChild($data1);
// }
// $profile->save('ALSO products.xml');

foreach ($xmlpro->xpath('ListofCatalogDetails') as $cat_list){
  foreach ($cat_list->xpath('CatalogItem') as $sin_product){

    $json = json_encode($sin_product);
    $product_array = json_decode($json,TRUE);
    $product_value = $product_array['Product'];
    $productid = $product_value['ProductID'];
    $partnumber = $product_value['PartNumber'];
    echo "<br>" . $partnumber . "<br>" ;
    var_dump($sin_product);

    if (!in_array($productid, $savedattr)){
        usleep(50000);
        include('ALSO attribute downloader.php');
        array_push($savedattr, $productid);
        file_put_contents(ALSO_PATH . 'PID_list.json', json_encode($savedattr));
      }

  }
}
