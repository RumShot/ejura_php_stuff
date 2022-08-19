<?php

include("../config.php");
require_once "Mail.php";

$mail_pass = file_get_contents(DIR_STORAGE . "mail_pass.txt", "r");

// @mail data
$from = "";
$to = '';
$host = "smtp.hostinger.com";
$port = "587";
$username = '';
$password = $mail_pass;
$subject = "ALSO changes appeared";

$headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

// curl ALSO
$curl_category_check = curl_init();

curl_setopt_array($curl_category_check, array(
  CURLOPT_URL => 'http://directxml.also.lt/DirectXML.svc/GetGrouping/3/11183250',
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

$category_response = curl_exec($curl_category_check);
curl_close($curl_category_check);

//new category data to array
$also_response_xml = simplexml_load_string($category_response);
$new_array = [];

foreach($also_response_xml->children() as $categories) {
  if($categories['GroupID'] == 'ClassID'){
    array_push($new_array, $categories['Value']);
  }
}

// old category data to array
$also_old_cat_xml=simplexml_load_file(DIR_STORAGE ."ALSO_previous_catalog_list.xml") or die("Error: Cannot create object");
$previous_array = [];
foreach($also_old_cat_xml->children() as $categories_old) {
  if($categories_old['GroupID'] == 'ClassID'){
    array_push($previous_array, $categories_old['Value']);
  }
}

//comparing
$result = array_diff($new_array, $previous_array);
if($result == array()){
  echo "No changes";
}else{
  file_put_contents(DIR_STORAGE . "ALSO_previous_catalog_list.xml", $category_response);
  $body = "New ALSO catalog/gs have appeared: " . json_encode($result) . " check it: http://directxml.also.lt/DirectXML.svc/GetGrouping/3/11183250";
  $mail = $smtp->send($to, $headers, $body);
  if (PEAR::isError($mail)) {
    echo($mail->getMessage());
  } else {
    echo($body);
  }
}
