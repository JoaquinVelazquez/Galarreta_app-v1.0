<?php
include_once("../DB/config.php");
require_once("../RecursosAPI/ordenes_30_dias.php");
require_once("../RecursosAPI/informacion.php");

$sql = "SELECT * FROM tokens";

$datos = mysqli_query($link, $sql);
if (!$datos) { echo mysqli_error($link); 
    die;}

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login/login.php");
    exit;
}

$total_dinero_array = array();

foreach ($ranking_publicaciones_precio as $data) {
    array_push($total_dinero_array, $data["total_dinero"]);
}

$total_cantidad_array = array();

foreach ($ranking_publicaciones_precio as $data) {
    array_push($total_cantidad_array, $data["total_cantidad"]);
}

$ranking_total_dinero_array = array();
$ranking_total_cantidad_array = array();

if (count($ranking_publicaciones_precio) > 20) {
    for ($i = 0; $i < 20; $i++) {
        array_push($ranking_total_dinero_array, $ranking_publicaciones_precio[$i]["total_dinero"]);
        array_push($ranking_total_cantidad_array, $ranking_publicaciones_precio[$i]["total_cantidad"]);
    }
} else {
    for ($i = 0; $i < count($ranking_publicaciones_precio); $i++) {
        array_push($ranking_total_dinero_array, $ranking_publicaciones_precio[$i]["total_dinero"]);
        array_push($ranking_total_cantidad_array, $ranking_publicaciones_precio[$i]["total_cantidad"]);
    }
}



$ranking_total_dinero = array_sum($ranking_total_dinero_array);
$ranking_total_cantidad = array_sum($ranking_total_cantidad_array);
$total_dinero = array_sum($total_dinero_array);
$total_unidades = array_sum($total_cantidad_array);
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Galarreta Dashboard</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/apanel/index.php">Galarreta Dashboard v2.1 alpha</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="../login/logout.php">Cerrar sesión</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <p class="text-center text-uppercase fs-6 fw-bold" style="padding:auto; margin:7px 0 7px 0;">Galarreta Dashboard</p>
                        </li>
                        <hr>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted">
                            <span>Datos del vendedor</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="/apanel/informacion.php">
                                <span data-feather="file"></span>
                                Información
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="shopping-cart"></span>
                                Métricas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="users"></span>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="bar-chart-2"></span>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="layers"></span>
                                Integrations
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Last quarter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Social engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Year-end sale
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2 class="h2">Ranking de productos del usuario: <a href="https://www.mercadolibre.com.ar/perfil/<?php echo $informacion["nickname"] ?>" style="text-decoration: none; color: black;"><?php echo $informacion["nickname"] ?> (CUST ID: <?php echo $id ?>) </a></h2>
                </div>

                <h4 class="text-center">Ranking por GMV (Ultimos 30 dias)</h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Foto</th>
                            <th scope="col" class="text-center">Producto</th>
                            <th scope="col" class="text-center">Dinero</th>
                            <th scope="col" class="text-center">Porcentaje</th>
                            <th scope="col" class="text-center">Full</th>
                            <th scope="col" class="text-center">Flex</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($ranking_publicaciones_precio) > 20) { ?>
                            <?php for ($i = 0; $i < 20; $i++) { ?>
                                <tr>
                                    <th scope="row" class="text-center"> <a href="<?php echo $ranking_publicaciones_precio[$i]['link'] ?>"><?php echo $ranking_publicaciones_precio[$i]["id_producto"] ?></a></th>
                                    <td class="text-center"> <img class="thumb-ranking" src="<?php echo $ranking_publicaciones_precio[$i]["imagen"] ?>" alt="foto"></td>
                                    <td class="text-center"><?php echo $ranking_publicaciones_precio[$i]["nombre_producto"] ?></td>
                                    <td class="text-center">$<?php echo number_format($ranking_publicaciones_precio[$i]["total_dinero"], 2) ?></td>
                                    <td class="text-center">
                                        <?php echo number_format((($ranking_publicaciones_precio[$i]["total_dinero"] / $total_dinero) * 100), 2); ?>%
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_precio[$i]["envio_full"] == "fulfillment") {
                                            echo "Sí";
                                        } else {
                                            echo "No";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_precio[$i]["envio_flex"] == "self_service_in") {
                                            echo "Sí";
                                        } else {
                                            echo "No";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_precio[$i]["status"] == "active") {
                                            echo "Activa";
                                        } elseif ($ranking_publicaciones_precio[$i]["status"] == "paused") {
                                            echo "Pausada";
                                        } else {
                                            echo "Cerrada";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_precio[$i]["tipo"] == "gold_pro") {
                                            echo "Premium";
                                        } elseif ($ranking_publicaciones_precio[$i]["tipo"] == "gold_special") {
                                            echo "Clásica";
                                        } else {
                                            echo "Gratuita";
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <?php for ($i = 0; $i < count($ranking_publicaciones_precio); $i++) { ?>
                                <tr>
                                    <th scope="row" class="text-center"> <a href="<?php echo $ranking_publicaciones_precio[$i]['link'] ?>"><?php echo $ranking_publicaciones_precio[$i]["id_producto"] ?></a></th>
                                    <td class="text-center"> <img class="thumb-ranking" src="<?php echo $ranking_publicaciones_precio[$i]["imagen"] ?>" alt="foto"></td>
                                    <td class="text-center"><?php echo $ranking_publicaciones_precio[$i]["nombre_producto"] ?></td>
                                    <td class="text-center">$<?php echo number_format($ranking_publicaciones_precio[$i]["total_dinero"], 2) ?></td>
                                    <td class="text-center">
                                        <?php echo number_format((($ranking_publicaciones_precio[$i]["total_dinero"] / $total_dinero) * 100), 2); ?>%
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_precio[$i]["envio_full"] == "fulfillment") {
                                            echo "Sí";
                                        } else {
                                            echo "No";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_precio[$i]["envio_flex"] == "self_service_in") {
                                            echo "Sí";
                                        } else {
                                            echo "No";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_precio[$i]["status"] == "active") {
                                            echo "Activa";
                                        } elseif ($ranking_publicaciones_precio[$i]["status"] == "paused") {
                                            echo "Pausada";
                                        } else {
                                            echo "Cerrada";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_precio[$i]["tipo"] == "gold_pro") {
                                            echo "Premium";
                                        } elseif ($ranking_publicaciones_precio[$i]["tipo"] == "gold_special") {
                                            echo "Clásica";
                                        } else {
                                            echo "Gratuita";
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>

                <h4>Total porcentaje: <?php echo number_format((($ranking_total_dinero / $total_dinero) * 100), 2); ?>%</h4>

                <hr>

                <h4 class="text-center pt-4">Ranking por unidades vendidas (Ultimos 30 dias)</h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Foto</th>
                            <th scope="col" class="text-center">Producto</th>
                            <th scope="col" class="text-center">Cantidad</th>
                            <th scope="col" class="text-center">Porcentaje</th>
                            <th scope="col" class="text-center">Full</th>
                            <th scope="col" class="text-center">Flex</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($ranking_publicaciones_unidades) > 20) { ?>
                            <?php for ($i = 0; $i < 20; $i++) { ?>
                                <tr>
                                    <th scope="row" class="text-center"> <a href="<?php echo $ranking_publicaciones_unidades[$i]['link'] ?>"><?php echo $ranking_publicaciones_unidades[$i]["id_producto"] ?></a></th>
                                    <td class="text-center"> <img class="thumb-ranking" src="<?php echo $ranking_publicaciones_unidades[$i]["imagen"] ?>" alt="foto"></td>
                                    <td class="text-center"><?php echo $ranking_publicaciones_unidades[$i]["nombre_producto"] ?></td>
                                    <td class="text-center"><?php echo $ranking_publicaciones_unidades[$i]["total_cantidad"] ?></td>
                                    <td class="text-center">
                                        <?php echo number_format((($ranking_publicaciones_unidades[$i]["total_cantidad"] / $total_unidades) * 100), 2); ?>%
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_unidades[$i]["envio_full"] == "fulfillment") {
                                            echo "Sí";
                                        } else {
                                            echo "No";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_unidades[$i]["envio_flex"] == "self_service_in") {
                                            echo "Sí";
                                        } else {
                                            echo "No";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_unidades[$i]["status"] == "active") {
                                            echo "Activa";
                                        } elseif ($ranking_publicaciones_unidades[$i]["status"] == "paused") {
                                            echo "Pausada";
                                        } else {
                                            echo "Cerrada";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_unidades[$i]["tipo"] == "gold_pro") {
                                            echo "Premium";
                                        } elseif ($ranking_publicaciones_unidades[$i]["tipo"] == "gold_special") {
                                            echo "Clásica";
                                        } else {
                                            echo "Gratuita";
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <?php for ($i = 0; $i < count($ranking_publicaciones_unidades); $i++) { ?>
                                <tr>
                                    <th scope="row" class="text-center"> <a href="<?php echo $ranking_publicaciones_unidades[$i]['link'] ?>"><?php echo $ranking_publicaciones_unidades[$i]["id_producto"] ?></a></th>
                                    <td class="text-center"> <img class="thumb-ranking" src="<?php echo $ranking_publicaciones_unidades[$i]["imagen"] ?>" alt="foto"></td>
                                    <td class="text-center"><?php echo $ranking_publicaciones_unidades[$i]["nombre_producto"] ?></td>
                                    <td class="text-center"><?php echo $ranking_publicaciones_unidades[$i]["total_cantidad"] ?></td>
                                    <td class="text-center">
                                        <?php echo number_format((($ranking_publicaciones_unidades[$i]["total_cantidad"] / $total_unidades) * 100), 2); ?>%
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_unidades[$i]["envio_full"] == "fulfillment") {
                                            echo "Sí";
                                        } else {
                                            echo "No";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_unidades[$i]["envio_flex"] == "self_service_in") {
                                            echo "Sí";
                                        } else {
                                            echo "No";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_unidades[$i]["status"] == "active") {
                                            echo "Activa";
                                        } elseif ($ranking_publicaciones_unidades[$i]["status"] == "paused") {
                                            echo "Pausada";
                                        } else {
                                            echo "Cerrada";
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($ranking_publicaciones_unidades[$i]["tipo"] == "gold_pro") {
                                            echo "Premium";
                                        } elseif ($ranking_publicaciones_unidades[$i]["tipo"] == "gold_special") {
                                            echo "Clásica";
                                        } else {
                                            echo "Gratuita";
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
                <h4>Total porcentaje: <?php echo number_format((($ranking_total_cantidad / $total_unidades) * 100), 2); ?>%</h4>
                <hr>
            </main>
        </div>
    </div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>