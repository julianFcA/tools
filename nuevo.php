<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cuadro de Diálogo con Contraseña</title>
<link rel="stylesheet" href="styles.css">
<style>
/* Estilos para el cuadro de diálogo */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<body>

<!-- Cuadro de diálogo oculto inicialmente -->
<div class="modal" id="modal">
  <div class="modal-content">
    <span >&times;</span>
    <h2>Ingrese su contraseña:</h2>
    <input type="password" id="passwordInput" placeholder="Contraseña">
    <button onclick="validarCodigo()">Aceptar</button>
  </div>
</div>

<script>
// Mostrar el cuadro de diálogo automáticamente al cargar la página
window.onload = function() {
    document.getElementById("modal").style.display = "block";
};

// Función para cerrar el cuadro de diálogo
document.getElementById("close").onclick = function() {
    document.getElementById("modal").style.display = "none";
};

// Validar el código ingresado
function validarCodigo() {
    const codigoCorrecto = "contraseña123";
    const codigoIngresado = document.getElementById("passwordInput").value;
    
    if (codigoIngresado === codigoCorrecto) {
        alert("¡Contraseña correcta! Acceso permitido.");
        document.getElementById("modal").style.display = "none";
    } else {
        alert("Contraseña incorrecta. Acceso denegado.");
    }
}
</script>
</body>
</html>
