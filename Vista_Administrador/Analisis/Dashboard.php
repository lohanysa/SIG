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

<!--barra de navegacion-->
<style>
    /* Estilos adicionales para la barra de navegación fija */
    nav {
        position: fixed;
        /* Fija la barra de navegación */
        top: 0;
        /* La barra se fija en la parte superior de la ventana */
        z-index: 1000;
        /* Asegura que la barra de navegación esté por encima de otros elementos */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Añade una sombra para mayor claridad */
    }

    body {
        padding-top: 60px;
        /* Añade un padding para evitar que el contenido quede oculto detrás de la barra */
    }
</style>
<!--barra de navegacion-->

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

    <div class="mt-4">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Dashboard de Ventas</h1>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('api.php')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.nombre);
                    const salesData = data.map(item => item.ventas);

                    const ctx = document.getElementById('salesChart').getContext('2d');
                    const salesChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Ventas',
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
                });
        });
    </script>
</body>

</html>