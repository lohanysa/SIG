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

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ver-pedido').forEach(button => {
        button.addEventListener('click', function() {
            console.log('Entro al script Pedido');

            const modalPedido = document.getElementById('modal-pedido');
            modalPedido.style.display = 'block';

            const row = this.closest('.row');
            const idPedido = row.querySelector('.pedido-id').value;

            const datos = new FormData();
            datos.append('id', idPedido);
            console.log(datos);

            fetch('../Server/gestionPedido.php', { method: 'POST', body: datos })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    const correos = data.fk_cliente;
                    const url = data.direccion_url;
                    const fecha = data.fecha;
                    const cantidad = data.cantidad;
                    const metodoPago = data.metodo_pago;
                    const idPed = data.id;

                    const modalContent = modalPedido.querySelector('.modal-content');
                    modalContent.innerHTML = `
                        <span class="close">&times;</span>
                        <h2>Pedido ID: ${idPed}</h2>
                        <img src="${url}" alt="" style="width: 100%; height: auto; border-radius: 10px; margin-bottom: 20px;">
                        <p>Correo de cliente: ${correos}</p>
                        <p>Fecha: ${fecha}</p>
                        <p>Cantidad a comprar: ${cantidad}</p>
                        <select id="estadoAct">
                            <option value="Pagado y por retirar">Pagado</option>
                            <option value="Entregado">Entregado</option>
                        </select>
                        <p>Metodo de pago: ${metodoPago}</p>
                        <button id="submitActPedido">Confirmar Pedido</button>
                    `;

                    const closeBtn = modalContent.querySelector('.close');
                    closeBtn.addEventListener('click', function() {
                        modalPedido.style.display = 'none';
                    });

                    const submitBtn = modalContent.querySelector('#submitActPedido');
                    submitBtn.addEventListener('click', function() {
                        console.log('funciona el boton submit');
                        const datos2 = new FormData();
                        const estado = modalContent.querySelector('#estadoAct').value;
                        datos2.append('id', idPed);
                        datos2.append('estado', estado);
                        console.log(datos2);
                        Swal.fire({
                            title: 'Cambiar estado de pedido',
                            text: "¿Esta seguro que desea actualizar el estado del pedido?",
                            icon: 'warning',
                            background: '#e0f7fa', // Fondo azul suave
                            showCancelButton: true,
                            confirmButtonColor: '#4caf50', // Verde agradable
                            cancelButtonColor: '#8b2727', // Blanco suave
                            confirmButtonText: 'Confirmar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                            fetch('../Server/actualizarPedido.php', { method: 'POST', body: datos2 })
                                .then(res => res.json())
                                .then(data => {
                                    console.log(data);
                                    if (data.msg.includes('Se actualizo con exito')) {
                                        mostrarToast("Cambio de estado Confirmado.", "success");
                                        setTimeout(() => {
                                            window.location.href = '../Vista_Administrador/p_pedidos.php';
                                        }, 1500);
                                    }
                                })
                                .catch(error => { console.error('Hubo un error: ', error); });
                            }
                        });
                    });
                })
                .catch(error => { console.error('Hubo un error', error); });
        });
    });
});
