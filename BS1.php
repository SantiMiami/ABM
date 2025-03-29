<?php


//Elementos para la conexión a la base de datos:

$servername = "localhost"; // Cambia esto al servidor de tu base de datos
$username = "root"; // Cambia esto a tu nombre de usuario de MySQL
$password = ""; // Cambia esto a tu contraseña de MySQL
$database = "septimo";
// Crea la conexión a la base de datos
$conn = new mysqli($servername, $username, $password);
// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: ".$conn->connect_error);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Creación de la base de datos:

$sql = "CREATE DATABASE IF NOT EXISTS $database";   
if ($conn->query($sql) === TRUE){
    echo 'Base de datos creada<br>';
    $conn -> close();
    header('Location: BS2.php');
}else{
    echo 'Error en la conexión: '. $conn->connect_error;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
