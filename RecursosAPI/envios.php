<?php
include_once("../DB/config.php");
include_once("../DB/get_token.php");
require_once("../RecursosAPI/ordenes.php");
/*
//VALIDAR QUE ES UN ID
$id = $_GET["id"];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /apanel/index.php');
}

$sql = "SELECT * FROM tokens WHERE user_id = ${id}";
$datos = mysqli_query($link, $sql);
if (!$datos) { echo mysqli_error($link); 
    die;}
$usuario = mysqli_fetch_assoc($datos);
*/
$access_token = $usuario["access_token"];
$user_id = $usuario["user_id"];

$envios_array = array();

foreach ($ordenes_con_envios_array as $data) {
    ////$envios
    $authorization = array("Authorization: Bearer " . $access_token);
    // create curl resource
    $ch = curl_init();
    //Apí Link
    $url = "https://api.mercadolibre.com/shipments/" . $data;
    // set url
    curl_setopt($ch, CURLOPT_URL, $url);
    //Bearer Token to Header
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $access_token, 'x-format-new: true'));
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $output contains the output string
    $output = curl_exec($ch);
    // close curl resource to free up system resources
    curl_close($ch);
    //DD info
    $envios = (json_decode($output, true));

    if(isset($envios["logistic"]["type"])){
        array_push($envios_array, $envios["logistic"]["type"]);
    }
}

$mercado_envios_array = array();
$mercado_envios_places_array = array();
$mercado_envios_colecta_array = array();
$mercado_envios_flex_array = array();
$mercado_envios_full_array = array();

foreach ($envios_array as $data){
    switch ($data){
        case "drop_off":
            array_push($mercado_envios_array, $data);
        break;
        case "xd_drop_off":
            array_push($mercado_envios_places_array, $data);
        break;
        case "cross_docking":
            array_push($mercado_envios_colecta_array, $data);
        break;
        case "self_services":
            array_push($mercado_envios_flex_array, $data);
        break;
        case "fulfillment":
            array_push($mercado_envios_full_array, $data);
        break;
    }
}