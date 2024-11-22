<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/StyleMenu.css">

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>

    <title>Menú selección</title>
</head>

<body background="Visual/Fondos/FondoMenuInicio2.jpg">
  <!-- Animacion personaje -->
  <aside class="personaje">
  </aside>

    <!--Cards de seleccion de temas -->
    <div class="titulo">
      <font face="Century Gothic">
        <p><b>Inicia a jugar</b></p>
      </font>
    </div>
    
    <?php 
      include('conexiones/sesion_alumno.php'); 
    ?>
    
    <section>

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

    <a href="conexiones/cerrar_sesion.php">Cerrar sesión</a>
</body>
</html>