// Obtener todos los botones de "Realizar Pedido"
const buttons = document.querySelectorAll('button');

function mostrarToast(mensaje, tipo) {
    const toast = document.getElementById('toast-notification');
    const toastMessage = toast.querySelector('.toast-message');
    const toastIcon = toast.querySelector('.toast-icon');

    // Configura los estilos basados en el tipo de mensaje
    toast.classList.remove('success', 'error', 'info'); // Limpia todas las clases de tipo
    toastIcon.textContent = ''; // Limpia el icono

    if (tipo === "success") {
        toast.classList.add('success');
        toastIcon.textContent = "✔️";
    } else if (tipo === "error") {
        toast.classList.add('error');
        toastIcon.textContent = "❌";
    } else if (tipo === "info") {
        toast.classList.add('info');
        toastIcon.textContent = "ℹ️";
    }

    toastMessage.textContent = mensaje;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000); // Duración de la notificación
}

// Iterar sobre cada botón y agregar un evento clic
buttons.forEach(button => {
    button.addEventListener('click', function() {
        // Obtener información del artículo
        const article = this.closest('article');
        const articulo = article.querySelector('h2').textContent;
        const descripcion = article.querySelector('p').textContent;
        const precio = article.querySelector('h4').textContent;
        const imagenSrc = article.querySelector('img').src;
        const idAmig = article.querySelector('input').value;

        // Almacenar información en local storage
        localStorage.setItem('pedido', JSON.stringify({
            articulo: articulo,
            descripcion: descripcion,
            precio: precio,
            imagenSrc: imagenSrc,
            idAmig: idAmig
        }));

        // Redirigir a la página P_Registro_Pedido.html
        window.location.href = 'P_Registro_Pedido.html';
    });
});

// Código para P_Registro_Pedido.html
document.addEventListener('DOMContentLoaded', function() {
    const pedido = JSON.parse(localStorage.getItem('pedido'));

    // Verificar si hay un pedido guardado en localStorage
    if (pedido) {
        // Mostrar los detalles del pedido en la página de pedido
        document.getElementById('modal-img').src = pedido.imagenSrc;
        document.getElementById('modal-articulo').textContent += pedido.articulo;
        document.getElementById('modal-descripcion').textContent += pedido.descripcion;
        document.getElementById('modal-precio').textContent += pedido.precio;
        document.getElementById('idAmiguru').value = pedido.idAmig;
    } else {
        // Si no hay pedido en localStorage y estamos en la página de pedido
        if (window.location.pathname.includes('P_Registro_Pedido.html') && !sessionStorage.getItem('redirigido')) {
            sessionStorage.setItem('redirigido', 'true');
            window.location.href = 'p_Catalogo.php';
        }
    }

    // Limpiar el indicador de redirección en caso de volver a la página de catálogo
    if (window.location.pathname.includes('p_Catalogo.php')) {
        sessionStorage.removeItem('redirigido');
    }

    // Agregar evento para el botón de confirmar pedido
    document.getElementById('submitPedido').addEventListener('click', function() {
        const email = document.getElementById('email').value;
        const metodoPago = document.getElementById('metodoPago').value;
        const cantidad = document.getElementById('cantidad').value;
        const idAmig = document.getElementById('idAmiguru').value;

        const datos = new FormData();
        datos.append('correo', email);
        datos.append('id', idAmig);
        datos.append('pago', metodoPago);
        datos.append('cantidad', cantidad);
        Swal.fire({
            title: 'Realizar Peticion de Pedido',
            text: "Los pedidos realizados tardarán un plazo de 2 dias en confirmarse, recibirá un correo con la información para su pago y retiro",
            icon: 'warning',
            background: '#e0f7fa', // Fondo azul suave
            showCancelButton: true,
            confirmButtonColor: '#4caf50', // Verde agradable
            cancelButtonColor: '#8b2727', // Blanco suave
            confirmButtonText: 'Realizar pedido',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('Server/Pedido.php', { 
                    method: 'POST', 
                    body: datos 
                })
                .then(res => res.json())
                .then(data => {
                console.log(data);
                    if (data.msg.includes('Pedido en proceso.')) {
                        mostrarToast("Pedido realizado.", "success");
                        setTimeout(() => {
                            window.location.href = 'p_Catalogo.php';
                        }, 1500);
                    } else {
                        if (data.msg.includes('El correo electronico no esta registrado, Registrese antes de poder hacer un pedido.')) {
                            mostrarToast(data.msg, "error");
                            setTimeout(() => {
                                window.location.href = 'p_Catalogo.php';
                            }, 3200);
                        }else{
                            mostrarToast(data.msg, "error");
                        }
                    }
                })
                .catch(error => {
                    console.error('Hubo un error', error);
                    mostrarToast("Error al conectar con el servidor. Intente de nuevo más tarde.", "error");
                });
            }
        });
    });

    // Funciones para mostrar notificaciones
    function showNotification() {
        const notification = document.getElementById('notification');
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    function showNotificationEmailExists() {
        const notification = document.getElementById('notificationEmailExists');
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    // Evento clic para el botón de cerrar pedido
    document.getElementById('closePedido').addEventListener('click', function() {
        localStorage.removeItem('pedido');
        window.location.href = 'p_Catalogo.php';
    });

    // Evento antes de recargar la página
    window.addEventListener('beforeunload', function() {
        localStorage.removeItem('pedido');
    });
});


