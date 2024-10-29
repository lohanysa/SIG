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

    <title>Dashboard de Ventas</title>
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
            <li><a href="../p_pedidos.php">Analisis</a></li>
        </ul>
    </nav>
    <section id="ventas">
        <div class="mt-4">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4">ventas del Mes </h1>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <section id="comparacion_de_ventas">
        <div class="mt-4">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4">comparacion Mensual de compras</h1>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <canvas id="comparacion"></canvas>
                </div>
            </div>
        </div>
    </section>

    <section id="menos_comprados">
        <div class="mt-4">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4">menos populares</h1>
                <div class="bg-white p-6 rounded-lg shadow-lg" id="menos">
                </div>
            </div>
        </div>
    </section>


    <section id="clientes_frecuentes">
        <div class="mt-4">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4">Clientes mas frecuentes</h1>
                <div class="bg-white p-6 rounded-lg shadow-lg" id="clientes">
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../Scripts/api.js" defer></script>

</body>

</html>