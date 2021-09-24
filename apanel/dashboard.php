<?php
require_once("../DB/get_token.php");
require_once("../refresh.php");
require_once("../RecursosAPI/informacion.php");
require_once("../RecursosAPI/ordenes.php");
require_once("../RecursosAPI/publicaciones.php");
require_once("../RecursosAPI/visitas_60_dias.php");

/*
echo "<pre>";
var_dump($usuario);
echo "</pre>";
*/
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
                            <a class="nav-link" href="/apanel/publicaciones.php?id=<?php echo $id ?>">
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
                    <h2 class="h2">Información del usuario: <a href="https://www.mercadolibre.com.ar/perfil/<?php echo $informacion["nickname"] ?>" style="text-decoration: none; color: black;"><?php echo $informacion["nickname"] ?> (CUST ID: <?php echo $id ?>) </a></h2>
                </div>

                <div class="container" style="margin: 10px; padding: 0;">
                    <div class="row">
                        <div class="col-1">
                            <?php if (isset($informacion["thumbnail"]["picture_url"])) { ?>
                                <img class="img-fluid rounded" src="<?php echo $informacion["thumbnail"]["picture_url"]; ?>" alt="thumbnail" style="margin: auto; padding: auto;">
                            <?php } else { ?>
                                <p>Imagen de perfil no disponible</p>
                            <?php } ?>
                        </div>
                        <div class="col-4">
                            <h4 class="h4">Reputación</h4>

                            <?php
                            $periodo = $informacion["seller_reputation"]["metrics"]["sales"]["period"];
                            $periodo = explode(" ", $periodo);
                            $ventas = $informacion["seller_reputation"]["metrics"]["sales"]["completed"];
                            ?>

                            <p>
                                <?php echo $ventas ?> ventas realizadas en los ultimos <?php echo $periodo[0];
                                                                                        echo (" ");
                                                                                        print ($periodo[1] == "days") ? "dias" : "meses"; ?>.
                            </p>

                            <?php if ($informacion["seller_reputation"]["level_id"] == "5_green") { ?>
                                <div class="d-flex" style="align-items: center;">
                                    <div class="rectangulo_rojo disabled"></div>
                                    <div class="rectangulo_naranja disabled"></div>
                                    <div class="rectangulo_amarillo disabled"></div>
                                    <div class="rectangulo_verde_claro disabled"></div>
                                    <div class="rectangulo_verde_oscuro selected"></div>
                                </div>
                            <?php } elseif ($informacion["seller_reputation"]["level_id"] == "4_light_green") { ?>
                                <div class="d-flex" style="align-items: center;">
                                    <div class="rectangulo_rojo disabled"></div>
                                    <div class="rectangulo_naranja disabled"></div>
                                    <div class="rectangulo_amarillo disabled"></div>
                                    <div class="rectangulo_verde_claro selected"></div>
                                    <div class="rectangulo_verde_oscuro disabled"></div>
                                </div>
                            <?php } elseif ($informacion["seller_reputation"]["level_id"] == "3_yellow") { ?>
                                <div class="d-flex" style="align-items: center;">
                                    <div class="rectangulo_rojo disabled"></div>
                                    <div class="rectangulo_naranja disabled"></div>
                                    <div class="rectangulo_amarillo selected"></div>
                                    <div class="rectangulo_verde_claro disabled"></div>
                                    <div class="rectangulo_verde_oscuro disabled"></div>
                                </div>
                            <?php } elseif ($informacion["seller_reputation"]["level_id"] == "2_orange") { ?>
                                <div class="d-flex" style="align-items: center;">
                                    <div class="rectangulo_rojo disabled"></div>
                                    <div class="rectangulo_naranja selected"></div>
                                    <div class="rectangulo_amarillo disabled"></div>
                                    <div class="rectangulo_verde_claro disabled"></div>
                                    <div class="rectangulo_verde_oscuro disabled"></div>
                                </div>
                            <?php } elseif ($informacion["seller_reputation"]["level_id"] == "1_red") { ?>
                                <div class="d-flex" style="align-items: center;">
                                    <div class="rectangulo_rojo selected"></div>
                                    <div class="rectangulo_naranja disabled"></div>
                                    <div class="rectangulo_amarillo disabled"></div>
                                    <div class="rectangulo_verde_claro disabled"></div>
                                    <div class="rectangulo_verde_oscuro disabled"></div>
                                </div>
                            <?php } else { ?>
                                <div class="d-flex" style="align-items: center;">
                                    <div class="rectangulo_rojo disabled"></div>
                                    <div class="rectangulo_naranja disabled"></div>
                                    <div class="rectangulo_amarillo disabled"></div>
                                    <div class="rectangulo_verde_claro disabled"></div>
                                    <div class="rectangulo_verde_oscuro disabled"></div>
                                </div>

                                <p>Este usuario no tiene suficientes ventas</p>
                            <?php } ?>

                            <?php if ($informacion["seller_reputation"]["power_seller_status"] == "platinum") { ?>
                                <div class="d-flex">
                                    <p>MercadoLider Platino</p>
                                </div>
                            <?php } elseif ($informacion["seller_reputation"]["power_seller_status"] == "gold") { ?>
                                <div class="d-flex">
                                    <p>MercadoLider Oro</p>
                                </div>
                            <?php } elseif ($informacion["seller_reputation"]["power_seller_status"] == NULL) { ?>
                                <br>
                            <?php } else { ?>
                                <div class="d-flex">
                                    <p>MercadoLider Estandar</p>
                                </div>
                            <?php } ?>

                            <h4 class="h4">Ubicación</h4>

                            <div class="d-flex" style="flex-direction:row;">
                                <p>
                                    <?php echo $informacion["address"]["city"] . ", " . $informacion["address"]["state"]; ?>
                                </p>
                                <?php if($pais == "AR"){ ?>
                                    <img src="../img/png/bandera-arg.png" alt="bandera_ar" class="banderas">
                                <?php } ?>
                                <?php if($pais == "CL"){ ?>
                                    <img src="../img/png/bandera-chi.png" alt="bandera_cl" class="banderas">
                                <?php } ?>
                                <?php if($pais == "PE"){ ?>
                                    <img src="../img/png/bandera-per.png" alt="bandera_pe" class="banderas">
                                <?php } ?>
                                <?php if($pais == "CO"){ ?>
                                    <img src="../img/png/bandera-col.png" alt="bandera_co" class="banderas">
                                <?php } ?>
                                <?php if($pais == "BR"){ ?>
                                    <img src="../img/png/bandera-bra.png" alt="bandera_br" class="banderas">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-4">
                            <?php
                            include_once("../includes/resenias.php");
                            ?>

                            <div class="atencion">
                                <div class="d-flex" style="text-align: center; align-items:center" ;>
                                    <div class="contenedor_imagen_mensaje">
                                        <img class="mensajes_img" src="../img/png/mensajes.png" alt="mensajes.png">
                                        <?php if ($metrica_uno_titulo == "Brinda buena atención") { ?>

                                            <i class="fas fa-check-circle mensajes_icon" ;></i>

                                        <?php } elseif ($metrica_uno_titulo == "Atención brindada a sus compradores") { ?>

                                            <i class="fas fa-minus-circle mensajes_icon"></i>

                                        <?php } else { ?>

                                            <i class="fas fa-times-circle mensajes_icon"></i>

                                        <?php } ?>
                                    </div>

                                    <div class="ml-4 metricas_texto">
                                        <h4><?php echo $metrica_uno_titulo; ?></h4>
                                        <?php if ($metrica_uno_titulo == "Brinda buena atención") { ?>

                                            <p>Sus compradores estan satisfechos.</p>

                                        <?php } elseif ($metrica_uno_titulo == "Atención brindada a sus compradores") { ?>

                                            <p>Aún no podemos calcularlo.</p>

                                        <?php } else { ?>

                                            <p>Sus compradores no estan satisfechos.</p>

                                        <?php } ?>
                                    </div>

                                </div>
                            </div>

                            <br>

                            <div class="despacho">
                                <div class="d-flex" style="text-align: center; align-items:center;">
                                    <div class="contenedor_imagen_despacho">
                                        <img class="mensajes_img" src="../img/png/despacho.png" alt="mensajes.png">
                                        <?php if ($metrica_uno_titulo == "Brinda buena atención") { ?>

                                            <i class="fas fa-check-circle despacho_icon" ;></i>

                                        <?php } elseif ($metrica_uno_titulo == "Atención brindada a sus compradores") { ?>

                                            <i class="fas fa-minus-circle despacho_icon"></i>

                                        <?php } else { ?>

                                            <i class="fas fa-times-circle despacho_icon"></i>

                                        <?php } ?>
                                    </div>

                                    <div class="ml-4 metricas_texto">
                                        <h5><?php echo $metrica_dos_titulo; ?></h5>
                                        <?php if ($metrica_dos_titulo == "Despacha sus productos a tiempo") { ?>

                                            <p>Sus productos llegan sin demora.</p>

                                        <?php } elseif ($metrica_dos_titulo == "Entrega sus productos a tiempo") { ?>

                                            <p>Sus productos llegan sin demora.</p>

                                        <?php } elseif ($metrica_dos_titulo == "Tiempo en despachar sus productos") { ?>

                                            <p>Aún no podemos calcularlo.</p>

                                        <?php } else { ?>

                                            <p>Sus productos llegan con demora.</p>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-3 porcentajes">
                            <h4>% de reclamos</h4>
                            <p><?php echo $informacion["seller_reputation"]["metrics"]["claims"]["rate"] * 100 ?>%</p>
                            <br>
                            <h4>% de retrasos</h4>
                            <p><?php echo $informacion["seller_reputation"]["metrics"]["delayed_handling_time"]["rate"] * 100 ?>%</p>
                            <br>
                        </div>

                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-top" id="metricas">
                            <h2 class="h2">Metricas del usuario ultimos 60 dias: <a href="https://www.mercadolibre.com.ar/perfil/<?php echo $informacion["nickname"] ?>" style="text-decoration: none; color: black;"><?php echo $informacion["nickname"] ?></a></h2>
                        </div>

                        <div class="container contenedor-dashboard" style="margin: 10px; padding: 0; justify-content:space-between; align-items: center;">
                            <div class="row d-flex pb-4" style="justify-content: space-evenly; align-items: center;">
                                <div class="col-4 d-flex" style="flex-direction: row; text-align: center; align-items: center; justify-content: center;">
                                    <div>
                                        <h4 style="text-align: center;">Transacciones Realizadas</h4>

                                        <?php
                                        $transacciones_canceladas = $informacion["seller_reputation"]["transactions"]["canceled"];
                                        $transacciones_completadas = $informacion["seller_reputation"]["transactions"]["completed"];
                                        $transacciones_totales = (count($orden_meli) + count($orden_mshop));
                                        ?>

                                        <p class="h2"><?php echo $transacciones_totales; ?></p>

                                        <br>

                                        <h4 style="text-align: center;">Unidades Totales Vendidas</h4>

                                        <p class="h2"><?php echo array_sum($unidades_array); ?></p>

                                        <br>

                                        <h4 style="text-align: center;">Valor Total en Pesos</h4>

                                        <?php
                                        $total_dinero = array_sum($dinero_meli_array) + array_sum($dinero_mshop_array);
                                        ?>
                                        <p class="h2">$<?php echo number_format($total_dinero); ?></p>

                                        <br>

                                        <h4 style="text-align: center;">Publicaciones activas:</h4>
                                        <p class="h2"><?php echo number_format($total_publicaciones); ?></p>
                                    </div>
                                </div>

                                <div class="col-8" style="text-align: center;">
                                    <h4 style="text-align: center;">Canal de venta (transacciones)</h4>

                                    <?php
                                    require_once("../charts/canales_transacciones.php");
                                    ?>

                                    <div class="d-flex" style="justify-content: space-between;">
                                        <div>
                                            <p>
                                                Mercadoshops: <?php if(count($orden_mshop) > 0){ ?>
                                                    <?php echo count($orden_mshop); ?> (<?php echo number_format(((count($orden_mshop) / $transacciones_totales) * 100), 2); ?>%)
                                                <?php } else { ?>
                                                    0
                                                <?php } ?>
                                            </p>
                                            <img src="../img/png/logo_mercadoshops.png" alt="logo_mercadoshops" class="logos">
                                        </div>
                                        <div>
                                            <p>
                                                MercadoLibre: <?php if(count($orden_meli) > 0){ ?>
                                                    <?php echo count($orden_meli); ?> (<?php echo number_format(((count($orden_meli) / $transacciones_totales) * 100), 2); ?>%)
                                                <?php } else { ?>
                                                    0
                                                <?php } ?>
                                            </p>
                                            <img src="../img/png/logo_mercadolibre.png" alt="logo_mercadoshops" class="logos">
                                        </div>

                                    </div>
                                    <br>
                                    <h4 style="text-align: center;">Canal de venta (dinero)</h4>

                                    <?php
                                    require_once("../charts/canales_dinero.php");
                                    ?>

                                    <div class="d-flex" style="justify-content: space-between;">
                                        <div>
                                            <p>
                                                Mercadoshops: <?php if(array_sum($dinero_mshop_array) > 0){ ?>
                                                    $<?php echo number_format(array_sum($dinero_mshop_array), 2); ?> (<?php echo number_format(((array_sum($dinero_mshop_array) / $total_dinero) * 100), 2); ?>%)
                                                <?php } else { ?>
                                                    0
                                                <?php } ?>
                                            </p>
                                            <img src="../img/png/logo_mercadoshops.png" alt="logo_mercadoshops" class="logos">
                                        </div>
                                        <div>
                                            <p>
                                                MercadoLibre: <?php if(array_sum($dinero_meli_array) > 0){ ?>
                                                    $<?php echo number_format(array_sum($dinero_meli_array), 2); ?> (<?php echo number_format(((array_sum($dinero_meli_array) / $total_dinero) * 100), 2); ?>%)
                                                <?php } else { ?>
                                                    0
                                                <?php } ?>
                                            </p>
                                            <img src="../img/png/logo_mercadolibre.png" alt="logo_mercadoshops" class="logos">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row d-flex pt-4" style="justify-content: space-evenly; align-items:center; justify-content:space-between; margin: 0 auto;">
                                <h3 class="text-center mb-4">
                                    <?php if(isset($visitas["total_visits"])){ ?>
                                        Visitas Ultimos 60 dias: <?php echo number_format(($visitas["total_visits"])); ?>
                                    <?php } else{ ?>
                                        Visitas Ultimos 60 dias: 0
                                    <?php } ?>
                                </h3>

                                <div class="col- d-flex">
                                    <?php
                                    require_once("../charts/visitas_grafico.php");
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