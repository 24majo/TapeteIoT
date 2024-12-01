<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Tapete/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Tapete/css/styleIndex.css">
    
    <script src=".Tapete/js/bootstrap.min.js"></script>
    <script src="./Tapete/js/query-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <title>Inicio sesión administrativos</title>
</head>

<script>
      function Cancelar_d(){
        document.getElementById("num_empleado").value = ""
        document.getElementById("pass").value = ""
      }

      function Pregunta_d(event){
        var num_e = $('#num_empleado').val();
        if(num_e.trim() !== ""){
          $.ajax({
            url:'Tapete/conexiones/ingreso_admin.php',
            type:'GET',
            data: {num_e: num_e},
            success: function(response){
              if(response){
                $('#pregunta_d').val(response);
              }
              else{
                alert('Este empleado no tiene pregunta de seguridad');
              }
            },
            error:function(){
              alert('Error de consulta');
            }
          })
        }
        event.preventDefault();
      }
    </script>
<body>

<div class="container2">
    
<form class="formulario2" method="post" action="Tapete/conexiones/ingreso_admin.php">
      <h2>Ingreso de administrativos</h2>
      <label>Número de empleado</label>
      <br>
      <input type="text" name="num_empleado" id="num_empleado" placeholder="001AABBCC">
      <br><br>
      <label for="">Contraseña</label>
      <br>
      <input type="password" id="pass" name="pass" placeholder="**********">
      <br>
      <input style="background-color: #f6d100; color:white; border: none; font-weight: bold; font-size: 16px;" type="submit" name="ingresar_d" value="Ingresar">
      <center>
        <button type="submit" id="pregunta-d" onclick="Pregunta_d(event)">¿Olvidaste tu contraseña?</button>
        <button type="button" id="cancelar_d" name="cancelar_d" onclick="Cancelar_d()">Cancelar</button>
      </center>
      <div id="seguridad_d">
        <p>Responde la pregunta de seguridad</p>
        <label for="pregunta_d">Pregunta</label>
        <input type="text" class="pregunta_d" id="pregunta_d" disabled>
        <label for="respuesta_d">Respuesta</label>
        <input type="text" name="respuesta_d" id="respuesta_d">
        <center>
          <button id="verificar_d" name="verificar_d">Verificar</button>
        </center>
      </div>
  </form>
</div>
</center>
</body>
</html>