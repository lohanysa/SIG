
document.addEventListener("DOMContentLoaded", function() {
    //ventas del mes 
    fetch('/SIG/Server/api.php')
        .then(response => response.json())
        .then(data => {
            if (data.ERROR) {
                console.error(data.ERROR);
                return;
            }
            const labels = data.map(item => item.nombre);
            const salesData = data.map(item => item.ventas);

            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas del mes',
                        data: salesData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al obtener los datos:', error));

        //clientes mas frecuentes
        fetch('/SIG/Server/api.cliente.php')
        .then(response => response.json())
        .then(data => {
            if (data.ERROR) {
                console.error(data.ERROR);
                return;
            }
            let clientes = document.getElementById("clientes");
            let row = document.createElement('div');
            row.className = 'row';

            data.forEach(element => {
                var carta = ` 
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card" style="width: 18rem;">
                        <img src="../../Assets/Analisis-user-imag/abeja.png" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" id="titulo">${element.nombre} ${element.apellido}</h5>
                            <h6 id="info">correo: ${element.id_correo} 
                            <br>
                            cantidad de compras realizadas(transacciones): ${element.cantidad_transacciones}</h6>
                            <!--se podria hacer un boton para enviar promociones a los clientes mas frecuentes ?-->
                            <a href="#" class="btn btn-primary">enviar correo</a>
                        </div>
                    </div>
                </div>
                `;
                row.innerHTML += carta;
            });
            //esto es para insertar las filas como como un nodo hijo de clientes
            clientes.appendChild(row);
        })
        .catch(error => console.error('Error al obtener los datos:', error));


        //comparacion de ventas en los untimos meses
        fetch('/SIG/Server/api_comparacion.php')
        .then(response => response.json())
        .then(data => {
            if (data.ERROR) {
                console.error(data.ERROR);
                return;
            }
            const labels = data.map(item => item.mes);
            const salesData = data.map(item => item.total_ventas);

            const ctx = document.getElementById('comparacion').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Comparacion de ventas 6 meses',
                        data: salesData,
                        backgroundColor: 'rgba(25, 151, 10, 0.2)',
                        borderColor: 'rgba(25, 151, 10, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al obtener los datos:', error));
        
        //menos comprados 
        fetch('/SIG/Server/api_menosComprado.php')
        .then(response => response.json())
        .then(data => {
            if (data.ERROR) {
                console.error(data.ERROR);
                return;
            }
            let clientes = document.getElementById("menos");
            let row = document.createElement('div');
            row.className = 'row';

            data.forEach(element => {
                var carta = ` 
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card" style="width: 18rem;">
                        <img src=${element.direccion_url} class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" id="titulo">${element.nombre} </h5>
                            <h6 id="info">precio: ${element.precio}
                            <br>
                            cantidad de trnasacciones ${element.cantidad_transacciones}</h6>
                        </div>
                    </div>
                </div>
                `;
                row.innerHTML += carta;
            });
            //esto es para insertar las filas como como un nodo hijo de clientes
            clientes.appendChild(row);
        })
        .catch(error => console.error('Error al obtener los datos:', error));
});