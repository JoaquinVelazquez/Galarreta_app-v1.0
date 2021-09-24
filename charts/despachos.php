<?php
require_once("../RecursosAPI/ordenes.php");
require_once("../RecursosAPI/envios.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>charts</title>
</head>

<body>

    <?php
    //var_dump($visitas);
    ?>

    <canvas id="visitas" width="400" height="400"></canvas>

    <script crossorigin="anonymous" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('visitas');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    <?php if (count($mercado_envios_array) > 0) { ?> 'Mercado Envíos = ' + <?php echo count($mercado_envios_array) ?>,
                    <?php } ?>
                    <?php if (count($mercado_envios_places_array) > 0) { ?> 'Punto de despacho = ' + <?php echo count($mercado_envios_places_array) ?>,
                    <?php } ?>
                    <?php if (count($mercado_envios_colecta_array) > 0) { ?> 'Mercado Envíos Colecta = ' + <?php echo count($mercado_envios_colecta_array) ?>,
                    <?php } ?>
                    <?php if (count($mercado_envios_flex_array) > 0) { ?> 'Mercado Envíos Flex = ' + <?php echo count($mercado_envios_flex_array) ?>,
                    <?php } ?>
                    <?php if (count($mercado_envios_full_array) > 0) { ?> 'Mercado Envíos Full = ' + <?php echo count($mercado_envios_full_array) ?>,
                    <?php } ?>
                    <?php if (count($no_entregado_array) > 0) { ?> 'Acordado con el vendedor = ' + <?php echo count($no_entregado_array) ?>,
                    <?php } ?>
                    <?php if (count($otro_envio_array) > 0) { ?> 'Pendiente de entrega = ' + <?php echo count($otro_envio_array) ?>
                    <?php } ?>
                ],
                datasets: [{
                    label: '# of Votes',
                    data: [
                        <?php echo count($mercado_envios_array) ?>,
                        <?php echo count($mercado_envios_places_array) ?>,
                        <?php echo count($mercado_envios_colecta_array) ?>,
                        <?php echo count($mercado_envios_flex_array) ?>,
                        <?php echo count($mercado_envios_full_array) ?>,
                        <?php echo count($no_entregado_array) ?>,
                        <?php echo count($otro_envio_array) ?>,
                    ],
                    backgroundColor: [
                        <?php if (count($mercado_envios_array) > 0) { ?> '#0B5345',
                        <?php } ?>
                        <?php if (count($mercado_envios_places_array) > 0) { ?> '#0E6655',
                        <?php } ?>
                        <?php if (count($mercado_envios_colecta_array) > 0) { ?> '#117A65',
                        <?php } ?>
                        <?php if (count($mercado_envios_flex_array) > 0) { ?> '#138D75',
                        <?php } ?>
                        <?php if (count($mercado_envios_full_array) > 0) { ?> '#16A085',
                        <?php } ?>
                        <?php if (count($no_entregado_array) > 0) { ?> '#45B39D',
                        <?php } ?>
                        <?php if (count($otro_envio_array) > 0) { ?> '#73C6B6',
                        <?php } ?>
                    ]
                }]
            },
        });

        let url = $url;

        console.log(url);
    </script>

</body>

</html>