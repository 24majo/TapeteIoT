<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <title>Ingresar</title>

    <style>
      label, input { display:block; }
      input.text { margin-bottom:12px; width:95%; padding: .4em; }
      fieldset { padding:0; border:0; margin-top:25px; }
      h1 { font-size: 1.2em; margin: .6em 0; }
      .ui-dialog .ui-state-error { padding: .3em; }
      .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>
</head>
<body>
  <form method="post" action="Tapete/conexiones/ingreso_alumno.php">
      <h1>¡Bienvenido(a)!</h1>
      <h2>Ingreso de alumnos</h2>
      <label>CURP</label>
      <br>
      <input type="text" id="curp" name="curp" placeholder="18 caracteres" maxlength="18">
      <br><br>
      <label>Contraseña</label>
      <br>
      <input type="password" id="pass_a" name="pass_a" placeholder="********">
      <br>
      <button id="olv-contr-a">¿Olvidaste tu contraseña?</button>
      <br>
      <input type="submit" name="ingresar_a" value="Ingresar">
  </form>

  <form method="post" action="Tapete/conexiones/ingreso_admin.php">
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
  </form>
  <button id="olv-contr-d">¿Olvidaste tu contraseña?</button>


    <div id="ventana" title="Olvido de contraseña">
    <p class="validateTips">Responde la pregunta de seguridad</p>
    <form>
      <fieldset>
        <label for="pregunta">Pregunta</label>
        <input type="text" pregunta="pregunta" id="pregunta" value="" class="text ui-widget-content ui-corner-all" disabled>
        <label for="respuesta">Respuesta</label>
        <input type="text" pregunta="respuesta" id="respuesta" class="text ui-widget-content ui-corner-all">
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
      </fieldset>
    </form>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
</html>