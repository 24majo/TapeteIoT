<?php
include'conexion.php';
session_start();
$pregunta = "";
if (isset($_GET['curp'])) {
    $curp = $_GET['curp'];

    $sql = "SELECT Pregunta FROM usuarios WHERE CURP = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $curp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $pregunta = $row['Pregunta']; 
        echo $pregunta;
        exit;
    } 
    else {
        $pregunta = 'Pregunta no encontrada';
    }
    exit;
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
?>