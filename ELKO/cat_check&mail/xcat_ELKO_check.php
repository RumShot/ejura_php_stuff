<?php

include("../config.php");
require_once "Mail.php";

$mail_pass = file_get_contents(DIR_STORAGE . "mail_pass.txt", "r");
$bear = file_get_contents(DIR_STORAGE . "bearer.txt", "r");

// @mail data
$from = "info@ejura.eu";
$to = 'info@ejura.eu';
$host = "smtp.hostinger.com";
$port = "587";
$username = 'info@ejura.eu';
$password = $mail_pass;
$subject = "ELKO changes appeared";

$headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

// curl ELKO
$curl_category_check = curl_init();

curl_setopt_array($curl_category_check, array(
  CURLOPT_URL => 'https://api.elko.cloud/v3.0/api/Catalog/Categories',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: ' . $bear
  ),
));

$category_response = curl_exec($curl_category_check);

curl_close($curl_category_check);
//new category data to array
$new_array = [];
$elko_decoded_json = json_decode($category_response, true);
for ($cat = 0; $cat <= count($elko_decoded_json)-1; $cat++){
  $singlecat = $elko_decoded_json[$cat];
  $maincategory = $singlecat['code'];
  array_push($new_array, $maincategory);
}

// old category data to array
$previous_catalog = file_get_contents(DIR_STORAGE . 'ELKO_previous_catalog_list.json');
$previous_data = json_decode($previous_catalog, true);
$previous_array = [];

for ($cat = 0; $cat <= count($previous_data)-1; $cat++){
  $singlecat = $previous_data[$cat];
  $maincategory = $singlecat['code'];
  array_push($previous_array, $maincategory);
}

//comparing
$result_array = [];
foreach ($new_array as &$value) {
  if (!in_array($value, $previous_array)){
    array_push($result_array, $value);
  }
}
// @mail it
if ($category_response == ''){
  $body = "Didn't get ELKO response please check if Bearer is active it might expire";
  $mail = $smtp->send($to, $headers, $body);
  if (PEAR::isError($mail)) {
    echo($mail->getMessage());
  } else {
    echo($body);
  }
}
if(empty($result_array[0])){
  echo "No changes";
}else{
  file_put_contents(DIR_STORAGE . "ELKO_previous_catalog_list.json", $category_response);
  $body = "New ELKO catalog/gs have appeared: " . json_encode($result_array);
  $mail = $smtp->send($to, $headers, $body);
  if (PEAR::isError($mail)) {
    echo($mail->getMessage());
  } else {
    echo($body);
  }
}
