<form action='Gestion_de_contenido.php' method='post'>
<div id='DyM'>Docente y materia</div>
    <div id = 'contenido'>
        <div id = 'cambio_de_contenido'>
            <div id = 'C'>
                <form action='Subir_a_base_de_datos.php' method='post'>
                    <h3>Accion a realizar</h3>
                    <label for='username'>Nombre:</label>
                    <input type='text' id='Musername' placeholder=".$_SESSION['nombre'][$_SESSION["I"]]." name='Musername' ><br>
                    <br><label for='username'>Apellido:</label>
                    <input type='text' id='MApellido' placeholder=".$_SESSION['apellido'][$_SESSION["I"]]." name='MApellido' ><br>
                    <br><label for='password'>DNI:</label>
                    <input type='text' id='MDNI' placeholder=".$_SESSION['DNI'][$_SESSION["I"]]." name='MDNI' maxlength='8' onkeypress='soloNumeros(event)' ><br><br>

                    <label for='username'>Materias:</label>
                    <input type='text' id='MMaterias' placeholder=".$_SESSION['contenido'][$_SESSION["I"]]." name='MMaterias' >
                    <br><br>
                    <code>Turno: ".$_SESSION['turno'][$_SESSION["I"]]."</code>
                    <select id = 'MTurno' name = 'MTurno'>
                        <option value = 'Mañana'>Mañana</option>
                        <option value = 'Tarde'>Tarde</option></select><br><br><label for='username'>Curso:</label>
                        <input type='number' id='MCurso' placeholder=".$_SESSION['curso'][$_SESSION["I"]]." name='MCurso' ><br><br>
                        <label for='username'>Division:</label>
                        <input type='number' id='MDivision' placeholder=".$_SESSION['division'][$_SESSION["I"]]." name='MDivision' ><br><br>
                    </select>
                    <input type = 'hidden' name = 'Sector' id = 'Sector' value = 'materias'>
                    <input type='submit' value='Registro'>
                </form>
            </div>
        </div>
    </div>";
        <input type='submit' value='Registro'>
</form>