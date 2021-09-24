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
/*
echo "<pre>";
var_dump($usuario);
echo "</pre>";
*/

$access_token = $usuario["access_token"];
$user_id = $usuario["user_id"];

$visitas_array = array();
$i = 0;

//Establecer fechas
date_default_timezone_set('America/Argentina/Buenos_Aires');
$horas = time();
$hora_actual = date('H:i:s', time());
$fecha_actual = date("Y-m-d");
$fecha_inicial = date("Y-m-d", strtotime($fecha_actual . "- 60 day" . "+ " . $i . " day"));
$fecha_inicial_siguiente = date("Y-m-d", strtotime($fecha_inicial . "+1 day"));

$DATE_FROM = $fecha_inicial . "T00:00:00.000-00:00";
$DATE_FROM_SIGUIENTE = $fecha_inicial_siguiente . "T00:00:00.000-00:00";
$DATE_TO = $fecha_actual . "T00:00:00.000-00:00";

////$informacion
$authorization = array("Authorization: Bearer " . $access_token);
// create curl resource
$ch = curl_init();
//Apí Link
$url = "https://api.mercadolibre.com/users/" . $user_id . "/items_visits?date_from=" . $DATE_FROM . "&date_to=" . $DATE_TO;
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
$visitas = (json_decode($output, true));

//echo($visitas["total_visits"]);