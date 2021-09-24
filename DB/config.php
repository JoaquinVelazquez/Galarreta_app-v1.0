<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', '35.209.41.117');
define('DB_USERNAME', 'upupc7ptyg2ll');
define('DB_PASSWORD', 'bl2wze5sbcg4');
define('DB_NAME', 'dbndmhjb6x1nkg');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>