<?php
include_once("../DB/config.php");
include_once("../DB/get_token.php");

//VALIDAR QUE ES UN ID
/*
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
$fecha_inicial = date("y-m-d", strtotime($fecha_actual . "- 30 day"));

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

$ordenes = array();
foreach ($ordenes_array as $data) {
    foreach ($data as $orden) {
        $productoId = $orden['order_items'][0]['item']['id'];
        if (!isset($ordenes[$productoId])) {
            $ordenes[$productoId] = array('montos' => []);
        }
        $ordenes[$productoId]['id_producto'] = $orden["order_items"][0]["item"]["id"];
        $ordenes[$productoId]['descripcion'] = $orden['payments'][0]["reason"];
        $ordenes[$productoId]['montos'][] = $orden['payments'][0]["total_paid_amount"];
        $ordenes[$productoId]['total'] = array_sum($ordenes[$productoId]['montos']);
    }
}

$publicaciones_array = array();

foreach ($ordenes as $data) {
    $url = "https://api.mercadolibre.com/items?ids=" . $data['id_producto'];
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

    $productoId = $data['id_producto'];

    if(isset($publicaciones_output[0]["body"]["shipping"]["tags"][0])){
        $envio_flex = $publicaciones_output[0]["body"]["shipping"]["tags"][0];
    } else {
        $envio_flex = "NULL";
    }

    $ordenes[$productoId]['imagen'] = $publicaciones_output[0]["body"]["thumbnail"];
    $ordenes[$productoId]['link'] = $publicaciones_output[0]["body"]["permalink"];
    $ordenes[$productoId]['envio_full'] = $publicaciones_output[0]["body"]["shipping"]["logistic_type"];
    $ordenes[$productoId]['envio_flex'] = $envio_flex;
    $ordenes[$productoId]['status'] = $publicaciones_output[0]["body"]["status"];
    $ordenes[$productoId]['tipo'] = $publicaciones_output[0]["body"]["listing_type_id"];
}

uasort($ordenes, function ($orden1, $orden2) {
    if ($orden1['total'] == $orden2['total']) {
        return 0;
    }

    return $orden1['total'] < $orden2['total'] ? 1 : -1;
});

$ranking_publicaciones_precio = array();
$ordenes_unidades = array();

foreach ($ordenes as $data) {
    $publicacion_array_precio = array(
        'id_producto' => $data["id_producto"],
        'nombre_producto' => $data["descripcion"],
        'imagen' => $data["imagen"],
        'link' => $data["link"],
        'envio_full' => $data["envio_full"],
        'envio_flex' => $data["envio_flex"],
        'status' => $data["status"],
        'tipo' => $data["tipo"],
        'total_dinero' => $data["total"],
        'total_cantidad' => count($data["montos"])
    );

    array_push($ranking_publicaciones_precio, $publicacion_array_precio);
    array_push($ordenes_unidades, $publicacion_array_precio);
}

uasort($ordenes_unidades, function ($orden3, $orden4) {
    if ($orden3['total_cantidad'] == $orden4['total_cantidad']) {
        return 0;
    }

    return $orden3['total_cantidad'] < $orden4['total_cantidad'] ? 1 : -1;
});

$publicacion_array_unidad = array();
$ranking_publicaciones_unidades = array();

foreach ($ordenes_unidades as $data) {
    array_push($ranking_publicaciones_unidades, $data);
}