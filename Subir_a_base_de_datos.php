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
unset($_SESSION['acciones']);
$A = null;
$ID = 0;

if (!isset($_SESSION['acciones'])) {
    $_SESSION['acciones'] = array();
}
if (!isset($_SESSION['estados'])) {
    $_SESSION['estados'] = array();
}
print_r($_SESSION['acciones']);

$nombre = [];
$apellido = [];
$DNI = [];
$contenido = [];
$turno = [];
$curso = [];
$division = [];
$estados = [];

if (isset($_POST['INDEX'])) $f = $_POST['INDEX'];

if (isset($_POST['Musername'])){
    $_SESSION['nombre'][$f] = $_POST['Musername'];
} 

if (isset($_POST['MApellido'])){
    $_SESSION['apellido'][$f] = $_POST['MApellido'];
} 

if (isset($_POST['MDNI'])){
    $_SESSION['DNI'][$f] = $_POST['MDNI'];
} 

if (isset($_POST['MMateria'])){
    $_SESSION['contenido'][$f] = $_POST['MMateria'];
}

if (isset($_POST['Mturno'])){
    $_SESSION['turno'][$f] = $_POST['Mturno'];
} 

if (isset($_POST['MCurso'])){
    $_SESSION['curso'][$f] = $_POST['MCurso'];
} 

if (isset($_POST['MDivision'])){
    $_SESSION['division'][$f] = $_POST['MDivision'];
}


function Selector_de_IDs($conn){
    $ids = 0;
    $IDs_generales = [];
    $IDs_sin_materias = [];
    //Obteniendo IDS de la base de datos de los docentes ingresados.
    $sql = "SELECT id_docente FROM docente"; 
    $Result = $conn->query($sql);
    if($Result->num_rows > 0) {
        while($row = $Result->fetch_assoc()) {
            array_push($IDs_generales, $row['id_docente']);
        }
    }
    ////////////////////////////////////////////////////////////////
    //Seleccionando las materias en donde no hay un ID de docente enlasado
    $sql = "SELECT * FROM materias WHERE id_docente = $IDs_generales[$ids]";
    while($ids <= count($IDs_generales) - 1){
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            if ($ids <= count($IDs_generales) - 1) $ids ++;
        } 
    }
        while($row = $result->fetch_assoc()) {
            array_push($IDs_sin_materias, $row['id_docente']);    
        }
    return $IDs_sin_materias;
    /////////////////////////////////////////////////////////////////////////

}
//Fin del función de selección de IDs

$Acciones = true;

$sql = "SELECT id_docente FROM docente"; 
$Result = $conn->query($sql);
if($Result->num_rows > 0) {
    while($row = $Result->fetch_assoc()) {
        //echo $row['id_docente'] . "<br>";
        $IDs[] = $row['id_docente'];
    }
}


for ($i = 0; $i <= $_SESSION['Longitud']; $i ++){
    if (isset($_POST['accion'.$i]) and $_POST['accion'.$i] != "None"){
        array_push($_SESSION['acciones'], $_POST['accion'.$i]);
    }

    if (isset($_POST['estado'.$i])){
        array_push($_SESSION['estados'], $_POST['estado'.$i]);
    }

    array_push($nombre, $_SESSION['nombre'][$i]);
    array_push($apellido, $_SESSION['apellido'][$i]);
    array_push($DNI, $_SESSION['DNI'][$i]);
    array_push($contenido, $_SESSION['contenido'][$i]);
    array_push($turno, $_SESSION['turno'][$i]);
    array_push($curso, $_SESSION['curso'][$i]);
    array_push($division, $_SESSION['division'][$i]);
    if (isset($_POST['estado'.$i])) array_push($estados, $_POST['estado'.$i]);

    
}

function Subir($conn, $nombre, $apellido, $DNI, $contenido, $turno, $curso, $division, $estados, $i){
    //Ingresar nuevo docente
    $Buscar_ID = "SELECT id_docente FROM `docente` WHERE DNI = $DNI[$i]";
    $resultado = mysqli_query($conn, $Buscar_ID);
    if ($resultado){ 
        $ID = mysqli_fetch_assoc($resultado);
        if($ID['id_docente'] === NULL){
            // Verificar si se encontró un ID válido
            $Insertar_docente = "INSERT INTO `docente` (`Nombre`, `Apellido`, `DNI`, `estado`) VALUES ('$nombre[$i]', '$apellido[$i]', '$DNI[$i]', '$estados[$i]')";
            $resultado = mysqli_query($conn, $Insertar_docente);
            if ($resultado) echo "<h1>Nuevo docente ingresado</h1>";
            print_r($ID['id_docente']);


            $Buscar_ID = "SELECT id_docente FROM `docente` WHERE DNI = $DNI[$i]";
            $resultado = mysqli_query($conn, $Buscar_ID);
            if ($resultado){
                $ID = mysqli_fetch_assoc($resultado); 
                if($ID['id_docente'] != NULL){
                    // Ingreso de la materia
                    $Insertar_materia = "INSERT INTO `materias` (`id_docente`, `contenido`, `turno`, `curso`, `division`) VALUES ('{$ID['id_docente']}', '$contenido[$i]', '$turno[$i]', '$curso[$i]', '$division[$i]')";
                    $resultado = mysqli_query($conn, $Insertar_materia);
                    if ($resultado) echo "<h1>Nueva materia ingresada</h1>";
                    else "Este docente ya dispone una materia ingresada, porfavor, ingrese otro docente";
                } else {
                    echo "<h1>Error: No se encontró un ID de docente válido para el DNI: $DNI[$i]</h1>";
                }
            } else echo "Docente ya ingresado";     
    } 
        } else{
            echo "<script>
                    alert('Docente ya ingresado');
                </script>";
            unset($_SESSION['acciones']);
            header("Location: Inicio_de_sesion.php");
            exit();   
        }
} 
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //Obtención del ID del docente
    
    //////////////////////////////////////////////////////////////////////////////////////////////////// 

function Bajar($conn, $nombre, $apellido, $DNI, $contenido, $turno, $curso, $division, $estados, $i){
    //Bajar del listado de docentes
    echo "<h1>Docente eliminado del listado</h1>";
    unset($_SESSION['nombre'][$i]);
    unset($_SESSION['apellido'][$i]);
    unset($_SESSION['DNI'][$i]);
    unset($_SESSION['contenido'][$i]);
    unset($_SESSION['turno'][$i]);
    unset($_SESSION['curso'][$i]);
    unset($_SESSION['division'][$i]);
    if (isset($_SESSION['estados'][$i])) unset($_SESSION['estados'][$i]);
    //////////////////////////////////////////////////////////////////////////////////
}

if ($Acciones){
    for ($i = 0; $i <= $_SESSION['Longitud']; $i ++){
        if ($_SESSION['acciones'][$i] === "Subir"){
            Subir($conn, $nombre, $apellido, $DNI, $contenido, $turno, $curso, $division, $estados, $i);
            Bajar($conn, $nombre, $apellido, $DNI, $contenido, $turno, $curso, $division, $estados, $i);
            unset($_SESSION['acciones'][$i]);
        } else if ($_SESSION['acciones'][$i] === "Bajar"){
            Bajar($conn, $nombre, $apellido, $DNI, $contenido, $turno, $curso, $division, $estados, $i);
            unset($_SESSION['acciones'][$i]);
        } else {
            unset($_SESSION['acciones']);
            header("Location: Inicio_de_sesion.php");
            exit();
        }   
    }
}
header("Location: Inicio_de_sesion.php");
exit();
echo "<form action='inicio_de_sesion.php' method='post'>
        <button type='submit'>Volver</button>";

?>