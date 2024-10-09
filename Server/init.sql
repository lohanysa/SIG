CREATE DATABASE Mugumis;

USE Mugumis;

CREATE TABLE Inventario_de_amigurumis (
    id_amigurumis VARCHAR(6) PRIMARY KEY,
    nombre VARCHAR(25),
    descripcion VARCHAR(200),
    precio DECIMAL(10, 2),
    cantidad_disponible INT,
    direccion_url VARCHAR(255) NOT NULL,
    CONSTRAINT chk_url CHECK (direccion_url REGEXP '^(http|https)://')
);

CREATE TABLE Cliente (
    id_correo VARCHAR(50) PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    telefono VARCHAR(20),
    fk_amigurumis VARCHAR(50),
    FOREIGN KEY (fk_amigurumis) REFERENCES Inventario_de_amigurumis(id_amigurumis)
);

-- CREATE TABLE Inventario_materiales (
--     id_materiales VARCHAR(50) PRIMARY KEY,
--     descripcion VARCHAR(50),
--     cantidad INT,
--     proveedor VARCHAR(50)
-- );

CREATE TABLE Empleado (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo VARCHAR(50),
    fk_amigurumis VARCHAR(50),
    FOREIGN KEY (fk_amigurumis) REFERENCES Inventario_de_amigurumis(id_amigurumis)
    -- fk_materiales VARCHAR(50),
    -- FOREIGN KEY (fk_materiales) REFERENCES Inventario_materiales(id_materiales)
);

CREATE TABLE Pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    estado VARCHAR(20),
    fecha DATE,
    cantidad INT,
    metodo_pago VARCHAR(20),
    fk_empleado INT,
    fk_cliente VARCHAR(50),
    FOREIGN KEY (fk_empleado) REFERENCES Empleado(id_empleado),
    FOREIGN KEY (fk_cliente) REFERENCES Cliente(id_correo)
);


/*crear triger para la trba de pedidos
funcion: cada ves que se hace un insert en pedido reste la cantidad con la cantidad disponible
osea que disminuya lo que hay en stock



DELIMITER $$

CREATE TRIGGER actualizar_inventario
AFTER INSERT ON pedido
FOR EACH ROW
BEGIN
    DECLARE amigurumi_id INT;
    DECLARE cantidad_pedido INT;
    
    -- Obtener el id del amigurumi correspondiente
    SELECT fk_amigurumis INTO amigurumi_id
    FROM cliente
    WHERE id_correo = NEW.fk_cliente;
    
    SET cantidad_pedido = NEW.cantidad;

    -- Actualizar la cantidad disponible en el inventario
    UPDATE inventario_de_amigurumis
    SET cantidad_disponible = cantidad_disponible - cantidad_pedido
    WHERE id_amigurumis = amigurumi_id;
END$$

DELIMITER ;

*/