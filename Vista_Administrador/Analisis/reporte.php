<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Assets/Mugumis.ico" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../Estilos/stylesIndex.css">
    <link rel="stylesheet" href="../../Estilos/stylesCatalogo.css">

    <title>Reporte</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>


<style>
    .card-img-top {
        width: auto;
        height: auto;
        max-width: 100%;
        /* Esto asegura que la imagen no exceda el ancho del contenedor */
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    nav {
        position: fixed;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    body {
        padding-top: 60px;
    }
</style>

<body class="bg-indigo-#4338ca">
    <nav>
        <div class="logo">
            <img src="../../Assets/logoMugumis.png" alt="Logo">
        </div>
        <ul>
            <li><a href="../p_Gestioncatalogo.php">Catalogo</a></li>
            <li><a href="../P_Producto.html">Añadir Producto</a></li>
            <li><a href="../p_pedidos.php">Pedidos</a></li>
            <li><a href="Dashboard.php">Analisis</a></li>
        </ul>
    </nav>


    <div class="mt-4">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-6">Comparación Mensual de Compras</h1>
            <div class="bg-white p-6 rounded-lg shadow-lg">

                <label for="opcion" class="block mb-2">Escoja una opción</label>
                <select name="opcion" id="opcion" class="mb-6 block w-full p-2 border rounded">
                    <option value="">Seleccione el reporte</option>
                    <option value="mes">Ventas del mes</option>
                </select>

                <div class="mt-6 mb-6" id="div_meses" hidden>

                    <label for="anio_mes" class="block mb-2">Seleccione el año</label>
                    <select name="anio_mes" id="anio_mes" class="mb-4 block w-full p-2 border rounded">
                        <option>Seleccione el año</option>
                    </select>

                    <label for="mes" class="block mb-2">Seleccione el mes</label>
                    <select name="mes" id="mes" class="mb-4 block w-full p-2 border rounded">
                        <option>Seleccione el mes</option>
                    </select>

                    <button name="filtro_mes" id="filtro_mes" class="btn btn-primary w-full">Generar reporte</button>

                </div>

                <div class="mt-6 mb-6" id="div_parte_anio" hidden>
                    <label for="anio_trimestre" class="block mb-2">Seleccione el año</label>
                    <select name="anio_trimestre" id="anio_trimestre" class="mb-4 block w-full p-2 border rounded">
                        <option>Seleccione el año</option>
                    </select>

                    <label for="parte_anio" class="block mb-2">Seleccione el trimestre</label>
                    <select name="parte_anio" id="parte_anio" class="mb-4 block w-full p-2 border rounded">
                        <option>Seleccione el trimestre</option>
                    </select>

                    <button type="button" name="filtro_parte" id="filtro_parte" class="btn btn-primary w-full">Generar reporte</button>
                </div>
            </div>
        </div>
    </div>

    <div id="vista"></div>

    <button id="descargar_excel" class="btn btn-warning">Descargar Excel</button>

    <!--Div para hacer una visualizacion del reporte -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="../../Scripts/Reportes.js" defer></script>