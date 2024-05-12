function minuscula(e) {
    e.value = e.value.toLowerCase();
}

// Función que elimina espacios en blanco
function eliminarEspacios(e) {
    e.value = e.value.replace(/\s/g, '');
}


// Función que activa o desactiva la clase 'active' en la barra de navegación dependiendo del desplazamiento de la página
$(document).ready(function() {
    var $window = $(window);
    var nav = $('.fixed-button');
    $window.scroll(function() {
        if ($window.scrollTop() >= 200) {
            nav.addClass('active');
        } else {
            nav.removeClass('active');
        }
    });
});

// Validaciones del primer formulario
document.addEventListener('DOMContentLoaded', function() {
    var form = document.forms['formRegister'];

    // Agrega un evento de escucha al formulario
    form.addEventListener('submit', function(event) {
        // Validaciones adicionales
        if (!validateForm()) {
            event.preventDefault(); // Evita que el formulario se envíe si hay errores
        }
    });

    // Función para validar el primer formulario
    function validateForm() {
        var documento = form['documento'].value;
        var nombre = document.getElementsByName('nombre')[0].value;
        var apellido = document.getElementsByName('apellido')[0].value;
        var correo = form['correo'].value;
    
        // Aplica las funciones de validación específicas
        minuscula(form['nombre']); 
        minuscula(form['apellido']); 
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
    
        // Ejemplo de validación para el apellido
        if (apellido.length < 3 || apellido.length > 15) {
            showError('El apellido debe tener entre 3 y 15 caracteres');
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
    

    // Función que elimina espacios en blanco
    function eliminarEspacios(input) {
        input.value = input.value.replace(/\s/g, '');
    }

    // Función para mostrar un mensaje de error
    function showError(message) {
        var errorContainer = document.querySelector('.error-text');
        errorContainer.textContent = message;
    }

    // Función para validar un correo electrónico con expresión regular
    function validateEmail(email) {
        var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return regex.test(email);
    }
});

// Validaciones del segundo formulario
document.addEventListener('DOMContentLoaded', function() {
    var form = document.forms['formRegister'];

    // Agrega un evento de escucha al formulario
    form.addEventListener('submit', function(event) {
        // Validaciones adicionales
        if (!validateForm()) {
            event.preventDefault(); // Evita que el formulario se envíe si hay errores
        }
    });

    // Función para validar el segundo formulario
    function validateForm() {
        var ficha = form['ficha'].value;
        var nom_forma = form['nom_forma'].value;

        // Ejemplo de validación para la ficha
        if (ficha.length !== 7 || isNaN(ficha)) {
            showError('La ficha debe ser de 7 dígitos numéricos.');
            return false;
        }

        // Ejemplo de validación para el nombre de formación
        if (nom_forma.length < 3 || nom_forma.length > 12) {
            showError('El nombre de formación debe tener entre 3 y 12 caracteres.');
            return false;
        }

        // Puedes agregar más validaciones aquí según sea necesario...

        return true; // Si todas las validaciones pasan, retorna true
    }

    // Función para mostrar un mensaje de error
    function showError(message) {
        var errorContainer = document.querySelector('.error-text');
        errorContainer.textContent = message;
    }

    // Agrega más funciones de validación según sea necesario
});

// Función para abrir el overlay de términos
function openOverlayTerminos() {
    document.getElementById('overlay-terminos').style.display = 'flex';
}

// Función para cerrar el overlay de términos
function closeOverlayTerminos() {
    document.getElementById('overlay-terminos').style.display = 'none';
}


function maxlengthNumber(obj) {
    if (obj.value.length > obj.maxLength) {
        obj.value = obj.value.slice(0, obj.maxLength);
        alert("Debe ingresar solo el número de dígitos requeridos");
    }
}

//validacion de cambio de contraseña

function validarContraseña() {
    var contraseña = document.getElementById("contrasena","cont","conta").value;
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


    function prepareAndRedirect() {
        const selectedWeapons = document.querySelectorAll('input[type="checkbox"]:checked');
        const selectedIds = Array.from(selectedWeapons).map(checkbox => checkbox.value).join(',');
        const url = `../public/instru/termino_prestamo.php?herramienta=${selectedIds}`;

        // Asigna la URL al formulario y envía el formulario
        const form = document.getElementById('ventanaEmergente');
        form.action = url;
        form.submit();
    }



// paginacion

$(document).ready(function() {
    $('#example3').DataTable({
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});
