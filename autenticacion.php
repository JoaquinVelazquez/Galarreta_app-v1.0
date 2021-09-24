<?php

include_once("DB/config.php");

//Obtener $code
$urlInfo = $_SERVER["REQUEST_URI"];
$urlQuery = parse_url($urlInfo, PHP_URL_QUERY);
$code = explode('=', $urlQuery);

$SERVER_GENERATED_AUTHORIZATION_CODE = ($code[1]);

////////////////////////////////////////////////

//GENERAR BEARER TOKEN

$url = "https://api.mercadolibre.com/oauth/token";

$data = array(
    'grant_type' => 'authorization_code',
    'client_id' => '624787090575020',
    'client_secret' => 'OtbNMR17kSC5nuFuU7fZXNBDyPiaR5UQ',
    'code' => $SERVER_GENERATED_AUTHORIZATION_CODE,
    'redirect_uri' => 'http://localhost/autenticacion.php'
);

// var_dump($data);

$post = http_build_query($data);

// var_dump($post);

$header = array(
    'Accept' => 'application/json',
    'Content_Type' => 'application/x-www-form-urlencoded'
);

$options = array(
    CURLOPT_RETURNTRANSFER => 'true',
    CURLOPT_HTTPHEADER => $header,
    CURLOPT_SSL_VERIFYPEER => 'false',
    CURLOPT_URL => $url,
    CURLOPT_POSTFIELDS => $post,
    CURLOPT_CUSTOMREQUEST => "POST",
);

// do a curl call
$call = curl_init();
curl_setopt_array($call, $options);
// execute the curl call
$response = curl_exec($call);
// get the curl status
$status = curl_getinfo($call);
// close the call
curl_close($call);
// transform the json in array
$response = (array) json_decode($response);
//var_dump($response);

$ch = curl_init();
//Apí Link
$url_name = "https://api.mercadolibre.com/users/" . $response["user_id"];
// set url
curl_setopt($ch, CURLOPT_URL, $url_name);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $output contains the output string
$output = curl_exec($ch);
// close curl resource to free up system resources
curl_close($ch);
//DD info
$informacion = (json_decode($output, true));
//var_dump($informacion);

////////////////////////////////////////////////

//INSERTAR DATOS EN LA DB

$user_id = ($response["user_id"]);
$nickname = ($informacion["nickname"]);
$access_token = ($response["access_token"]);
$refresh_token = ($response["refresh_token"]);
$expires_in = ($response["expires_in"]);
$pais = ($response["country_id"]);

$stmt = $link->prepare("INSERT INTO tokens (user_id, nickname, access_token, refresh_token, expires_in, pais) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('isssis', $user_id, $nickname, $access_token, $refresh_token, $expires_in);
$stmt->execute();
$stmt->close();
$link->close();
header("refresh:3;url=/");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galarreta App v3.0 ALPHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div class="container pt-4">
        <h1 class="text-center">Autenticación Exitosa!</h1>
        <hr>
        <h3 class="text-center pt-4 pb-4">
            Gracias por confiar en Galarreta, en breve será redirigido.
        </h3>

        <div class="loader container center pt-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>