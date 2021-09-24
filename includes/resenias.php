<?php
include_once("../DB/config.php");
include_once("../DB/get_token.php");
/*
//VALIDAR QUE ES UN ID
$id = $_GET["id"];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: /apanel/index.php');
}

$sql = "SELECT * FROM tokens WHERE user_id = ${id}";
$consulta = mysqli_query($link, $sql);
$usuario = mysqli_fetch_assoc($consulta);
*/
$nickname = $usuario["nickname"];
$pais = $usuario["pais"];

switch($pais){
    case "AR":
        $url = "https://www.mercadolibre.com.ar/perfil/".$nickname;
        break;
    case "CL":
        $url = "https://www.mercadolibre.cl/perfil/".$nickname;
        break;
    case "PE":
        $url = "https://www.mercadolibre.com.pe/perfil/".$nickname;
        break;
    case "CO":
        $url = "https://www.mercadolibre.com.co/perfil/".$nickname;
        break;
    case "BR":
        $url = "https://www.mercadolibre.com.br/perfil/".$nickname;
        break;
}
// la url
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$html = curl_exec($ch);

$dom = new DOMDocument();
@$dom->loadHTML($html);

$h2s = $dom->getElementsByTagName('h2');
$ps = $dom->getElementsByTagName('p');

$h2_array = array();

foreach($h2s as $h2) {
    $tile_text = $h2->textContent;
    $h2_array[] = $tile_text;
}

$p_array = array();

foreach($ps as $p) {
    $tile_text_p = $p->textContent;
    $p_array[] = $tile_text_p;
}

$metrica_uno_titulo = $h2_array[0];
$metrica_dos_titulo = $h2_array[1];

if(count($p_array) == 8) {
    $metrica_uno_subtitulo = $p_array[3];
    $metrica_dos_subtitulo = $p_array[4];
} else {
    $metrica_uno_subtitulo = $p_array[5];
    $metrica_dos_subtitulo = $p_array[6];
}



