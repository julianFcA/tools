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
        if (nombre.length < 6 || nombre.length > 12) {
            showError('Nombre debe tener entre 6 y 12 caracteres');
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

    // Función que convierte el texto a mayúsculas
    // function mayuscula(input) {
    //     input.value = input.value.toUpperCase();
    // }

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

    // Ejemplo de validación para el correo
    if (!validateEmail(correo_empre)) {
        showError('Correo electrónico no válido');
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

window.addEventListener('load', function () {
    // Verificar si la página se carga directamente desde la URL
    var isDirectAccess = window.location.pathname.indexOf("/superadmin/index.php") !== -1;

    if (isDirectAccess) {
        // Verificar si ya hay una cookie de sesión y si ha pasado más de una hora desde su creación
        var currentTime = new Date().getTime();
        var sessionExpired = document.cookie.indexOf('superadmin_valido=') === -1 || currentTime - parseInt(getCookie('hora_ingreso')) > 3600000;

        if (sessionExpired) {
            // Solicitar al usuario que ingrese el código de confirmación como una contraseña
            var codigoIngresado = prompt("Ingresa el código de confirmación:", "");
            codigoIngresado.type="password" ; // Cambiar el tipo de entrada a "password"

            // Definir el código correcto como cadena
            var codigoCorrecto = "101214"; // Código correcto definido en el PHP

            // Verificar si el código ingresado es correcto
            if (codigoIngresado === codigoCorrecto) {
                // Si el código es correcto, establecer una nueva cookie de sesión
                document.cookie = "superadmin_valido=true; path=/superadmin/index.php; expires=" + new Date(currentTime + 3600000).toUTCString();
                document.cookie = "hora_ingreso=" + currentTime + "; path=/superadmin/index.php; expires=" + new Date(currentTime + 3600000).toUTCString();
                alert('Sesión activa. Bienvenido de nuevo.');
            } else {
                // Si el código ingresado es incorrecto, redirigir a la página de denegación
                alert('Código incorrecto. No se puede acceder.');
                window.location.href = './../index.php'; // Redirigir a la página de denegación
            }
        }
    }
});

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
