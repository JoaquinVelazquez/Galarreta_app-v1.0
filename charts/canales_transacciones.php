<?php
require_once("../RecursosAPI/ordenes.php");

$total_ventas = count($orden_meli) + count($orden_mshop);
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
    <div style="height: 200px;">
        <canvas id="canales_transacciones"></canvas>
    </div>
    <script crossorigin="anonymous" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('canales_transacciones');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Ventas'],
                datasets: [{
                        label: 'MercadoShop',
                        data: [<?php echo count($orden_mshop); ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',

                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',

                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'MercadoLibre',
                        data: [<?php echo count($orden_meli); ?>],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',

                        ],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        stacked: true,
                        max: <?php echo $total_ventas; ?>,
                        ticks: {
                            display: false
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        grid: {
                            display: false
                        }
                    }
                },
                maintainAspectRatio: false
            }
        });
    </script>

</body>

</html>