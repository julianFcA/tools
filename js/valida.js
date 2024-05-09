document.addEventListener('DOMContentLoaded', function() {
    // Obtén el formulario
    var form = document.forms['formRegister'];

    // Agrega un evento de escucha al formulario
    form.addEventListener('submit', function(event) {
        // Validaciones adicionales
        if (!validateForm()) {
            event.preventDefault(); // Evita que el formulario se envíe si hay errores
        }
    });

    // Función para validar el formulario
    function validateForm() {
        var documento = form['documento'].value;
        var nombre = form['nombre'].value;
        var correo = form['correo'].value;

        // Aplica las funciones de validación específicas
        mayuscula(form['nombre']); // Convierte a mayúsculas el nombre
        eliminarEspacios(form['documento']); // Elimina espacios en el documento

        // Realiza tus validaciones aquí y muestra mensajes de error si es necesario

        // Ejemplo de validación para el documento
        if (documento.length !== 10 || isNaN(documento)) {
            showError('Documento debe tener 10 dígitos numéricos');
            return false;
        }

        // Ejemplo de validación para el nombre
        if (nombre.length < 3 || nombre.length > 12) {
            showError('Nombre debe tener entre 3 y 12 caracteres');
            return false;
        }

        // Ejemplo de validación para el correo
        if (!validateEmail(correo)) {
            showError('Correo electrónico no válido');
            return false;
        }

        // Más validaciones según sea necesario...

        return true; // Si todas las validaciones pasan, retorna true
    }

    // Función para validar un correo electrónico con expresión regular
    function validateEmail(email) {
        var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return regex.test(email);
    }

    // Función que elimina espacios en blanco
    function eliminarEspacios(input) {
        input.value = input.value.replace(/\s/g, '');
    }

    // Función para mostrar un mensaje de error
    function showError(message) {
        var errorContainer = document.querySelector('.error-text');
        errorContainer.textContent = message;
    }
});

function validarLetrasConEspacios(nom_empre, direcc_empre) {
    input.setCustomValidity('');
    let regex = /^[a-zA-Z\s]{6,20}$/;
    if (!regex.test(nom_empre.value, direcc_empre.value)) {
        input.setCustomValidity('El nombre de la empresa debe contener solo letras y espacios, y tener entre 6 y 20 caracteres.');
    }
}

// Función para abrir el overlay de términos
function openOverlayTerminos() {
    document.getElementById('overlay-terminos').style.display = 'flex';
}

// Función para cerrar el overlay de términos
function closeOverlayTerminos() {
    document.getElementById('overlay-terminos').style.display = 'none';
}




function validateForm() {
    var nom_empre = document.forms["formRegister"]["nom_empre"].value;
    var correo_empre = document.forms["formRegister"]["correo_empre"].value;
    var direcc_empre = document.forms["formRegister"]["direcc_empre"].value;
    var telefono = document.forms["formRegister"]["telefono"].value;
    var nom_tp_herra = document.forms["formRegister"]["nom_tp_herra"].value;
    var nom_marca = document.forms["formRegister"]["nom_marca"].value;

    // Aplica las funciones de validación específicas
    mayuscula(form['nom_empre']); // Convierte a mayúsculas el nombre
    espacios(form['telefono']); // Elimina espacios en el documento

    // Realiza tus validaciones aquí y muestra mensajes de error si es necesario

    // Ejemplo de validación para el documento
    if (telefono.length !== 12 || isNaN(telefono)) {
        showError('Documento debe tener 12 dígitos numéricos');
        return false;
    }

    // Ejemplo de validación para el nombre
    if (nom_empre.length < 3 || nom_empre.length > 15) {
        showError('Nombre debe tener entre 3 y 15 caracteres');
        return false;
    }

    if (nom_tp_herra.length < 3 || nom_tp_herra.length > 15) {
        showError('El tipo de herramienta debe tener entre 3 y 12 caracteres');
        return false;
    }

    if (nom_marca.length < 3 || nom_marca.length > 15) {
        showError('Nombre de marca debe tener entre 3 y 12 caracteres');
        return false;
    }

    // Ejemplo de validación para el correo
    if (!validateEmail(correo_empre)) {
        showError('Correo electrónico no válido');
        return false;
    }

    var direccionRegex = /^[a-zA-Z0-9\s\-,.#áéíóúÁÉÍÓÚñÑ]+$/;
    if (!direccionRegex.test(direcc_empre) || direcc_empre.length < 6 || direcc_empre.length > 50) {
        showError('La dirección ingresada no es válida. Debe contener letras, números y espacios, y tener entre 6 y 100 caracteres.');
        return false;
    }

    // Más validaciones según sea necesario...

    return true; // Si todas las validaciones pasan, retorna true
}
function validarLetras(input) {
    // Obtener el valor actual del campo
    var valor = input.value;

    // Eliminar caracteres no alfabéticos
    var letras = valor.replace(/[^a-zA-Z]/g, '');

    // Actualizar el valor del campo con solo letras
    input.value = letras;
}
function espacios(input) {
    // Reemplazar los espacios en blanco
    var texto = input.value;
    texto = texto.replace(/\s/g, '');
    input.value = texto;
}

function showError(message) {
    // Muestra un mensaje de error en el contenedor designado
    var errorContainer = document.querySelector('.error-text');
    errorContainer.textContent = message;
}
// Agrega más funciones de validación según sea necesario

function validateEmail(email) {
    // Expresión regular para validar un correo electrónico
    var regex =
        /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    // Prueba la validez del correo electrónico
    return regex.test(email);
}



function validarContraseña() {
    var contraseña = document.getElementById("contrasena").value;
    var mayusculaRegex = /[A-Z]/;
    var numeroRegex = /[0-9]/;
    var signoRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

    if (!mayusculaRegex.test(contraseña)) {
        alert("La contraseña debe contener al menos una letra mayúscula.");
        return false;
    }
    if (!numeroRegex.test(contraseña)) {
        alert("La contraseña debe contener al menos un número.");
        return false;
    }
    if (!signoRegex.test(contraseña)) {
        alert("La contraseña debe contener al menos un signo.");
        return false;
    }
    return true;
}




// _____________________________

// Mostrar el cuadro de diálogo automáticamente al cargar la página

function validarCodigo() {
    const codigoCorrecto = "julian1110567986";
    const codigoIngresado = document.getElementById("passwordInput").value;

    if (codigoIngresado === codigoCorrecto) {
        alert("¡Código de Confirmación Correcto! Acceso permitido.");
        document.getElementById("modal").style.display = "none";
    } else {
        alert("Código incorrecto. Acceso denegado.");
    }
}

// Mostrar el cuadro de diálogo automáticamente al cargar la página
window.onload = function() {
    document.getElementById("modal").style.display = "block";

    // Asignar evento al botón de cierre después de que el DOM esté completamente cargado
    document.getElementById("close").onclick = function() {
        document.getElementById("modal").style.display = "none";
        window.location.href = "./../index.php"; // Redirigir a la página principal
    };
};



// Función para obtener el valor de una cookie por su nombre
function getCookie(cookieName) {
    var name = cookieName + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(';');
    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return "";
}



// paginacion

// $(document).ready(function() {
//     $('#example3').DataTable({
//         processing: true,
//         serverSide: true,
//         ajax: {
//             url: './../superadmin/licencia.php',
//             data: function(data) {
//                 data.page = $('#example3').DataTable().page.info().page + 1;
//                 data.searchTerm = $('#searchInput').val();
//             }
//         },
//         language: {
//             "sProcessing": "Procesando...",
//             "sLengthMenu": "Mostrar _MENU_ registros",
//             "sZeroRecords": "No se encontraron resultados",
//             "sEmptyTable": "Ningún dato disponible en esta tabla",
//             "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
//             "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
//             "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
//             "sInfoPostFix": "",
//             "sSearch": "Buscar:",
//             "sUrl": "",
//             "sInfoThousands": ",",
//             "sLoadingRecords": "Cargando...",
//             "oPaginate": {
//                 "sFirst": "Primero",
//                 "sLast": "Último",
//                 "sNext": "Siguiente",
//                 "sPrevious": "Anterior"
//             },
//             "oAria": {
//                 "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
//                 "sSortDescending": ": Activar para ordenar la columna de manera descendente"
//             }
//         }
//     });
// });
