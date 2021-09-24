<?php
include_once("../DB/config.php");
include_once("../DB/get_token.php");
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

$i = 0;

$data_array = array();

do {
    $url = "https://api.mercadolibre.com/users/" . $user_id . "/items/search?status=active&limit=50&offset=" . $i;
    $authorization = array("Authorization: Bearer " . $access_token);
    // create curl resource
    $ch = curl_init();
    //Apí Link
    // set url
    curl_setopt($ch, CURLOPT_URL, $url);
    //Bearer Token to Header
    curl_setopt($ch, CURLOPT_HTTPHEADER, $authorization);
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $output contains the output string
    $output = curl_exec($ch);
    // close curl resource to free up system resources
    curl_close($ch);
    //DD info
    $publicaciones_output = (json_decode($output, true));
    //var_dump($publicaciones["results"]);

    array_push($data_array, $publicaciones_output["results"]);

    $i += 50;
} while (count($publicaciones_output["results"]) > 0);

$items_array = array();

foreach ($data_array as $data1) {
    foreach ($data1 as $data2) {
        array_push($items_array, $data2);
    }
}

$publicacion_array = array();

$publicaciones_array = array();

foreach ($items_array as $item) {
    $url = "https://api.mercadolibre.com/items?ids=" . $item;
    $authorization = array("Authorization: Bearer " . $access_token);
    // create curl resource
    $ch = curl_init();
    //Apí Link
    // set url
    curl_setopt($ch, CURLOPT_URL, $url);
    //Bearer Token to Header
    curl_setopt($ch, CURLOPT_HTTPHEADER, $authorization);
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $output contains the output string
    $output = curl_exec($ch);
    // close curl resource to free up system resources
    curl_close($ch);
    //DD info
    $publicacion = (json_decode($output, true));

    $publicacion_array["id_producto"] = $publicacion[0]["body"]["id"];
    $publicacion_array["nombre_producto"] = $publicacion[0]["body"]["title"];
    $publicacion_array["id_categoria"] = $publicacion[0]["body"]["category_id"];
    $publicacion_array["precio_producto"] = $publicacion[0]["body"]["price"];
    $publicacion_array["imagen_producto"] = $publicacion[0]["body"]["thumbnail"];

    array_push($publicaciones_array, $publicacion_array);
}

$total_publicaciones = count($publicaciones_array);