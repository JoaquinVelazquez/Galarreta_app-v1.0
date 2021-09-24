<?php
include_once("DB/config.php");
include_once("DB/get_token.php");
/*
//VALIDAR QUE ES UN ID
$id = $_GET["id"];
$id = filter_var($id, FILTER_VALIDATE_INT);

// if(!$id) {
//     header('Location: /apanel/index.php');
// }

$sql = "SELECT * FROM tokens WHERE user_id = ${id}";
$datos = mysqli_query($link, $sql);
$usuario = mysqli_fetch_assoc($datos);
*/
// var_dump($usuario);

$refresh_token = $usuario["refresh_token"];
$user_id = $usuario["user_id"];

//RENOVAR ACCESS TOKEN CON REFRESH TOKEN

$url_refresh = "https://api.mercadolibre.com/oauth/token";

$data_refresh = array (
'grant_type' => 'refresh_token',
'client_id' => '624787090575020',
'client_secret' => 'OtbNMR17kSC5nuFuU7fZXNBDyPiaR5UQ',
'refresh_token' => $refresh_token,
);

// var_dump($data);

$post_refresh = http_build_query($data_refresh);

// var_dump($post);

$header_refresh = array (
'Accept' => 'application/json',
'Content_Type' => 'application/x-www-form-urlencoded'
);

$options_refresh = array(
CURLOPT_RETURNTRANSFER => 'true',
CURLOPT_HTTPHEADER => $header_refresh,
CURLOPT_SSL_VERIFYPEER => 'false',
CURLOPT_URL => $url_refresh,
CURLOPT_POSTFIELDS => $post_refresh,
CURLOPT_CUSTOMREQUEST => "POST",
);

// do a curl call
$call_refresh = curl_init();
curl_setopt_array($call_refresh, $options_refresh);
// execute the curl call
$response_refresh = curl_exec($call_refresh);
// get the curl status
$status_refresh = curl_getinfo($call_refresh);
// close the call
curl_close($call_refresh);
// transform the json in array
$response_refresh = (array) json_decode($response_refresh);

$user_id = $id;
$access_token = ($response_refresh["access_token"]);
$refresh_token = ($response_refresh["refresh_token"]);

$stmt = $link->prepare("UPDATE tokens SET access_token = ?, refresh_token = ? WHERE user_id = ?");
$stmt->bind_param('ssi', $access_token, $refresh_token, $user_id);
$stmt->execute();
$stmt->close();