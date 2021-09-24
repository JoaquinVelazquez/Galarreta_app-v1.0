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

//Establecer fechas
date_default_timezone_set('America/Argentina/Buenos_Aires');
$horas = time();
$hora_actual = date('H:i:s', time());
$fecha_actual = date("y-m-d");
$fecha_inicial = date("y-m-d", strtotime($fecha_actual . "- 100 day"));

$DATE_FROM = "20" . $fecha_inicial . "T00:00:00.000-00:00";
$DATE_TO = "20" . $fecha_actual;

/*
do {
} while ()
*/

////$informacion
$authorization = array("Authorization: Bearer " . $access_token);
// create curl resource
$ch = curl_init();
//Apí Link
$url = "https://api.mercadolibre.com/questions/search?seller_id=" . $user_id . "&sort_fields=date_created&sort_types=DESC&offset=1&api_version=4";
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
$preguntas = (json_decode($output, true));

$preguntas_30_dias_array = array();

$preguntas_30_dias = count($preguntas_30_dias_array);
