<?php
$servername = "localhost"; // Cambia esto al servidor de tu base de datos
$username = "root"; // Cambia esto a tu nombre de usuario de MySQL
$password = ""; // Cambia esto a tu contraseña de MySQL
$database = "septimo"; // Cambia esto a tu nombre de base de datos
// Crea la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);


// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: ".$conn->connect_error);
}
session_start();
if (isset($_POST['accion'])) $Tipo_de_cambio = $_POST['accion'];
$Sector = (isset($_POST['Sector'])) ? $_POST['Sector'] : "None";

//session_unset();

//Almacenar los elemenntos de acuerdo a si estan definidos o no
$bolInsert = false;
//unset($_SESSION['acciones']);
//Definicion de identificadores de elementos
//////////////////////////////////////////////////////////////////////////////////////
$bolName = false;
$bolSurname = false;
$bolDNI = false;
$bolContent = false;
$bolShift = false;
$bolCourse = false;
$bolDivision = false;

//Variables que permitirá que se agregue el elementos al arreglo o no
$_SESSION['Envio_de_datos'] = true;

//Definicion de arreglos de sesion
//////////////////////////////////////////////////////////////////////////////////////
if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = array();
}
if (!isset($_SESSION['apellido'])) {
    $_SESSION['apellido'] = array();  
}
if (!isset($_SESSION['DNI'])) {
    $_SESSION['DNI'] = array();  
}
if (!isset($_SESSION['contenido'])) {
    $_SESSION['contenido'] = array();   
}
if (!isset($_SESSION['turno'])) {
    $_SESSION['turno'] = array();    
}
if (!isset($_SESSION['curso'])) {
    $_SESSION['curso'] = array();    
}
if (!isset($_SESSION['division'])) {
    $_SESSION['division'] = array();   
}
//////////////////////////////////////////////////////////////////////////////////////
//Recepsion de los nuevo registro
    if (isset($_POST['username'])){
        $_SESSION['Rnombre'] = $_POST['username'];
    }
    if (isset($_POST['Apellido'])){
        $_SESSION['Rapellido'] = $_POST['Apellido'];
    }
    if (isset($_POST['DNI'])){
        $_SESSION['RDNI'] = $_POST['DNI'];
    }
    if (isset($_POST['Materias'])){
        $_SESSION['Rmaterias'] = $_POST['Materias'];
    }
    if (isset($_POST['Turno'])){
        $_SESSION['Rturno'] = $_POST['Turno'];
    } 
    if (isset($_POST['Curso'])){ 
        $_SESSION['Rcurso'] = $_POST['Curso'];
    } 
    if (isset($_POST['Division'])){
        $_SESSION['Rdivision'] = $_POST['Division'];
    }
//////////////////////////////////////////////////////////////////////////////////////
//Recolección por SQL
function elementos_de_tablas_SQL($columna, $tabla, $conexion){
    $sql = "SELECT $columna FROM $tabla"; 
    $Result = $conexion->query($sql);
    if($Result->num_rows > 0) {
        while($row = $Result->fetch_assoc()) {
            yield $row[$columna];
        }
    }
}
//////////////////////////////////////////////////////////////////////////////////////

//Revizár si los elementos se repíten
//////////////////////////////////////////////////////////////////////////////////////
echo "<table border = 1>";
echo "<tr>"; 

if (isset($_POST['username']) and isset($_POST['Apellido']) and isset($_POST['DNI']) and isset($_POST['Materias']) and isset($_POST['Turno']) and isset($_POST['Curso']) and isset($_POST['Division'])){
    foreach($_SESSION['nombre'] as $elementos){
        if ($elementos === $_POST['username']){ 
            $bolName = true;
            //echo "<td>".$elementos."</td>";
        }
    } 
    foreach($_SESSION['apellido'] as $elementos){
        if ($elementos === $_POST['Apellido']){
            $bolSurname = true;
            //echo "<td>".$elementos."</td>";
        }  
    }
    foreach($_SESSION['DNI'] as $elementos){
        if ($elementos === $_POST['DNI']){ 
            $bolDNI = true;
            //echo "<td>".$elementos."</td>";
        }
    }
    foreach($_SESSION['contenido'] as $elementos){
        if ($elementos === $_POST['Materias']){ 
            $bolContent = true;
            //echo "<td>".$elementos."</td>";
        }
    }
    foreach($_SESSION['turno'] as $elementos){
        if ($elementos === $_POST['Turno']){ 
            $bolShift = true;
            //echo "<td>".$elementos."</td>";
        }
    }
    foreach($_SESSION['curso'] as $elementos){
        if ($elementos === $_POST['Curso']){
            $bolCourse = true;
            //echo "<td>".$elementos."</td>";
        }
    }
    foreach($_SESSION['division'] as $elementos){
        if ($elementos === $_POST['Division']){
            $bolDivision = true;
            //echo "<td>".$elementos."</td>";
        }
    }
}
//////////////////////////////////////////////////////////////////////////////////////

if ($bolName and $bolSurname and $bolDNI and $bolContent and $bolShift and $bolCourse and $bolDivision){
    $_SESSION['Envio_de_datos'] = false;
} 
////////////////////////////////////////////////////////////////////////////////////////////////
//Si estan definidas las variables, entonces que las inserte en el arreglo
if ($_SESSION['Envio_de_datos']){
    if (isset($_SESSION['Rnombre'])) {
        array_push($_SESSION['nombre'], $_SESSION['Rnombre']);
        $_SESSION['Rnombre'] = null;
    }
    if (isset($_SESSION['Rapellido'])) {
        array_push($_SESSION['apellido'], $_SESSION['Rapellido']);
        $_SESSION['Rapellido'] = null; 
    }
    if (isset($_SESSION['RDNI'])) {
        array_push($_SESSION['DNI'], $_SESSION['RDNI']);
        $_SESSION['RDNI'] = null;
    }
    if (isset($_SESSION['Rmaterias'])) {
        array_push($_SESSION['contenido'], $_SESSION['Rmaterias']);
        $_SESSION['Rmaterias'] = null;
    }
    if (isset($_SESSION['Rturno'])) {
        array_push($_SESSION['turno'], $_SESSION['Rturno']);
        $_SESSION['Rturno'] = null;
    }
    if (isset($_SESSION['Rcurso'])) { 
        array_push($_SESSION['curso'], $_SESSION['Rcurso']);
        $_SESSION['Rcurso'] = null;
    }
    if (isset($_SESSION['Rdivision'])) {
        array_push($_SESSION['division'], $_SESSION['Rdivision']);
        $_SESSION['Rdivision'] = null;
    }
}

/////////////////////////////////////////////////////
$_SESSION['nombre'] = array_values($_SESSION['nombre']);
$_SESSION['apellido'] = array_values($_SESSION['apellido']);
$_SESSION['DNI'] = array_values($_SESSION['DNI']);
$_SESSION['contenido'] = array_values($_SESSION['contenido']);
$_SESSION['turno'] = array_values($_SESSION['turno']);
$_SESSION['curso'] = array_values($_SESSION['curso']);
$_SESSION['division'] = array_values($_SESSION['division']);

$_SESSION['Longitud'] = count($_SESSION['nombre']) - 1;

//////////////////////////////////////////////////////////////////////
//Booleanos de pruebas

$Intefaz = true;

/////////////////////////////////////////////////////////////////////
//Tabla de docente en base de datos

if ($Intefaz){
    echo "<!DOCTYPE html>
        <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Tabla Estilizada</title>
                <style>
                 /* Estilos generales de la tabla */
                    table {
                        width: 100%;
                        border-collapse: collapse; /* Para que las celdas no tengan espacio entre ellas */
                        margin-top: 20px;
                        font-family: Arial, sans-serif;
                        background-color: #f9f9f9;
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Sombra para un efecto más moderno */
                    }

                    /* Estilo para las celdas de la tabla */
                    td, th {
                        padding: 12px 15px;
                        text-align: left;
                        vertical-align: middle;
                        border: 1px solid #ddd;
                    }

                    /* Estilo para los encabezados (th) */
                    th {
                        background-color: #4CAF50;
                        color: white;
                        font-weight: bold;
                        text-transform: uppercase;
                    }

                    /* Cambio de color al pasar el ratón sobre las celdas */
                    tr:hover {
                        background-color: #f1f1f1;
                    }

                    /* Estilo para las filas alternadas */
                    tr:nth-child(even) {
                        background-color: #f9f9f9;
                    }

                    tr:nth-child(odd) {
                        background-color: #fff;
                    }

                    /* Estilo para las celdas con texto subrayado (usando <u>) */
                    td u {
                        text-decoration: underline;
                        color: #333;
                    }

                    /* Estilo para las celdas con texto en cursiva y subrayado (usando <em>) */
                    td em u {
                        font-style: italic;
                        text-decoration: underline;
                        color: #555;
                    }

                    /* Estilo para los botones dentro de la tabla */
                    button {
                        background-color: #4CAF50;
                        color: white;
                        border: none;
                        padding: 10px 20px;
                        cursor: pointer;
                        border-radius: 5px;
                        transition: background-color 0.3s ease;
                    }

                    /* Efecto al pasar el ratón sobre los botones */
                    button:hover {
                        background-color: #45a049;
                    }

                    /* Estilo para los campos de texto y selects dentro de la tabla */
                    input[type='text'], select {
                        padding: 8px;
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        width: 100%;
                        box-sizing: border-box;
                        margin: 5px 0;
                    }

                    input[type='submit'] {
                        background-color: #4CAF50;
                        color: white;
                        padding: 10px 20px;
                        border: none;
                        cursor: pointer;
                        border-radius: 5px;
                        font-size: 16px;
                        transition: background-color 0.3s ease;
                    }

                    input[type='submit']:hover {
                        background-color: #45a049;
                    }

                    input[type='hidden'] {
                        display: none; /* Ocultar los campos ocultos */
                    }

                    /* Estilo para el formulario al final */
                    form {
                        margin-top: 20px;
                    }

                    form button {
                        background-color: #008CBA;
                        color: white;
                    }

                    form button:hover {
                        background-color: #0077b5;
                    }
                </style>
            </head>
    <body>";

    echo "
    <caption style='font-size: 1.5rem; font-weight: bold; color: #333; background-color: #4CAF50; color: white; padding: 10px;'>Docentes a ingresar</caption>
    <table border = 1>
    <tr> <!--Indica que se realizaran filas-->
        <td><u>nombre</u></th>
        <td><em><u>apellido</u></em></td>
        <td><em><u>DNI</u></em></td>
        <td><u>contenido</u></th>
        <td><u>turno</u></th>
        <td><em><u>curso</u></em></td>
        <td><em><u>division</u></em></td>
        <td><em><u>estado</u></em></td>
        <td><em><u>Modificacion</u></em></td>
    </tr>";
echo "<br>";
    echo "<form action='Subir_a_base_de_datos.php' method='post'>";  
    for ($i = 0; $i <= $_SESSION['Longitud'];$i ++){
        ////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['nombre'][$i])){
            echo "<tr>";
            echo "
            <td>
                <label for='username'></label>
                <code>".$_SESSION['nombre'][$i]."</code><br>
            </td>";

        }
        ////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['apellido'][$i])){
        echo "
        <td>
            <label for='username'></label>
            <code>".$_SESSION['apellido'][$i]."</code><br>
        </td>";

        }
        ////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['DNI'][$i])){
            echo "
            <td>
                <label for='username'></label>
                <code>".$_SESSION['DNI'][$i]."</code><br>
            </td>";

        }
        ////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['contenido'][$i])){
        echo "
        <td>
            <label for='username'></label>
            <code>".$_SESSION['contenido'][$i]."</code><br>
        </td>";

        }
        ////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['turno'][$i])){
            echo "
            <td>
                <label for='username'></label>
                <code>".$_SESSION['turno'][$i]."</code><br>
            </td>";
    
        }
        ////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['curso'][$i])){
        echo "
        <td>
            <label for='username'></label>
            <code>".$_SESSION['curso'][$i]."</code><br>
        </td>";

        }
        ////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['division'][$i])){
        echo "
        <td>
            <label for='username'></label>
            <code>".$_SESSION['division'][$i]."</code><br>
        </td>";

        }
        ////////////////////////////////////////////////////////////////////////////////
        echo "<td>";
        echo "<input type='text' id='estado{$i}' name='estado{$i}' ><br><br>";
        echo "</td>";
        echo "<td>";
        echo "<select id = 'accion{$i}' name = 'accion{$i}'>
            <option value = 'None'>-</option>
            <option value = 'Bajar'>Bajar</option>
            <option value = 'Subir'>Subir</option>
            </select><br><br>";
            echo "<button type='button' id='Modificar{$i}' name='Modificar{$i}' value='{$i}' onclick='redirigirConValor({$i})'>Modificar</button><br><br>";
        echo "</td>";
        echo "</tr>";
        ////////////////////////////////////////////////////////////////////////////////
        echo "<input type = 'hidden' name = 'DNI{$i}' id = 'DNI{$i}' value = '".$_SESSION['DNI'][$i]."'>";
    }
    echo "<input type = 'submit' value = 'Subir maestro/s'>";
    echo "</form>";
    echo "<br>";
    echo "<br>";
    echo "<form action='inicio_de_sesionEnHtml.html' method='post'>
    <button type='submit'>Ingresar nuevo docente y/o materia</button>";
    echo "</body>";
}

echo "<table border = 1>
<caption style='font-size: 1.5rem; font-weight: bold; color: #333; background-color: #2196F3; color: white; padding: 10px;'>Docentes ingresados</caption>
    <tr> <!--Indica que se realizaran filas-->
        <td><u>id de docente</u></th>
        <td><em><u>Nombre</u></em></td>
        <td><em><u>Apellido</u></em></td>
        <td><u>DNI</u></th>
        <td><u>Estado</u></th>
        <td><em><u>Contenido</u></em></td>
        <td><em><u>Turno</u></em></td>
        <td><em><u>Curso</u></em></td>
        <td><em><u>Division</u></em></td>
    </tr>";
    $consulta = "SELECT * FROM docente";
    $resultado = mysqli_query($conn, $consulta);
        
    $resultado_docentes = mysqli_query($conn, $consulta);

    if ($resultado_docentes) {
        // Recorrer los docentes
        while ($docente = mysqli_fetch_assoc($resultado_docentes)) {
            echo "<tr>"; // Comienza una nueva fila para cada docente

            // Mostrar los datos del docente
            echo "<td><code>" . $docente['id_docente'] . "</code></td>";
            echo "<td><code>" . $docente['nombre'] . "</code></td>";
            echo "<td><code>" . $docente['apellido'] . "</code></td>";
            echo "<td><code>" . $docente['DNI'] . "</code></td>";
            echo "<td><code>" . $docente['estado'] . "</code></td>";

            // Consulta para obtener las materias del docente actual
            $consulta_materias = "SELECT * FROM materias WHERE id_docente = " . $docente['id_docente'];
            $resultado_materias = mysqli_query($conn, $consulta_materias);

            if ($resultado_materias) {
                // Recorrer las materias del docente y mostrarlas en la misma fila
                while ($materia = mysqli_fetch_assoc($resultado_materias)) {
                    echo "<td><code>" . $materia['contenido'] . "</code></td>";
                    echo "<td><code>" . $materia['turno'] . "</code></td>";
                    echo "<td><code>" . $materia['curso'] . "</code></td>";
                    echo "<td><code>" . $materia['division'] . "</code></td>";
                }
            } else {
                // Si no hay materias, agregar celdas vacías
                echo "<td>-</td><td>-</td><td>-</td><td>-</td>";
            }

            echo "</tr>"; // Cierra la fila del docente
        }
} else {
    echo "Error al ejecutar la consulta de docentes: " . mysqli_error($conn);
}

echo "</table>";
    
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
<script>
    addEventListener('click', Element => {
        console.log(Element.target.id);
    });

    function redirigirConValor(valor) {
    // Crea un formulario temporal para enviar el valor
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'Modificar.php'; // Archivo al que se redirige

    // Crea un campo oculto con el valor a enviar
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'indice'; // Nombre del campo que recibirá el valor en "Modificar.php"
    input.value = valor;

    // Agrega el campo al formulario
    form.appendChild(input);

    // Envía el formulario
    document.body.appendChild(form);
    form.submit();
}

</script>
</html>
