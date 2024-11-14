<!DOCTYPE html><html lang="en"><head>
    <meta charset="utf-8">
    <meta pregunta="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Dialog - Modal form</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <style>
      label, input { display:block; }
      input.text { margin-bottom:12px; width:95%; padding: .4em; }
      fieldset { padding:0; border:0; margin-top:25px; }
      h1 { font-size: 1.2em; margin: .6em 0; }
      .ui-dialog .ui-state-error { padding: .3em; }
      .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    <!-- <script> 
      $( function() {
        var dialog, form;
        //   num_empleado = $('#curp')
        //   pregunta = $( "#pregunta-a" ),
        //   respuesta = $( "#respuesta" );
    
        // function updateTips( t ) {
        //   tips
        //     .text( t )
        //     .addClass( "ui-state-highlight" );
        //   setTimeout(function() {
        //     tips.removeClass( "ui-state-highlight", 1500 );
        //   }, 500 );
        // }
    
        // function checkLength( o, n, min, max ) {
        //   if ( o.val().length > max || o.val().length < min ) {
        //     o.addClass( "ui-state-error" );
        //     updateTips( "Length of " + n + " must be between " +
        //       min + " and " + max + "." );
        //     return false;
        //   } else {
        //     return true;
        //   }
        // }
    
        // function checkRegexp( o, regexp, n ) {
        //   if ( !( regexp.test( o.val() ) ) ) {
        //     o.addClass( "ui-state-error" );
        //     updateTips( n );
        //     return false;
        //   } else {
        //     return true;
        //   }
        // }
    
        // function addUser() {
        //   var valid = true;
        //   allFields.removeClass( "ui-state-error" );
    
        //   valid = valid && checkLength( respuesta, "respuesta", 6, 80 );   
    
        //   if (valid) {
        //     ObtenerDatos();
        //     dialog.dialog( "close" );
        //   }
        //   return valid;
        // }
    
        dialog = $( "#ventana" ).dialog({
          autoOpen: false,
          height: 400,
          width: 350,
          modal: true,
          buttons: {
            "Verificar": addUser,
            Cancel: function() {
              dialog.dialog( "close" );
            }
          },
          close: function() {
            form[ 0 ].reset();
            allFields.removeClass( "ui-state-error" );
          }
        });
    
        form = dialog.find( "form" ).on( "submit", function( event ) {
          event.preventDefault();
          addUser();
        });
    
        $("#pregunta-a").button().on( "click", function() {
          dialog.dialog( "open" );
          var curpValue = $('#curp').val(); // Obtener el CURP


          fetch('Tapete/conexiones/consulta-alumno.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'curp=' + encodeURIComponent(curpValue) // Enviar el CURP por POST
        })
          .then(response => response.json()) // Convertir la respuesta en formato JSON
            .then(data => {
                console.log(data);
                if (data.pregunta) {
                    $('#pregunta').val(data.pregunta); // Rellenar el campo con la pregunta
                } else {
                    alert('No se encontró la pregunta para este CURP.');
                }
            })
            .catch(error => {
                console.error(error);
            });
        });
      } );
    </script> -->
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
      <input type="submit" name="ingresar_a" value="Ingresar" id="ingresar_a">
      <button id="pregunta-a" name="pregunta-a">¿Olvidaste tu contraseña?</button>
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
      <button type="submit" id="pregunta-d">¿Olvidaste tu contraseña?</button>
  </form>
   
  <div id="ventana" title="Olvido de contraseña">
    <p class="validateTips">Responde la pregunta de seguridad</p>
   
    <form>
      <fieldset>
        <label for="pregunta">Pregunta</label>
        <input type="text" class="pregunta" id="pregunta" value="<?php echo htmlspecialchars($pregunta); ?>" class="text ui-widget-content ui-corner-all" >
        <label for="respuesta">Respuesta</label>
        <input type="text" class="respuesta" id="respuesta" class="text ui-widget-content ui-corner-all">
   
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
      </fieldset>
    </form>
  </div>
  </body>
  </html>