<?php
require_once("../RecursosAPI/visitas.php");

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
            type: 'pie',
            data: {
                labels: ['Transacciones Canceladas', 'Transacciones Completadas'],
                datasets: [{
                    label: '# of Votes',
                    data: [<?php echo $transacciones_canceladas; ?>, <?php echo $transacciones_completadas; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ]
                }]
            },
        });

        let url = $url;

        console.log(url);
    </script>

</body>

</html>