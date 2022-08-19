<?php
$file = 'item.xml';
$curlattr = curl_init();
$urlattr = "http://www.f9baltic.com/scripts/XML_Interface.dll?MfcISAPICommand=Default";

$requestattr = '<ProductSpecRequest><Date>2021-10-11T12:00:00</Date><Route><From><ClientID>12723</ClientID></From><To><ClientID>1</ClientID></To></Route><PartNumber>'.$partnr.'</PartNumber></ProductSpecRequest>';
$postinoneattr = $urlattr."&USERNAME=".$user."&PASSWORD=".$pass."&XML=".$requestattr;
$finalurlattr = mb_convert_encoding($postinoneattr, "Windows-1252", "UTF-8");

curl_setopt_array($curlattr, array(
  CURLOPT_URL => $finalurlattr,
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

$responseatrr = curl_exec($curlattr);
file_put_contents($file, $responseatrr);

  if (strpos($responseatrr, 'ParseError') !== false) {
    echo 'No attributes';
  }else{
    $doc2 = new DOMDocument();
    $doc2->load('item.xml');

    $res1 = $doc1->getElementsByTagName('Attributes')->item(0);
    $items2 = $doc2->getElementsByTagName('ProductSpec');

    for ($i = 0; $i < $items2->length; $i ++) {
        $item2 = $items2->item($i);
        // import/copy item from document 2 to document 1
        $item1 = $doc1->importNode($item2, true);
        // append imported item to document 1 'res' element
        $res1->appendChild($item1);
    }
    $doc1->save('F9 attributes.xml');
  }

curl_close($curlattr);
