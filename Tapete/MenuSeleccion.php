<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/StyleMenu.css">
  <link rel="shortcut icon" href="Visual/Material/Didit.png" type="image/x-icon">
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery-3.7.1.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/bootstrap.bundle.js"></script>
  <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

  <title>Menú selección</title>
</head>

<body background="Visual/Fondos/FondoMenuInicio2.jpg">
  <?php 
    include('conexiones/sesion_alumno.php'); 
    if($sexo == "M"){
			$imagen = "Visual/Material/Recursos/SesionNiña.png";
		}
		else if ($sexo == "H"){
			$imagen = "Visual/Material/Recursos/SesionNiño.png";
		}
  ?>

<br><br>
  
  
  <!-- Animacion personaje -->
  <aside class="personaje">
  </aside>

    <!--Cards de seleccion de temas -->
    <div class="titulo">
      <font face="Century Gothic">
        <p><b>Inicia a jugar</b></p>
      </font>
    </div>

    <div class="bienvenido">
    <?php
        echo "<h2>¡Hola, " . $name . "! Empecemos a jugar</h2>";
      ?>
    </div> 

    <div style="margin-top:-130px;">
    <div class="cerrarSesion">
      <a style="color: black;" href="conexiones/cerrar_sesion.php">Cerrar sesión</a>
    </div>

    <div  style="margin-left:80%; margin-top:-30px;">
      <img class="usuario" id="usuario" src="<?php echo $imagen; ?>" width="40px">
      <a style="color: black;" href="ProgresoAlumno.php"><b>Mi perfil</b></a>
    </div>
    </div>
    
    <br>
    <section>
<br><br><br>
      <div class="card mb-3 card1" style="max-width: 600px;">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="Visual/Material/Menu/ImagenesNumeros.jpg"  width="220px" height="186px" >
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <font face="Arial Narrow">
                <h1 class="card-title"><b>Números</b></h1>
              <h5 class="card-text">Juegos de identifición de números y secuencia.</h5>
              <a href="JuegosNumeros.html" class="btn btn-warning boton2"><b>ENTRAR</b></a>
              </font>
            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="card mb-3 card2" style="max-width: 600px;">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="Visual/Material/Menu/ImagenesLetras.jpg"  width="220px" height="186px" >
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <font face="Arial Narrow">
                <h1 class="card-title"><b>Letras</b></h1>
              <h5 class="card-text">Juegos de identificación de vocabulario.</h5>
              <a href="JuegosLetras.html" class="btn btn-warning boton2"><b>ENTRAR</b></a>
              </font>
            </div>
          </div>
        </div>
      </div>
    </section>

    
</body>
</html>