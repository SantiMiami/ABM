<?php
session_start();
if (isset($_POST['indice'])) $i = $_POST['indice'];
else echo "No se recibió ningún valor.";



echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Redirigir con valor</title>
        <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    flex-direction: column;
                }

                /* Contenedor de la página */
                .container {
                    width: 80%;
                    max-width: 600px;
                    background-color: white;
                    padding: 30px;
                    border-radius: 8px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }

                /* Botón para activar la redirección */
                button.redirigir {
                    background-color: #4CAF50;
                    color: white;
                    padding: 12px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 1rem;
                    margin-top: 20px;
                    transition: background-color 0.3s ease;
                }

                button.redirigir:hover {
                    background-color: #45a049;
                }

                /* Mensaje de espera o redirección en proceso */
                #esperando {
                    display: none;
                    font-size: 1.2rem;
                    color: #333;
                    margin-top: 20px;
                }

                #esperando span {
                    font-weight: bold;
                    color: #FF5733;
                }

                /* Estilo para los elementos que están invisibles durante el proceso de redirección */
                .hidden {
                    display: none;
                }
        </style>
    </head>
    <body>
    <div id='DyM'>Docente y materia</div>
    <div id = 'contenido'>
        <div id = 'cambio_de_contenido'>
            <div id = 'C'>
                <form action='Subir_a_base_de_datos.php' method='post'>
                    <h3>Accion a realizar</h3>
                    <label for='username'>Nombre:</label>
                    <input type='text' id='Musername' placeholder=".$_SESSION['nombre'][$i]." name='Musername' required><br>
                    <br><label for='username'>Apellido:</label>
                    <input type='text' id='MApellido' placeholder=".$_SESSION['apellido'][$i]." name='MApellido' required><br>
                    <br><label for='password'>DNI:</label>
                    <input type='text' id='MDNI' placeholder=".$_SESSION['DNI'][$i]." name='MDNI' maxlength='8' onkeypress='soloNumeros(event)' required><br><br>

                    <label for='username'>Materias:</label>
                    <input type='text' id='MMaterias' placeholder=".$_SESSION['contenido'][$i]." name='MMaterias' required>
                    <br><br>
                    <code>Turno: ".$_SESSION['turno'][$i]."</code>
                    <select id = 'MTurno' name = 'MTurno'>
                        <option value = 'Mañana'>Mañana</option>
                        <option value = 'Tarde'>Tarde</option></select><br><br><label for='username'>Curso:</label>
                        <input type='number' id='MCurso' placeholder=".$_SESSION['curso'][$i]." name='MCurso' required><br><br>
                        <label for='username'>Division:</label>
                        <input type='number' id='MDivision' placeholder=".$_SESSION['division'][$i]." name='MDivision' required><br><br>
                    </select>
                    <input type = 'hidden' name = 'INDEX' id = 'INDEX' value = {$i}>
                    <input type='submit' value='Registro'>
                </form>
            </div>
        </div>
    </div>
    <form action='inicio_de_sesion.php' method='post'>
        <button type='submit'>Volver</button>
    <script>
function soloNumeros(event) {
            // Obtiene el código de la tecla presionada
            var charCode = event.which ? event.which : event.keyCode;
            
            // Verifica si es un número (0-9) o la tecla de retroceso (backspace)
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        }
</script>";



?>
