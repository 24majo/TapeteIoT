<!DOCTYPE html><html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./Tapete/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Tapete/css/styleIndex.css">
    
    <script src=".Tapete/js/bootstrap.min.js"></script>
    <script src="./Tapete/js/query-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script>
      function Cancelar_a(){
        document.getElementById("curp").value = ""
        document.getElementById("pass_a").value = ""
      }

      function Cancelar_d(){
        document.getElementById("num_empleado").value = ""
        document.getElementById("pass").value = ""
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

  </head>
  <body background="./Tapete/Visual/Fondos/FondoInicioSesion.jpg">
      <div class="container">
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
    

<div  class="container2">
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
      <input type="submit" name="ingresar_d" value="Ingresar">
      <button type="submit" id="pregunta-d" onclick="Pregunta_d(event)">¿Olvidaste tu contraseña?</button>
      <button type="button" id="cancelar_d" name="cancelar_d" onclick="Cancelar_d()">Cancelar</button>
      <div id="seguridad_d">
        <p>Responde la pregunta de seguridad</p>
        <label for="pregunta_d">Pregunta</label>
        <input type="text" class="pregunta_d" id="pregunta_d" disabled>
        <label for="respuesta_d">Respuesta</label>
        <input type="text" name="respuesta_d" id="respuesta_d">
        <button id="verificar_d" name="verificar_d">Verificar</button>
      </div>
  </form>
</div>
  
</body>
</html>