<?php


session_start();
if (time() > $_SESSION['Tiempo']){
        session_destroy();
        header("Location:Inicio_de_sesion.php");
}

$nombre = $_SESSION['nombre'][$i];
$apellido = $_SESSION['apellido'][$i];
$DNI = $_SESSION['DNI'][$i];
$contenido = $_SESSION['contenido'][$i];
$turno = $_SESSION['turno'][$i];
$curso = $_SESSION['curso'][$i];
$division = $_SESSION['division'][$i];

print_r($_SESSION['nombre'][$i]);
echo "<br>";
print_r($_SESSION['apellido'][$i]);
echo "<br>";
print_r($_SESSION['DNI'][$i]);
echo "<br>";
print_r($_SESSION['contenido'][$i]);
echo "<br>";
print_r($_SESSION['turno'][$i]);
echo "<br>";
print_r($_SESSION['curso'][$i]);
echo "<br>";
print_r($_SESSION['division'][$i]);
echo "<br>";

echo "Docente modificado";
echo "<form action='inicio_de_sesion.php' method='post'>
        <button type='submit'>Volver</button>";


echo $nombre;
echo "<br>";
echo $apellido;
echo "<br>";
echo $DNI;
echo "<br>";
echo $contenido;
echo "<br>";
echo $turno;
echo "<br>";
echo $curso;
echo "<br>";
echo $division;
echo "<br>";

?>