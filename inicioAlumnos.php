<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Tapete/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Tapete/css/styleIndex.css">
    
    <script src="./Tapete/js/bootstrap.min.js"></script>
    <script src="./Tapete/js/jquery-3.7.1.min.js"></script>

    <title>Inicio sesión alumnos</title>
</head>

<script>
      function Cancelar_a(){
        document.getElementById("curp").value = ""
        document.getElementById("pass_a").value = ""
      }

      function Pregunta(event) {
        var curp = $('#curp').val(); // Obtener el valor del CURP

        if (curp.trim() !== "") {
          $.ajax({
            url: 'Tapete/conexiones/ingreso_alumno.php', // Archivo que consultará la base de datos
            type: 'GET',
            data: { curp: curp }, // Enviamos el CURP como parámetro
            success: function(response) {
              if (response) {
                $('#pregunta').val(response);
              } 
              else {
                alert('No se encontró una pregunta para este CURP.');
              }
            },
            error: function() {
              alert('Hubo un error al intentar consultar la pregunta.');
            }
          });
        } 
        event.preventDefault();
      }
    </script>

<body>
    <center>
<div  class="container">
          <form class="formulario" method="post" action="Tapete/conexiones/ingreso_alumno.php">
            <h1>¡Bienvenido(a)!</h1>
            <h3>Ingreso de alumnos</h3>
            <label>CURP</label>
            <input type="text" id="curp" name="curp" placeholder="18 caracteres" maxlength="18">
            <label>Contraseña</label>
            <input type="password" id="pass_a" name="pass_a" placeholder="********">
            <input style="background-color: #f6d100; color:white; border: none; font-weight: bold; font-size: 16px;" type="submit" name="ingresar_a" value="Ingresar" id="ingresar_a">
            <center>
            <button  id="pregunta-a" name="pregunta-a" onclick="Pregunta(event)">¿Olvidaste tu contraseña?</button>
            <button  type="button" id="cancelar" name="cancelar" onclick="Cancelar_a()">Cancelar</button>
            </center>
            
            <div id="seguridad_a">
              <p>Responde la pregunta de seguridad</p>
              <label for="pregunta">Pregunta</label>
              <input type="text" class="pregunta" id="pregunta" disabled>
              <label for="respuesta">Respuesta</label>
              <input type="text" name="respuesta_a" id="respuesta_a">
              <center>
              <button id="verificar_a" name="verificar_a">Verificar</button>
              </center>
             
            </div>
        </form>
      </div>
</div>
s</center>
</body>
</html>