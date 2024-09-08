// Abre el modal de registro de correo electrónico
document.getElementById('registerUserLink').onclick = function() {
    document.getElementById('registerEmailModal').style.display = "block";
};

// Cierra los modales cuando se hace clic en el botón de cerrar
Array.from(document.getElementsByClassName('close')).forEach(closeButton => {
    closeButton.onclick = function() {
        closeButton.parentElement.parentElement.style.display = "none";
    };
});

// Cierra los modales cuando se hace clic fuera del contenido del modal
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
};

// Envía el formulario de registro de correo electrónico y muestra el modal de información adicional
document.getElementById('registerEmailForm').onsubmit = function(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;

    // Almacenar el correo en localStorage
    localStorage.setItem('email', email);

    // Mostrar modal de registro de información adicional
    document.getElementById('registerEmailModal').style.display = "none";
    document.getElementById('registerAdditionalInfoModal').style.display = "block";
};

// Envía el formulario de registro de información adicional y realiza la verificación del correo electrónico
document.getElementById('registerAdditionalInfoForm').onsubmit = function(event) {
    event.preventDefault();

    // Obtener el correo electrónico almacenado
    const email = localStorage.getItem('email');
    if (!email) {
        alert("Error: el correo electrónico no se encuentra.");
        return;
    }

    // Añadir el correo electrónico a los datos del formulario
    const formData = $("#registerAdditionalInfoForm").serializeArray();
    formData.push({ name: 'email', value: email });

    $.ajax({
        type: "POST",
        url: "Server/Usuario.php",
        data: $.param(formData),
        dataType: 'json',
        success: function(response) {
            if (response.exists) {
                showNotificationEmailExists();
            } else if (response.success) {
                showNotification();
            } else {
                console.log("Respuesta inesperada del servidor:", response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            alert("Error al conectar con el servidor. Intente de nuevo más tarde.");
        }
    });
};