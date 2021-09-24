<?php
include_once("DB/config.php");

$sql = "SELECT * FROM paises";

$datos = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galarreta App v3.0 ALPHA</title>
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
            Por favor, seleccione su pais para poder continuar
        </h3>

        <div class="d-flex pt-4 mb-3" style="align-items: center; justify-content: center;">
            <form action="autenticar.php?pais=<?php echo $paises["pais"] ?>" class="d-flex" style="justify-content: space-between;">
                <select name="pais" id="pais" class="form-select">
                    <option value="" disabled selected>--Seleccione un pais--</option>
                    <?php while ($paises = mysqli_fetch_assoc($datos)) : ?>
                        <option value="<?php echo $paises["pais"] ?>"><?php echo $paises["pais"] ?></option>
                    <?php endwhile; ?>
                </select>
                <input type="submit" class="btn btn-primary boton-submit">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>