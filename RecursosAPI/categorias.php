<?php
include_once("../DB/config.php");
include_once("../DB/get_token.php");
require_once("../RecursosAPI/publicaciones.php");

// //VALIDAR QUE ES UN ID
// $id = $_GET["id"];
// $id = filter_var($id, FILTER_VALIDATE_INT);

// if (!$id) {
//     header('Location: /apanel/index.php');
// }

// $sql = "SELECT * FROM tokens WHERE user_id = ${id}";
// $datos = mysqli_query($link, $sql);
// if (!$datos) { echo mysqli_error($link); 
//     die;}
// $usuario = mysqli_fetch_assoc($datos);

$access_token = $usuario["access_token"];
$user_id = $usuario["user_id"];

$categorias_array = array();

foreach ($publicaciones_array as $publicaciones) {
    ////$informacion
    $authorization = array("Authorization: Bearer " . $access_token);
    // create curl resource
    $ch = curl_init();
    //Apí Link
    $url = "https://api.mercadolibre.com/categories/" . $publicaciones["id_categoria"];
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
    $categorias = (json_decode($output, true));

    $categoria_array = array(
        "categoria_id" => $categorias["id"],
        "nombre_categoria" => $categorias["name"],
        "nombre_categoria_principal" => $categorias["path_from_root"][0]["name"],
        "id_categoria_principal" => $categorias["path_from_root"][0]["id"],
    );

    array_push($categorias_array, $categoria_array);
}

$categoria_accesorios_vehiculos = array();
$categoria_agro = array();
$categoria_alimentos_bebidas = array();
$categoria_animales_mascotas = array();
$categoria_antiguedades_colecciones = array();
$categoria_arte_libreria = array();
$categoria_autos_motos = array();
$categoria_bebes = array();
$categoria_belleza_cuidado = array();
$categoria_camara_accesorios = array();
$categoria_celulares = array();
$categoria_computacion = array();
$categoria_consolas_videojuegos = array();
$categoria_deportes_fitness = array();
$categoria_electrodomesticos_aires = array();
$categoria_electronica_audio_video = array();
$categoria_herramientas_construccion = array();
$categoria_hogar_muebles_jardin = array();
$categoria_industrias_oficinas = array();
$categoria_inmuebles = array();
$instrumentos_musicales = array();
$categoria_joyas_relojes = array();
$categoria_juegos_jueguetes = array();
$categoria_libros_revistas_comics = array();
$categoria_musica_peliculas_series = array();
$categoria_ropa_accesorios = array();
$categoria_salud_equipamiento = array();
$categoria_servicios = array();
$categoria_souvenirs_cotillon = array();
$categoria_otros = array();

foreach ($categorias_array as $data) {
    if (isset($data["nombre_categoria_principal"])) {
        if ($data["nombre_categoria_principal"] === "Accesorios para Vehículos") {
            array_push($categoria_accesorios_vehiculos, $data);
        } elseif ($data["nombre_categoria_principal"] === "Agro") {
            array_push($categoria_agro, $data);
        } elseif ($data["nombre_categoria_principal"] === "Alimentos y Bebidas") {
            array_push($categoria_alimentos_bebidas, $data);
        } elseif ($data["nombre_categoria_principal"] === "Animales y Mascotas") {
            array_push($categoria_animales_mascotas, $data);
        } elseif ($data["nombre_categoria_principal"] === "Antigüedades y Colecciones") {
            array_push($categoria_antiguedades_colecciones, $data);
        } elseif ($data["nombre_categoria_principal"] === "Arte, Librería y Mercería") {
            array_push($categoria_arte_libreria, $data);
        } elseif ($data["nombre_categoria_principal"] === "Autos, Motos y Otros") {
            array_push($categoria_autos_motos, $data);
        } elseif ($data["nombre_categoria_principal"] === "Bebés") {
            array_push($categoria_bebes, $data);
        } elseif ($data["nombre_categoria_principal"] === "Belleza y Cuidado Personal") {
            array_push($categoria_belleza_cuidado, $data);
        } elseif ($data["nombre_categoria_principal"] === "Cámaras y Accesorios") {
            array_push($categoria_camara_accesorios, $data);
        } elseif ($data["nombre_categoria_principal"] === "Celulares y Teléfonos") {
            array_push($categoria_celulares, $data);
        } elseif ($data["nombre_categoria_principal"] === "Computación") {
            array_push($categoria_computacion, $data);
        } elseif ($data["nombre_categoria_principal"] === "Consolas y Videojuegos") {
            array_push($categoria_consolas_videojuegos, $data);
        } elseif ($data["nombre_categoria_principal"] === "Deportes y Fitness") {
            array_push($categoria_deportes_fitness, $data);
        } elseif ($data["nombre_categoria_principal"] === "Electrodomésticos y Aires Ac.") {
            array_push($categoria_electrodomesticos_aires, $data);
        } elseif ($data["nombre_categoria_principal"] === "Electrónica, Audio y Video") {
            array_push($categoria_electronica_audio_video, $data);
        } elseif ($data["nombre_categoria_principal"] === "Herramientas y Construcción") {
            array_push($categoria_herramientas_construccion, $data);
        } elseif ($data["nombre_categoria_principal"] === "Hogar, Muebles y Jardín") {
            array_push($categoria_hogar_muebles_jardin, $data);
        } elseif ($data["nombre_categoria_principal"] === "Industrias y Oficinas") {
            array_push($categoria_industrias_oficinas, $data);
        } elseif ($data["nombre_categoria_principal"] === "Inmuebles") {
            array_push($categoria_inmuebles, $data);
        } elseif ($data["nombre_categoria_principal"] === "Instrumentos Musicales") {
            array_push($instrumentos_musicales, $data);
        } elseif ($data["nombre_categoria_principal"] === "Joyas y Relojes") {
            array_push($categoria_joyas_relojes, $data);
        } elseif ($data["nombre_categoria_principal"] === "Juegos y Juguetes") {
            array_push($categoria_juegos_jueguetes, $data);
        } elseif ($data["nombre_categoria_principal"] === "Libros, Revistas y Comics") {
            array_push($categoria_libros_revistas_comics, $data);
        } elseif ($data["nombre_categoria_principal"] === "Música, Películas y Series") {
            array_push($categoria_musica_peliculas_series, $data);
        } elseif ($data["nombre_categoria_principal"] === "Ropa y Accesorios") {
            array_push($categoria_ropa_accesorios, $data);
        } elseif ($data["nombre_categoria_principal"] === "Salud y Equipamiento Médico") {
            array_push($categoria_salud_equipamiento, $data);
        } elseif ($data["nombre_categoria_principal"] === "Servicios") {
            array_push($categoria_servicios, $data);
        } elseif ($data["nombre_categoria_principal"] === "Souvenirs, Cotillón y Fiestas") {
            array_push($categoria_souvenirs_cotillon, $data);
        } elseif ($data["nombre_categoria_principal"] === "Otras categorías") {
            array_push($categoria_otros, $data);
        }
    }
}

$array_categorias = [
    $categoria_accesorios_vehiculos,
    $categoria_agro,
    $categoria_alimentos_bebidas,
    $categoria_animales_mascotas,
    $categoria_antiguedades_colecciones,
    $categoria_arte_libreria,
    $categoria_autos_motos,
    $categoria_bebes,
    $categoria_belleza_cuidado,
    $categoria_camara_accesorios,
    $categoria_celulares,
    $categoria_computacion,
    $categoria_consolas_videojuegos,
    $categoria_deportes_fitness,
    $categoria_electrodomesticos_aires,
    $categoria_electronica_audio_video,
    $categoria_herramientas_construccion,
    $categoria_hogar_muebles_jardin,
    $categoria_industrias_oficinas,
    $categoria_inmuebles,
    $instrumentos_musicales,
    $categoria_joyas_relojes,
    $categoria_juegos_jueguetes,
    $categoria_libros_revistas_comics,
    $categoria_musica_peliculas_series,
    $categoria_ropa_accesorios,
    $categoria_salud_equipamiento,
    $categoria_servicios,
    $categoria_souvenirs_cotillon,
    $categoria_otros
];

function SortByChildsLenghts($array_of_arrays)
{
    $lengths_array = array_map('count', $array_of_arrays);
    arsort($lengths_array);
    foreach (array_keys($lengths_array) as $key) {
        if(!empty($array_of_arrays[$key]))
        {
            $array_of_arrays_ordered[$key] = $array_of_arrays[$key];
        }
    }
    return array_values($array_of_arrays_ordered);
}