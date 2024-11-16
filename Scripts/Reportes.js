document.getElementById("opcion").addEventListener("change", function () {
    if (document.getElementById("opcion").value == "mes") {
        document.getElementById("div_meses").hidden = false;
    } else {
        document.getElementById("div_meses").hidden = true;
    }

    if (document.getElementById("opcion").value == "trimestre") {
        document.getElementById("div_parte_anio").hidden = false;
    } else {
        document.getElementById("div_parte_anio").hidden = true;
    }
});







document.addEventListener("DOMContentLoaded", function () {
    fetch('/SIG/Server/info_mes_anio.php')
        .then(response => response.json())
        .then(data => {
            if (data.Error) {
                console.error(data.Error);
                return;
            }

            const anioSelectMes = document.getElementById('anio_mes');
            const mesSelect = document.getElementById('mes');
            const anioSelectTrimestre = document.getElementById('anio_trimestre');
            const trimestreSelect = document.getElementById('parte_anio');

            // Definir sets para evitar duplicados
            const aniosSet = new Set();
            const mesesSet = new Set();
            const trimestresSet = new Set();

            // Llenar los selects
            data.forEach(item => {
                // Evitar repetir los años
                if (!aniosSet.has(item.anio)) {
                    aniosSet.add(item.anio);
                    const optionAnioMes = document.createElement('option');
                    optionAnioMes.value = item.anio;
                    optionAnioMes.textContent = item.anio;
                    anioSelectMes.appendChild(optionAnioMes);

                    const optionAnioTrimestre = document.createElement('option');
                    optionAnioTrimestre.value = item.anio;
                    optionAnioTrimestre.textContent = item.anio;
                    anioSelectTrimestre.appendChild(optionAnioTrimestre);
                }

                // Evitar repetir los meses
                if (!mesesSet.has(item.mes)) {
                    mesesSet.add(item.mes);
                    const optionMes = document.createElement('option');
                    optionMes.value = item.mes;
                    optionMes.textContent = item.nombre_mes;
                    mesSelect.appendChild(optionMes);
                }

                // Evitar repetir los trimestres
                if (!trimestresSet.has(item.trimestre)) {
                    trimestresSet.add(item.trimestre);
                    const optionTrimestre = document.createElement('option');
                    optionTrimestre.value = item.trimestre;
                    optionTrimestre.textContent = `Trimestre ${item.trimestre}`;
                    trimestreSelect.appendChild(optionTrimestre);
                }
            });
        })
        .catch(error => console.error('Error al obtener los datos:', error));
});

//aqui van a estar los escuchas que filtran la inf para generar el reporte
document.getElementById("filtro_mes").addEventListener("click", function () {
    var datos = new FormData();
    datos.append('anio_mes', document.getElementById('anio_mes').value);
    datos.append('mes', document.getElementById('mes').value);

    fetch('/SIG/Server/Reporte_mes.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert("Hubo un error inesperado");
        } else {
            let vista = document.getElementById("vista");
            let ganancia = 0; // Inicializamos la ganancia total en 0

            // Encabezado de la tabla
            var head = `<table class="table">
                <thead>
                    <tr>
                        <th scope="col">Imagen</th>
                        <th scope="col">Código de amigurumi</th>
                        <th scope="col">Precio del amigurumi</th>
                        <th scope="col">Cantidad vendida</th>
                        <th scope="col">Venta total</th>
                        <th scope="col" colspan="2">Métodos de pago</th>
                    </tr>
                </thead>
                <tbody>`;

            // Cuerpo de la tabla
            var cuerpo = "";
            data.forEach(element => {
                cuerpo += `<tr>
                    <td><img src="${element.direccion_url}" alt="Imagen del amigurumi" width="50"></td>
                    <td>${element.id_amigurumis}</td>
                    <td>${element.precio}</td>
                    <td>${element.cantidad_comprada}</td>
                    <td>${element.venta_total}</td>
                    <td>Yappy: ${element.pagos_yappy}</td>
                    <td>Efectivo: ${element.pagos_efectivo}</td>
                </tr>`;
                ganancia += parseFloat(element.venta_total); // Aseguramos que la ganancia se sume como un número flotante
            });

            // Cerrar la tabla
            var footer = `<tr><td scope="col" colspan="6"><strong>Ganancia total del mes: </strong> ${ganancia.toFixed(2)}</td></tr> </tbody></table>`;

            // Actualizar la vista con la tabla completa
            vista.innerHTML = head + cuerpo + footer;
        }
    })
    .catch(error => {
        console.error('Hubo un problema en la solicitud del fetch', error);
    });
});

//generar el excel

document.getElementById("descargar_excel").addEventListener("click", function () {
    var datos = new FormData();
    datos.append('anio_mes', document.getElementById('anio_mes').value);
    datos.append('mes', document.getElementById('mes').value);

    fetch('/SIG/Server/Reporte_mes.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert("Hubo un error inesperado");
        } else {
            let ganancia = 0; // Inicializamos la ganancia total en 0

            // Creamos un array de datos para el Excel
            var excelData = [
                ["Imagen", "Código de amigurumi", "Precio del amigurumi", "Cantidad vendida", "Venta total", "Método de pago Yappy", "Método de pago Efectivo"] // Encabezado
            ];

            // Llenamos el array con los datos de la respuesta
            data.forEach(element => {
                excelData.push([
                    element.direccion_url,
                    element.id_amigurumis,
                    element.precio,
                    element.cantidad_comprada,
                    element.venta_total,
                    element.pagos_yappy,
                    element.pagos_efectivo
                ]);
                ganancia += parseFloat(element.venta_total); // Aseguramos que la ganancia se sume correctamente
            });

            // Agregar la fila con la ganancia total
            excelData.push(["", "", "", "", "Ganancia total del mes:", ganancia.toFixed(2)]);

            // Crear una hoja de cálculo a partir del array de datos
            var ws = XLSX.utils.aoa_to_sheet(excelData);

            // Crear un libro de trabajo (workbook) y añadirle la hoja
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Reporte de Ventas");

            // Generar un archivo Excel y ofrecerlo para descarga
            XLSX.writeFile(wb, "reporte_ventas.xlsx");
        }
    })
    .catch(error => {
        console.error('Hubo un problema en la solicitud del fetch', error);
    });
});
