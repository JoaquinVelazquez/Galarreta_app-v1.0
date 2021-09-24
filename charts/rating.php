<?php
require_once("../RecursosAPI/informacion.php");

$rating_positivo=$informacion["seller_reputation"]["transactions"]["ratings"]["positive"];
$rating_negativo=$informacion["seller_reputation"]["transactions"]["ratings"]["negative"];
$rating_neutral=$informacion["seller_reputation"]["transactions"]["ratings"]["neutral"]
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
    <canvas id="rating" width="400" height="400"></canvas>

    <script crossorigin="anonymous" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('rating');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Rating Positivo', 'Rating Negativo', 'Rating Neutral'],
                datasets: [{
                    label: '# of Votes',
                    data: [<?php echo $rating_positivo; ?>, <?php echo $rating_negativo; ?>, <?php echo $rating_neutral; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ]
                }]
            },
        });
    </script>

</body>

</html>