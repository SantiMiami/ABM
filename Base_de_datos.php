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

$sql = "CREATE DATABASE IF NOT EXISTS septimo";   
if ($conn->query($sql) === TRUE){
    echo 'Base de datos creada<br>';
}else{
    echo 'Error en la conexión: '. $conn->connect_error;
}

$conn -> close();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Creación de tablas para la base de datos:

$conn = new mysqli($servername, $username, $password, $database);
// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: ".$conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS docente (
        id_docente INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR (255) NOT NULL, 
        apellido VARCHAR (255) NOT NULL,
        DNI INT (8) NOT NULL  
    );";

$sql2 = "CREATE TABLE IF NOT EXISTS materias (
        id_docente INT(255) AUTO_INCREMENT PRIMARY KEY,
        contenido VARCHAR (255) NOT NULL, 
        turno VARCHAR (20) NOT NULL,
        curso INT (10) NOT NULL,
        division INT (10) NOT NULL,
        FOREIGN KEY (id_docente) REFERENCES docente(id_docente)
    );";       
if ($conn->query($sql) === TRUE){
    echo 'Tabla "docente" creada<br>';
}else{
    echo 'Error en la conexión: '. $conn->connect_error;
}

if ($conn->query($sql2) === TRUE){
    echo 'Tabla "materias" creada<br>';
}else{
    echo 'Error en la conexión: '. $conn->connect_error;
}

$conn -> close();

/*
FOREIGN KEY (id_docente) REFERENCES docente(id_docentes)
ON UPDATE CASCADE
ON DELETE CASCADE 
*/
?>