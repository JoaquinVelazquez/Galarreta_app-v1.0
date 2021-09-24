<?php
require_once("../RecursosAPI/categorias.php");

$total_publicaciones = count($publicaciones_array);
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
    <canvas id="categorias"></canvas>
    <script crossorigin="anonymous" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('categorias');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    foreach (SortByChildsLenghts($array_categorias) as $data) {
                        echo '"' . $data[0]["nombre_categoria_principal"]. " = " . count($data) . " (" . number_format(((count($data) / $total_publicaciones) * 100), 2) . "%" . ")" . '"' . ',';
                    }
                    ?>
                ],
                datasets: [{
                    label: 'Publicaciones',
                    data: [
                        <?php
                        foreach (SortByChildsLenghts($array_categorias) as $data) {
                            echo count($data) . ',';
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        max: <?php echo count($categorias_array); ?>,
                        ticks: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    </script>

</body>

</html>