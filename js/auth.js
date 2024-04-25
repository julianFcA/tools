// Función que convierte el texto a mayúsculas
// function mayuscula(e) {
//     e.value = e.value.toUpperCase();
// }

// // Función que convierte el texto a minúsculas
// function minuscula(e) {
//     e.value = e.value.toLowerCase();
// }

// Función que elimina espacios en blanco
function eliminarEspacios(e) {
    e.value = e.value.replace(/\s/g, '');
}

// Función que limita la longitud máxima del número ingresado
function limitarLongitudNumero(obj) {
    if (obj.value.length > obj.maxLength) {
        obj.value = obj.value.slice(0, obj.maxLength);
        alert("Debe ingresar solo el número de dígitos requeridos");
    }
}

// Función que valida la entrada para permitir solo números
function soloNumeros(e) {
    var key = e.keyCode || e.which;
    var teclado = String.fromCharCode(key).toLowerCase();
    var numeros = "1234567890";
    var especiales = "8-37-38-46-164-46";
    var tecladoEspecial = false;

    for (var i in especiales) {
        if (key == especiales[i]) {
            tecladoEspecial = true;
            alert("Debe ingresar solo números en el formulario");
            break;
        }
    }

    if (numeros.indexOf(teclado) == -1 && !tecladoEspecial) {
        e.preventDefault();
        alert("Debe ingresar solo números en el formulario");
    }
}

// Función que valida la entrada para permitir solo letras, números y guiones bajos en la contraseña
function validarPassword(event) {
    var key = event.keyCode || event.which;
    var char = String.fromCharCode(key);
    var regex = /[0-9a-zA-Z_]/;

    if (!regex.test(char)) {
        event.preventDefault();
        return false;
    }
}

// Función para validar un correo electrónico con expresión regular
function validarEmail(email) {
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
}

// Función para validar el formulario al enviar
function validarFormulario(event) {
    var form = document.forms['formRegister'];
    var documento = form['documento'].value;
    var nombre = form['nombre'].value;
    var correo = form['correo'].value;
    var contrasena = form['contrasena'].value;

    eliminarEspacios(form['documento']); // Elimina espacios en el documento

    if (documento.length !== 10 || isNaN(documento)) {
        showError('Documento debe tener 10 dígitos numéricos');
        event.preventDefault();
        return false;
    }

    if (nombre.length < 6 || nombre.length > 12) {
        showError('Nombre debe tener entre 6 y 12 caracteres');
        event.preventDefault();
        return false;
    }

    if (!validarEmail(correo)) {
        showError('Correo electrónico no válido');
        event.preventDefault();
        return false;
    }

    return true;
}

// Función para mostrar un mensaje de error
function showError(message) {
    var errorContainer = document.querySelector('.error-text');
    errorContainer.textContent = message;
}

// Función para abrir el overlay de términos
function openOverlayTerminos() {
    document.getElementById('overlay-terminos').style.display = 'flex';
}

// Función para cerrar el overlay de términos
function closeOverlayTerminos() {
    document.getElementById('overlay-terminos').style.display = 'none';
}

// Agregar evento de carga para validar el formulario
document.addEventListener('DOMContentLoaded', function() {
    var form = document.forms['formRegister'];
    form.addEventListener('submit', validarFormulario);
});



// login
// document.addEventListener("DOMContentLoaded", function() {
    var formLogin = document.getElementById('formLogin');
    formLogin.addEventListener('submit', function(event) {
        var nombreInput = document.getElementById('nombre');
        var nombre = nombreInput.value.trim();
        var errorNombre = document.getElementById('errorNombre');

        // Lógica de validación del nombre
        if (nombre.length === 0) {
            event.preventDefault(); // Evitar que se envíe el formulario
            errorNombre.textContent = 'Por favor, ingrese su nombre.';
            return false;
        } else {
            errorNombre.textContent = '';
        }
    });



// registro
$(document).ready(function(){
    $('#formulario').submit(function(e){
        e.preventDefault();
        var documento = $('#documento').val();
        
        $.ajax({
            type: 'POST',
            url: '../controller/RegisterController.php',
            data: {documento: documento},
            success: function(response){
                $('#mensaje').html(response);
            }
        });
    });
});