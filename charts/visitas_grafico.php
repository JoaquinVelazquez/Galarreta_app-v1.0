<?php
require_once("../RecursosAPI/visitas_grafico.php");

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

    <canvas id="visitas_grafico" width="400" height="400"></canvas>

    <script crossorigin="anonymous" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('visitas_grafico').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [  
                    <?php
                        foreach ($visitas_array as $data){
                            $fecha_format = explode('T', $data["date_from"]);
                            $fecha = $fecha_format[0];
                            $visitas = $data["total_visits"];
                            echo '"' . $fecha . '"' . ',';
                        }
                    ?>
            ],
                datasets: [{
                    label: '',
                    data: [
                        <?php
                            foreach($visitas_array as $data){
                                $fecha_format = explode('T', $data["date_from"]);
                                $fecha = $fecha_format[0];
                                $visitas = $data["total_visits"];
                                echo $visitas . ',';
                            }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false,
            }
        });
    </script>
</body>

</html>