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
$fecha_inicial = date("y-m-d", strtotime($fecha_actual . "- 60 day"));

$DATE_FROM = "20" . $fecha_inicial . "T00:00:00.000-00:00";
$DATE_TO = "20" . $fecha_actual . "T" . $hora_actual . ":00:00.000-00:00";

$i = 0;
$ordenes_array = array();
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
    $ordenes = (json_decode($output, true));

    $i += 50;

    if (isset($ordenes["results"])) {
        if (count($ordenes) > 0) {
            array_push($ordenes_array, $ordenes["results"]);
        }
    }
} while (count($ordenes["results"]) > 0);

$orden_mshop = array();
$orden_meli = array();
$dinero_array = array();
$unidades_array = array();
$entregado_array = array();
$no_entregado_array = array();
$otro_envio_array = array();
$ordenes_con_envios_array = array();

foreach ($ordenes_array as $data) {
    foreach ($data as $data2) {
        if ($data2["tags"][0] == "mshops") {
            array_push($orden_mshop, $data2);
        } elseif ($data2["tags"][1] == "mshops") {
            array_push($orden_mshop, $data2);
        } else {
            array_push($orden_meli, $data2);
        }

        if (isset($data2["total_amount"])) {
            array_push($dinero_array, $data2["total_amount"]);
        }

        if (isset(($data2["order_items"][0]["requested_quantity"]["value"]))) {
            array_push($unidades_array, ($data2["order_items"][0]["requested_quantity"]["value"]));
        }

        if (isset($data2["tags"][0])) {
            switch ($data2["tags"][0]) {
                case "delivered":
                    array_push($entregado_array, $data2["tags"]);
                    break;
                case "not_delivered":
                    array_push($no_entregado_array, $data2["tags"][0]);
                    break;
            }
        }

        if (isset($data2["tags"][1])) {
            switch ($data2["tags"][1]) {
                case "delivered":
                    array_push($entregado_array, $data2["tags"]);
                    break;
                case "not_delivered":
                    array_push($no_entregado_array, $data2["tags"][1]);
                    break;
            }
        }

        if (isset($data2["tags"][2])) {
            switch ($data2["tags"][2]) {
                case "delivered":
                    array_push($entregado_array, $data2["tags"]);
                    break;
                case "not_delivered":
                    array_push($no_entregado_array, $data2["tags"][2]);
                    break;
            }
        }

        if (isset($data2["tags"][3])) {
            switch ($data2["tags"][3]) {
                case "delivered":
                    array_push($entregado_array, $data2["tags"]);
                    break;
                case "not_delivered":
                    array_push($no_entregado_array, $data2["tags"][3]);
                    break;
            }
        }

        foreach($data2["shipping"] as $data3){
            if(isset($data3)){
                array_push($ordenes_con_envios_array, $data3);
            }
        }
    }
}

$dinero_mshop_array = array();
$dinero_meli_array = array();

foreach($orden_mshop as $data){
    array_push($dinero_mshop_array, $data["payments"][0]["total_paid_amount"]);
}

foreach($orden_meli as $data){
    array_push($dinero_meli_array, $data["payments"][0]["total_paid_amount"]);
}
