<?php


$servername = "localhost"; // Cambia esto al servidor de tu base de datos
$username = "root"; // Cambia esto a tu nombre de usuario de MySQL
$password = ""; // Cambia esto a tu contraseña de MySQL
$database = "septimo";
// Crea la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);
// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: ".$conn->connect_error);
}

//Creación de tablas para la base de datos:

$conn = new mysqli($servername, $username, $password, $database);
// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: ".$conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS docente (
        id_docente INT (255) AUTO_INCREMENT,
        nombre varchar (255) NOT NULL,
        apellido varchar (255) NOT NULL, 
        DNI INT (255) NOT NULL,
        estado VARCHAR (255) NOT NULL,
    );";      

if ($conn->query($sql) === TRUE){
    echo 'Tabla "ventas" creada<br>';
}else{
    echo 'Error en la conexión: '. $conn->connect_error;
}

$sql = "CREATE TABLE IF NOT EXISTS materias (
    id_docente INT (255) AUTO_INCREMENT,
    contenido varchar (255) NOT NULL,
    turno varchar (255) NOT NULL, 
    division INT (255) NOT NULL,
);";      

if ($conn->query($sql) === TRUE){
echo 'Tabla "ventas" creada<br>';
}else{
echo 'Error en la conexión: '. $conn->connect_error;
}

$sql = "ALTER TABLE materias
ADD CONSTRAINT fk_id_docente
FOREIGN KEY (id_docente) REFERENCES docente(id_docente)
ON DELETE CASCADE;";
if ($conn->query($sql) === TRUE){
echo 'Tabla "ventas" creada<br>';
}else{
echo 'Error en la conexión: '. $conn->connect_error;
}



?>