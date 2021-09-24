<?php
require_once("../refresh.php");
require_once("../RecursosAPI/informacion.php");

$id = $_GET["id"];
$id = filter_var($id, FILTER_VALIDATE_INT);

$sql = "SELECT * FROM tokens WHERE user_id = ${id}";
$consulta = mysqli_query($link, $sql);
if (!$consulta) { echo mysqli_error($link); 
    die;}
$usuario = mysqli_fetch_assoc($consulta);

$nickname = $usuario["nickname"];
$pais = $usuario["pais"];

if (!$id) {
    header('Location: /apanel/index.php');
}

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login/login.php");
    exit;
}
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
    <link rel="stylesheet" href="../css/main.css">

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
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse shadow">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <p class="text-center text-uppercase fs-6 fw-bold" style="padding:auto; margin:7px 0 7px 0;">Galarreta Dashboard</p>
                        </li>
                        <hr>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted">
                            <span>Datos del vendedor</span>
                            <a class="link-secondary" href="#" aria-label="Add a new report">
                                <span data-feather="plus-circle"></span>
                            </a>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="#informacion">
                                <span data-feather="file" class="border-bottom"></span>
                                Información
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#metricas">
                                <span data-feather="shopping-cart"></span>
                                Métricas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#publicaciones">
                                <span data-feather="users"></span>
                                Publicaciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/apanel/ranking_ventas.php?id=<?php echo $id ?>">
                                <span data-feather="bar-chart-2"></span>
                                Ranking de productos
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" id="informacion">
                    <h2 class="h2">Publicaciones del usuario: <a href="https://www.mercadolibre.com.ar/perfil/<?php echo $informacion["nickname"] ?>" style="text-decoration: none; color: black;"><?php echo $informacion["nickname"] ?> (CUST ID: <?php echo $id ?>) </a></h2>
                </div>

                <div class="container" style="margin: 10px; padding: 0;">
                    <div class="row">
                        <div class="container contenedor-dashboard" style="margin: 10px; padding: 0; justify-content:space-between; align-items: center;">
                            <div class="row d-flex pt-4" style="align-items:center; justify-content:space-between;">
                                <div class="col-4 d-flex" style="align-items:center; justify-content:space-between; flex-direction:column;">
                                    <h4>Metodos de envío</h4>

                                    <div id="grafico-despachos">

                                    </div>
                                    <?php
                                    require_once("../charts/despachos.php");
                                    ?>

                                </div>

                                <div class="col-6 d-flex" style="flex-direction:column; align-items:center; justify-content:space-between;">
                                    <h4>Categorias</h4>

                                    <?php
                                    require_once("../charts/categorias.php");
                                    ?>
                                </div>
                            </div>
                        </div>
            </main>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/58821011b2.js" crossorigin="anonymous"></script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>