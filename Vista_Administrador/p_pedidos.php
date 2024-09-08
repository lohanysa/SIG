<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mugumis Store</title>
    <link rel="icon" href="../Assets/Mugumis.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../Estilos/stylesIndex.css">
    <link rel="stylesheet" href="../Estilos/stylesCatalogo.css">
    <link rel="stylesheet" href="../Estilos/styleProducto.css?v=1.2">
    <link rel="stylesheet" href="../Estilos/stylesModal.css?v=1.1">

    <!-- BOOSTRAP -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

    <style>
        /* Estilos adicionales para la barra de navegación fija */
        nav {
            position: fixed;
            /* Fija la barra de navegación */
            top: 0;
            /* La barra se fija en la parte superior de la ventana */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Añade una sombra para mayor claridad */
        }

        body {
            padding-top: 60px;
            /* Añade un padding para evitar que el contenido quede oculto detrás de la barra */
        }


        .Tabula {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
            width: 80%;
            margin: auto;
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .row {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .row:hover {
            background-color: #e7f0ff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .header-row {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }

        .header-row:hover {
            background-color: #0056b3; /* Color de fondo más oscuro para la cabecera */
        }

        .cell {
            flex: 1;
            padding: 10px;
            text-align: center;
            border-right: 1px solid #ddd;
            border-left: 1px solid #ddd;
        }

        .cell:last-child {
            border-right: none;
        }

        .ver-pedido {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            font-size: 14px;
        }

        .ver-pedido:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .ver-pedido:focus {
            outline: none;
        }

    </style>
    <script>
        localStorage.removeItem('editAmigurumi');
    </script>
</head>

<body>
    <!-- Barra de navegación -->
    <nav>
        <div class="logo">
            <img src="../Assets/logoMugumis.png" alt="Logo">
        </div>
        <ul>
            <li><a href="p_Gestioncatalogo.php">Catalogo</a></li>
            <li><a href="P_Producto.html">Añadir Producto</a></li>
            <li><a href="p_pedidos.php">Pedidos</a></li>
        </ul>
    </nav>


    <!-- Catálogo de productos -->
    <main>
        <h1>Gestion de pedidos</h1>
        <section class="Tabula">
            <div class="container">
                <div class="row header-row">
                    <div class="cell">ID</div>
                    <div class="cell">Estado</div>
                    <div class="cell">Fecha</div>
                    <div class="cell">Correo del Cliente</div>
                    <div class="cell">Revisión</div>
                </div>

                <?php
                    require '../Server/DB_Puerto.php';
                    $sql = "SELECT * FROM Pedido";
                    $stmt2 = $conn->query($sql);

                    if ($stmt2) {
                        $pedidos = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        echo "Error en la consulta.";
                        exit;
                    }
                ?>

                <?php if (!empty($pedidos)) : ?>
                    <?php foreach ($pedidos as $pedido) : ?>
                        <div class="row">
                            <?php
                                $idPedido = htmlspecialchars($pedido['id_pedido']);
                                $fkCliente = htmlspecialchars($pedido['fk_cliente']);
                                $estado = htmlspecialchars($pedido['estado']);
                                $fecha = htmlspecialchars($pedido['fecha']);
                            ?>
                            <input type="hidden" class="pedido-id" value="<?= $idPedido; ?>">
                            <div class="cell"><?= $idPedido; ?></div>
                            <div class="cell"><?= $estado; ?></div>
                            <div class="cell"><?= $fecha; ?></div>
                            <div class="cell"><?= $fkCliente; ?></div>
                            <div class="cell"><button class="ver-pedido">ver</button></div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="row">
                        <div class="cell" colspan="5">No se encontraron pedidos.</div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <div id="modal-pedido" class="modal">
        <div class="modal-content">
            
        </div>
    </div>
    
    <!-- Pie de página -->
    <footer id="contacto" class="footer">
    </footer>

    <div id="toast-notification" class="toast">
        <span class="toast-icon">ℹ️</span>
        <span class="toast-message"></span>
    </div> 

    <script src="../Scripts/scriptsIndex.js"></script>
    <script src="../Scripts/scriptsCatalogoEdit.js"></script>
    <script src="../Scripts/scriptPedido.js?v=2.0"></script>
</body>
</html>