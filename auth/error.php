<?php
require_once 'template.php';

$consulta2 = $conn->prepare("SELECT * FROM usuario");
$consulta2->execute();
$consulll = $consulta2->fetch();

$consulta4 = $conn->prepare("SELECT * FROM rol");
$consulta4->execute();
$consullll = $consulta4->fetch();

$consulta5 = $conn->prepare("SELECT * FROM estado_usu");
$consulta5->execute();
$consulllll = $consulta5->fetch();
?>

<div class="login_container">
  <div class="login_form">
    <br>
    <h2>Error al Iniciar Sesión</h2>
    <div class="form-group">
      <form action="../controller/AuthController.php" autocomplete="off" method="POST" id="formLogin" class="formulario active">
        <br>

        <input type="number" placeholder="Ingrese documento" class="input-text" name="documento" title="Debe tener de 5 a 10 dígitos" required onkeyup="espacios(this)" minlength="5" maxlength="10">

        <div class="grupo-input">
          <input type="text" placeholder="Ingrese Nombre" name="nombre" class="input-text clave" title="Debe tener de 3 a 15 letras" required onkeyup="espacios(this)" minlength="3" maxlength="15">
        </div>

        <div class="grupo-input">
          <input type="password" placeholder="Ingresa tu Contraseña" name="contrasena" class="input-text clave" title="Debe tener de 8 a 20 caracteres" required onkeyup="espacios(this)" minlength="8" maxlength="20">
        </div>
        <br>

        <input class="btn1" type="submit" name="iniciarSesion" value="Iniciar Sesión">

        <div class="redirecciones">
          <a href="../index.php" class="link return">Regresar</a>
        </div>
        <div class="botones-container">
          <div class="redirecciones">
            <a href="./registro.php" class="link return">Registro</a>
          </div>
          <div class="redirecciones">
            <a href="../correo.php" class="link return">¿Olvidó su contraseña?</a>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<section class="container-fluid footer_section1">
  <p>
    Sena. Ibagué - Tolima
    <a href="https://centrodeindustria.blogspot.com/"> Centro de Industria y Construcción</a>
  </p>
</section>