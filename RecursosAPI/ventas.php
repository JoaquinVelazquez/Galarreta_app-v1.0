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
$consulta = mysqli_query($link, $sql);
if (!$consulta) { echo mysqli_error($link); 
    die;}
$usuario = mysqli_fetch_assoc($consulta);
*/
$access_token = $usuario["access_token"];
$user_id = $usuario["user_id"];

//Establecer fechas
date_default_timezone_set('America/Argentina/Buenos_Aires');
$horas = time();
$hora_actual = date('H', time());
$fecha_actual = date("y-m-d");
$fecha_inicial = date("y-m-d", strtotime($fecha_actual . "- 100 day"));

$DATE_FROM = "20" . $fecha_inicial . "T00:00:00.000-00:00";
$DATE_TO = "20" . $fecha_actual . "T" . $hora_actual . ":00:00.000-00:00";

$i = 0;
$ventas_array = array();
do {
    $url = "https://api.mercadolibre.com/orders/search?seller=" . $user_id . "&order.status=paid&order.date_created.from=" . $DATE_FROM . "&order.date_created.to=" . $DATE_TO . "&limit=50&offset=" . $i;
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
    $ventas = (json_decode($output, true));

    $i += 50;

    if (isset($ventas["results"])) {
        if (count($ventas) > 0) {
            array_push($ventas_array, $ventas["results"]);
        }
    }
} while (count($ventas["results"]) > 0);

$ventas_array_totales = array();

foreach ($ventas_array as $data) {
    foreach ($data as $data2) {
        array_push($ventas_array_totales, $data2);
    }
}