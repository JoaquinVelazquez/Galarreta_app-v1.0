<?php

$pais = $_GET["pais"];

switch ($pais) {
    case "ARGENTINA":
        $link_autenticar = ".com.ar";
        break;
    case "CHILE":
        $link_autenticar = ".cl";
        break;
    case "PERU":
        $link_autenticar = ".com.pe";
        break;
    case "COLOMBIA":
        $link_autenticar = ".com.co";
        break;
    case "BRASIL":
        $link_autenticar = ".com.br";
        break;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galarreta App v2.1 ALPHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>

<body class="fondo-index">
    <ul class="nav justify-content-start">
        <img src="img/png/galarreta-logo.png" alt="">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="https://galarreta.co/">Sitio Oficial</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://galarreta.co/#nosotros">Sobre Nosotros</a>
        </li>
    </ul>

    <div class="container pt-4">
        <h1 class="text-center">Galarreta App v2.1 ALPHA</h1>
        <hr>
        <h3 class="text-center pt-4">
            Haz click
            <a href="https://auth.mercadolibre<?php echo $link_autenticar ?>/authorization?response_type=code&client_id=624787090575020&redirect_uri=http://localhost/autenticacion.php">AQUÍ</a>
            para autenticarte con tu usuario de Mercadolibre
        </h3>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>