<?php
session_start();


function acciones($accion, $tabla, $DNI){
        if ($accion === "Bajar"){
            $sql = "SELECT * FROM $tabla WHERE DNI = $DNI";
            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $sql = "DELETE FROM $tabla WHERE DNI = $DNI";
                $stmt = $conn->prepare($sql);
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
    }
    else if($accion === "Modificar"){
        header("Location: Modificar.php");
        exit;
    }


$estado = [];
$accion = [];
$DNI = [];

for ($i = 0; $i <= $_SESSION['Longitud']; $i ++){
    $estado[] = isset($_POST['estado'.$i]) ? $_POST['estado'.$i] : ".";
    $accion[] = isset($_POST['accion'.$i]) ? $_POST['accion'.$i] : ".";
    $DNI[] = isset($_POST['DNI'.$i]) ? $_POST['DNI'.$i] : ".";
}

for ($i = 0; $i <= $_SESSION['Longitud']; $i ++){
    acciones($accion[$i], 'docente', $DNI[$i]);
}

print_r($estado);
echo "<br>";
print_r($accion);
echo "<br>";
print_r($DNI);
?>