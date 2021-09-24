<?php
require_once("../DB/config.php");
$id = trim($_GET["id"]);
$id = filter_var($id, FILTER_VALIDATE_INT);
$sql = "SELECT * FROM tokens WHERE user_id = ${id}";
/*
echo "<pre>";
var_dump($sql);
echo "</pre>";
*/
$consulta = mysqli_query($link, $sql);
if (!$consulta) { echo mysqli_error($link); 
    die;}
$usuario = mysqli_fetch_assoc($consulta);
?>