<?php
$servername = "localhost";
$username = "root2";
$password = "";
$dbname = "cplazos";
$port = "3306";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}else{echo "hola";}
?>
