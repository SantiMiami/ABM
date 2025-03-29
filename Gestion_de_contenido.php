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

function Borrar_elemento($tabla, $columna, $elemento, $conexion){
    $sql = "DELETE FROM $columna WHERE $tabla = $elemento";
    $stmt = $conexion->prepare($sql);
    if ($stmt->execute()) echo "Elemento eliminado";
    else echo "Hubo un error inesperado". $stmt->error;
    
}

//INICIO DE SESION
session_start();

//Cronometro de cierre de sesion
if (!isset($_SESSION['Tiempo']))$_SESSION['Tiempo'] = time();
$Tiempo = time() - $_SESSION['Tiempo']; //Asignación de tiempo

$Tiempo_de_cierre = 5;


if (isset($_POST['accion'])) $Tipo_de_cambio = $_POST['accion'];

$Sector = (isset($_POST['Sector'])) ? $_POST['Sector'] : "None";

// Cambios a realizarse
if ($Sector === "docente"){
    //Se almacenan en variables
    $nombre_de_docente = $_POST['username'];
    $apellido_de_docente = $_POST['Apellido'];
    $DNI_de_docente = $_POST['DNI'];

    //Los convierte en variables de sesión
    $_SESSION['Nombre'] = $nombre_de_docente;
    $_SESSION['Apellido'] = $apellido_de_docente;
    $_SESSION['DNI'] = $DNI_de_docente;


    if ($Tipo_de_cambio === "Bajar"){
        $sql = "SELECT * FROM $Sector WHERE DNI = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['DNI']); 

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sql = "DELETE FROM $Sector WHERE DNI = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['DNI']);
            if($stmt->execute()){
                echo "Docente eliminados de los registros";
            } else{
                echo "Error: ". $stmt->error;
            }
        } else {
            //header("Location: Inicio_de_sesionEnHtml.html");
            echo "Usuario no disponible, porfavor, registrese para obtener una cuenta";
        }
        $conn->close();
    }    
    if ($Tipo_de_cambio === "Subir"){
        $sql = "SELECT * FROM docente WHERE DNI = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['DNI']); 
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "Docente ya ingresado";
        } else{
            $sql = "INSERT INTO `docente` (`Nombre`, `Apellido`, `DNI`) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $_SESSION['Nombre'], $_SESSION['Apellido'], $_SESSION['DNI']);

            if($stmt->execute()){
                echo "Nuevo docente ingresado";
                echo $Tiempo;
                /*if ($Tiempo >= $Tiempo_de_cierre){
                    header("location: Inicio_de_sesionEnHtml.html");
                    exit;
                }*/
            }
            else echo "Error: ". $stmt->error;
        }
        $conn->close();
    } else if($Tipo_de_cambio === "Modificar"){
        header("Location: Modificar.php");
        exit;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else if($Sector === "materias"){
    $Materias = (isset($_POST['Materias'])) ? $_POST['Materias'] : "None";
    $Turno = (isset($_POST['Turno'])) ? $_POST['Turno'] : "None";
    $Curso = (isset($_POST['Curso'])) ? $_POST['Curso'] : "None";
    $Division = (isset($_POST['Division'])) ? $_POST['Division'] : "None";
    $ids = 0;

    $_SESSION['Materias'] = $Materias;
    $_SESSION['Turno'] = $Turno;
    $_SESSION['Curso'] = $Curso;
    $_SESSION['Division'] = $Division;

    $IDs = [];

    $sql = "SELECT id_docente FROM docente"; 
        $Result = $conn->query($sql);
        if($Result->num_rows > 0) {
            while($row = $Result->fetch_assoc()) {
                echo $row['id_docente'] . "<br>";
                $IDs[] = $row['id_docente'];
                print_r($IDs);
            }
        }
        //$conn->close();
    if ($Tipo_de_cambio === "Bajar"){
        $sql = "SELECT * FROM materias WHERE id_docente = ?";
        $stmt = $conn->prepare($sql);
        $stmt ->bind_param("i", $IDs[$ids]);
        $stmt ->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sql = "DELETE FROM $Sector WHERE id_docente = ? ";
            $stmt = $conn->prepare($sql);
            $stmt ->bind_param("i", $IDs[$ids]);
            if($stmt->execute()){
                echo "Docente y materia eliminados de los registros";
            } else{
                echo "Error: ". $stmt->error;
            }
        } else {
            //header("Location: Inicio_de_sesionEnHtml.html");
            echo "Docente y/o materia no encontrados";
        }

        
    }    
    if ($Tipo_de_cambio === "Subir"){
        $bolNotUsed = true;
        while ($bolNotUsed){
            $sql = "SELECT * FROM $Sector WHERE id_docente = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $IDs[$ids]); 
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                //echo "Docente ya ingresado<br>";
                if ($ids <= count($IDs) - 1) $ids ++;
                else $bolNotUsed = false;
            } else{
                if ($IDs[0] === null){
                    echo "Docentes no registrados, ingrese nuevos docentes para ingresar materias";
                    $bolNotUsed = false;
                }
                else{ 
                    echo "Docente no registrado";    
                    $sql = "INSERT INTO $Sector (`id_docente`,`contenido`, `turno`, `curso`, `division`) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("issii", $IDs[$ids], $_SESSION['Materias'], $_SESSION['Turno'], $_SESSION['Curso'], $_SESSION['Division']);
                    if($stmt->execute()){
                        echo "Nueva materia ingresado";
                    }
                    else echo "Error: ". $stmt->error;
                    $bolNotUsed = false;
                }
            }
        }
    }else if($Tipo_de_cambio === "Modificar"){
        header("Location: ModificarM.php");
        exit;
    }
} 
 else if(isset($_POST['Nuser']) && isset($_POST['Napellido']) && isset($_POST['NDNI'])){
        $DNI_sesion = $_SESSION['DNI'];
        //Nuevos valores a modificar
        $Nuser = $_POST['Nuser'];
        $Napellido = $_POST['Napellido'];
        $NDNI = $_POST['NDNI'];

        //Que identifique al docente por medio de su DNI
        $sql = "SELECT * FROM docente WHERE DNI = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['DNI']); 
        $stmt->execute();
        $result = $stmt->get_result();

        //Revizar si hay un docente que cumpla dicha caracteristica
        if ($result->num_rows > 0) {
            $sql = "UPDATE docente SET nombre = '$Nuser', apellido = '$Napellido', DNI = '$NDNI' WHERE DNI = $DNI_sesion";
            $conection = $conn ->prepare($sql);
            if ($conection->execute()){
                echo "Datos actualizados y cambiados";
            } else {
                echo "Error: ". $conection->error;
            }
        } else{
            echo "Docente no encontrado";
        }
       
    } else if (isset($_POST['Nmaterias']) && isset($_POST['Nturno']) && isset($_POST['Ncurso']) && isset($_POST['Ndivision']) && isset($_POST['NDNI'])){
            $Nmaterias = $_POST['Nmaterias'];
            $Nturno = $_POST['Nturno'];
            $Ncurso = $_POST['Ncurso'];
            $Ndivision = $_POST['Ndivision'];
            $NDNI = $_POST['NDNI'];

            $ids = 0;

            $IDs = [];

            $sql = "SELECT id_docente FROM docente"; 
                $Result = $conn->query($sql);
                if($Result->num_rows > 0) {
                while($row = $Result->fetch_assoc()) {
                        //echo $row['id_docente'] . "<br>";
                        $IDs[] = $row['id_docente'];
                        //print_r($IDs);
                    }
                }
                $sql = "SELECT * FROM docente WHERE DNI = ".$NDNI;
                $stmt = $conn->prepare($sql); 
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows > 0) {
                    //echo "¿NANI?";
                    $sql = "SELECT id_docente FROM docente WHERE DNI = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $NDNI); 
                    $stmt->execute();
                    $Result = $stmt->get_result();
                    $row = $Result->fetch_assoc();
                    //echo "Este es el ID del docente: ".$row['id_docente'];
                    $id_docente = $row['id_docente'];
                    if($Result->num_rows > 0) {
                        $sql = "UPDATE materias SET contenido = '$Nmaterias', turno = '$Nturno', curso = '$Ncurso', division = '$Ndivision' WHERE id_docente = $id_docente";
                        $conection = $conn ->prepare($sql);
                        if ($conection->execute()){
                            echo "Datos actualizados y cambiados";
                        } else {
                            echo "Error: ". $conection->error;
                        }
                    } else{
                        echo "Docente no encontrado";
                    }
                }
            /*
            $sql = "SELECT * FROM materias WHERE id_docente = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $IDs[$ids]); 
            $stmt->execute();
            $result = $stmt->get_result();

            //Revizar si hay un docente que cumpla dicha caracteristica
            if ($result->num_rows > 0) {
                $sql = "UPDATE materias SET contenido = '$Nmaterias', turno = '$Nturno', curso = '$Ncurso', division = '$Ndivision' WHERE id_docente = $IDs[$ids]";
                $conection = $conn ->prepare($sql);
                if ($conection->execute()){
                    echo "Datos actualizados y cambiados";
                    $stmt->close();
                } else echo "Error: ". $conection->error;
            }*/ 

    } else{
        echo "nao nao :(";
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="inicio_de_sesionEnHtml.html" method="post">
    <button type="submit">Volver</button>
</body>
</html>