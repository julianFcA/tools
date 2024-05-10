<?php
require_once './template.php';

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
    <h2>Iniciar Sesión</h2>
    <div class="form-group">
      <form action="../controller/AuthController.php" autocomplete="off" method="POST" id="formLogin" class="formulario active">
        <br>

        <input type="number" placeholder="Ingrese documento" class="input-text" name="documento" title="Debe tener de 8 a 10 dígitos" required onkeyup="espacios(this)" minlength="8" maxlength="10" oninput="validarNumeros(this)">
        <span id="errorDocumento" style="color: red; display: none;">El documento solo puede contener números</span>

        <div class="grupo-input">
          <input type="text" placeholder="Ingrese Primer Nombre" name="nombre" id="nombre" class="input-text clave" title="Debe tener de 3 a 10 letras" required onkeyup="espacios(this)" minlength="3" maxlength="10">
          <span id="errorNombre" style="color: red; display: none;">El nombre solo puede contener letras</span>
        </div>

        <div class="grupo-input">
          <input type="password" placeholder="Ingresa tu Contraseña" name="contrasena" id="contrasena" class="input-text clave" title="Debe tener de 6 a 25 caracteres" required onkeyup="espacios(this)" minlength="6" maxlength="50">
        </div>
        <br>

        <input class="btn" type="submit" name="iniciarSesion" value="Iniciar Sesión">

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

<script>
  
 function validarNumeros(input) {
        var documentoValue = input.value.trim();
        var numerosValidos = /^\d+$/;
        var errorDocumento = document.getElementById('errorDocumento');

        if (!numerosValidos.test(documentoValue)) {
            errorDocumento.style.display = 'block';
            input.setCustomValidity('El documento solo puede contener números');
        } else {
            errorDocumento.style.display = 'none';
            input.setCustomValidity('');
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        var nombreInput = document.querySelector('input[name="nombre"]');
        var errorNombre = document.getElementById('errorNombre');

        nombreInput.addEventListener('input', function() {
            var nombreValue = nombreInput.value.trim();
            var letrasValidas = /^[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s]*$/;

            if (!letrasValidas.test(nombreValue)) {
                errorNombre.style.display = 'block';
                nombreInput.setCustomValidity('El nombre solo puede contener letras');
            } else {
                errorNombre.style.display = 'none';
                nombreInput.setCustomValidity('');
            }
        });
    });
</script>