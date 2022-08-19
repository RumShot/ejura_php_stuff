<?php
$file = 'item.xml';
$curlattr = curl_init();

$attrurl = "https://directxml.also.lt/DirectXML.svc/3/scripts/XML_Interface.dll?MfcISAPICommand=Default&USERNAME=".$user."&PASSWORD=".$pass."&XML=%3C?xml%20version=%221.0%22%20encoding=%22UTF-8%22?%3E%3CProductSpecRequest%3E%3CDate%3E2012-12-06T12:00:00%3C/Date%3E%3CRoute%3E%3CFrom%3E%3CClientID%3E11183250%3C/ClientID%3E%3C/From%3E%3CTo%3E%3CClientID%3E0%3C/ClientID%3E%3C/To%3E%3C/Route%3E%3CLanguage%3EENG%3C/Language%3E%3CPartNumber%3E".$partnumber."%3C/PartNumber%3E%3C/ProductSpecRequest%3E";

curl_setopt_array($curlattr, array(
  CURLOPT_URL => $attrurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'contect-type: text/xml; charset=UTF-8'),
));

$responseatrr = curl_exec($curlattr);
file_put_contents($file, $responseatrr);

  if (strpos($responseatrr, 'ParseError') !== false) {
    echo 'No attributes';
  }else{
    $doc2 = new DOMDocument();
    $doc2->load(ALSO_PATH . 'item.xml');

    $res1 = $doc1->getElementsByTagName('Attributes')->item(0);
    $items2 = $doc2->getElementsByTagName('ProductSpec');

    for ($i = 0; $i < $items2->length; $i ++) {
        $item2 = $items2->item($i);
        // import/copy item from document 2 to document 1
        $item1 = $doc1->importNode($item2, true);
        // append imported item to document 1 'res' element
        $res1->appendChild($item1);
    }
    $doc1->save(ALSO_PATH . 'ALSO attributes.xml');
  }
curl_close($curlattr);
