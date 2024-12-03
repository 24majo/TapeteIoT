<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="Tapete/Visual/Material/Didit.png" type="image/x-icon">

  <link rel="stylesheet" href="./Tapete/css/bootstrap.min.css">
  <link rel="stylesheet" href="./Tapete/css/styleIndex.css">
  
  <script src="./Tapete/js/bootstrap.min.js"></script>
  <script src="./Tapete/js/jquery-3.7.1.min.js"></script>
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
<body  background="./Tapete/Visual/Fondos/FondoInicioSesion2.jpg">
  <div class="container2">
    <form class="formulario2" method="post">
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

  <?php
    include'Tapete/conexiones/conexion.php';
    session_start();
    $pregunta ="";

    if (isset($_POST['ingresar_d'])) {
      $num_empleado = $_POST['num_empleado'];
      $pass = $_POST['pass'];
  
      $sql = "SELECT password FROM docentes WHERE num_empleado = '$num_empleado'";
      $rol = "SELECT rol FROM docentes where num_empleado = '$num_empleado'";
      $result = $conn->query($sql);
      $res_rol = $conn->query($rol);
    
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $contra = $row['password'];

        if (password_verify($pass, $contra)) {
          if($res_rol -> num_rows > 0){
            $roles = $res_rol->fetch_assoc();
            $rolF = $roles['rol'];
            //echo $rolF;
            if($rolF == 'admin'){
              $_SESSION['num_empleado'] = $num_empleado;
              header("Location: Tapete/MenuAdmin.php");
            }
            else if ($rolF == 'docente'){
              $_SESSION['num_empleado'] = $num_empleado;
              header("Location: Tapete/MenuDocentes.php");
            }
          } 

          else {
            echo '<script src="Tapete/node_modules/sweetalert/dist/sweetalert.min.js"></script>';
            echo 
            '<script>
              swal({
                title: "Rol no asignado",
                text: "Verifica que el usuario ingresado trnga asignado un rol de privilegios.",
                icon: "info"
              })
            </script>';
          }
        }
            
        else {
          echo '<script src="Tapete/node_modules/sweetalert/dist/sweetalert.min.js"></script>';
          echo 
          '<script>
            swal({
              title: "Contraseña incorrecta",
              text: "Verifica que tu contraseña sea correcta.",
              icon: "error"
            })
          </script>';
        }
      } 
        
      else {
        echo '<script src="Tapete/node_modules/sweetalert/dist/sweetalert.min.js"></script>';
        echo 
        '<script>
          swal({
            title: "Usuario incorrecto",
            text: "Verifica que el número de empleado sea correcto o esté registrado en el sistema.",
            icon: "error"
          })
        </script>';
      }
    } 

    if (isset($_GET['num_e'])) {
      $num_e = $_GET['num_e'];
      $sql = "SELECT pregunta FROM docentes WHERE num_empleado = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $num_e);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($row = $result->fetch_assoc()) {
        $pregunta = $row['pregunta'];
        echo $pregunta;
      } 
      else {
        $pregunta = 'Pregunta no encontrada';
      }
      exit;
    }

    if(isset($_POST["verificar_d"])){
      $num_e = $_POST['num_empleado'];
      $respuesta = $_POST['respuesta_d'];
      $sql = "SELECT respuesta FROM docentes WHERE num_empleado = '$num_e'";
      $rol = "SELECT rol FROM docentes where num_empleado = '$num_e'";
      $result = $conn->query($sql);
      $res_rol = $conn->query($rol);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $res = $row['respuesta'];

        if (password_verify($respuesta, $res)) {
          $_SESSION['num_empleado'] = $num_e;
          if($res_rol -> num_rows > 0){
            $roles = $res_rol->fetch_assoc();
            $rolF = $roles['rol'];
            if($rolF == 'admin'){
              $_SESSION['num_empleado'] = $num_e;
              header("Location: Tapete/MenuAdmin.php");
            }
            if ($rolF == 'docente'){
              $_SESSION['num_empleado'] = $num_e;
              header("Location: Tapete/MenuDocentes.php");
            }
          } 
          exit;
        } 
        else {
          echo '<script src="Tapete/node_modules/sweetalert/dist/sweetalert.min.js"></script>';
          echo 
          '<script>
            swal({
              title: "Respuesta incorrecta",
              text: "Verifica que la respuesta a la pregunta sea correcta.",
              icon: "error"
            })
          </script>';
        }
      }
    }
?>
</body>
</html>