DROP database if EXISTS farmaciaOnline;
CREATE DATABASE farmaciaOnline;

USE farmaciaOnline;

CREATE TABLE tb_clientes (
id_cliente INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
nombre_cliente VARCHAR(50),
telefono_cliente VARCHAR(9) unique,
correo_cliente VARCHAR(100) unique,
dirección_cliente VARCHAR(250),
clave_cliente VARCHAR(64),
estado_cliente BOOLEAN DEFAULT(1)
);

CREATE TABLE tb_administradores(
id_admin INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
nombre_admin VARCHAR(50),
apellido_admin VARCHAR(50),
correo_admin VARCHAR(100) unique,
alias_admin VARCHAR(50) unique,
clave_admin  VARCHAR(64)
);



CREATE TABLE tb_categorias(
id_categoria INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
nombre_categoria VARCHAR(30) unique,
imagen_categoria varchar(25),
descripcion_categoria VARCHAR(200)
);

CREATE TABLE tb_opiniones(
id_opinion INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
comentario VARCHAR(250),
opinion int
); 

/*Categorias es para definir si son camisetas, medias, snekers, etc*/
CREATE TABLE tb_tipo_productos(
id_tipo_producto INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
tipo_producto VARCHAR(25) unique
);

CREATE TABLE tb_productos (
id_producto INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
nombre_producto VARCHAR(30),
descripcion VARCHAR(250),
imagen VARCHAR(30),
id_categoria INT,
id_tipo_producto INT,
CONSTRAINT FK_categoria_producto FOREIGN KEY (id_categoria) REFERENCES tb_categorias (id_categoria),
CONSTRAINT FK_tipoP_productos FOREIGN KEY (id_tipo_producto) REFERENCES tb_tipo_productos (id_tipo_producto)
);

SELECT * FROM tb_productos;


/* detalle productos lleva precio, stock y llave foranea de tallas*/
CREATE TABLE tb_detalle_productos(
id_detalle_producto INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
precio DECIMAL(5,2),
CONSTRAINT check_precio CHECK(precio > 0),
cantidad_disponible INT,
CONSTRAINT check_stock CHECK(cantidad_disponible >= 0),
id_producto INT,
CONSTRAINT FK_detalleP_producto
FOREIGN KEY(id_producto) 
REFERENCES tb_productos (id_producto)
);
     
CREATE TABLE tb_pedidos (
id_pedido INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
fecha_registro DATETIME NOT NULL DEFAULT current_timestamp(),
id_cliente INT,
estado_pedido ENUM ('Pendiente','Aceptado'),
CONSTRAINT FK_pedido_cliente
FOREIGN KEY(id_cliente)
REFERENCES tb_clientes (id_cliente)
);


SELECT * FROM tb_clientes;

CREATE TABLE tb_detalle_pedidos (
id_detalle INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
cantidad_pedido SMALLINT(6),
precio_pedido NUMERIC(5,2),
id_pedido INT,
CONSTRAINT FK_pedido_detalle_pedido
FOREIGN KEY(id_pedido)
REFERENCES tb_pedidos (id_pedido),
id_producto INT, 
CONSTRAINT FK_detalle_producto
FOREIGN KEY(id_producto)
REFERENCES tb_productos (id_producto)
);

CREATE TABLE tb_valoraciones(
id_valoracion INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
comentario VARCHAR(250),
valoracion INT,
id_detalle int,
CONSTRAINT FK_valoracion_productos
FOREIGN KEY(id_detalle)
REFERENCES tb_detalle_pedidos (id_detalle),
id_cliente INT,
CONSTRAINT FK_cliente_valoracion_producto
FOREIGN KEY(id_cliente)
REFERENCES tb_clientes (id_cliente),
estado_valoracion BOOLEAN DEFAULT(1)
);

SELECT * FROM tb_valoraciones;


/*APARTADO PARA HACER LAS CONSULTAS QUE SE VAN A USAR EN LAS GRAFICAS*/

/*SELECT PARA LA GRAFICA DE PRODUCTOS MEJORES VALORADOS*/     
SELECT nombre_producto, AVG(valoracion) Promedio 
FROM tb_valoraciones
INNER JOIN 	tb_detalle_pedidos USING (id_detalle)
INNER JOIN tb_productos USING(id_producto)
GROUP BY nombre_producto
ORDER BY promedio DESC LIMIT 5  

SELECT id_valoracion
        FROM tb_valoraciones 
        WHERE id_detalle = 1 AND id_cliente = 1
	             
DELIMITER //

CREATE PROCEDURE sp_actualizar_cantidad_producto(
    IN p_id_detalle INT,
    IN p_nueva_cantidad INT
)
BEGIN
    DECLARE v_cantidad_anterior INT;
    DECLARE v_id_producto INT;
    
    -- Obtener la cantidad anterior y el identificador del producto
    SELECT cantidad_pedido, id_producto
    INTO v_cantidad_anterior, v_id_producto
    FROM tb_detalle_pedidos
    WHERE id_detalle = p_id_detalle;
    
    -- Calcular la diferencia de cantidad
    SET @diferencia = p_nueva_cantidad - v_cantidad_anterior;
    
    -- Actualizar la cantidad disponible en tb_detalle_productos
    UPDATE tb_detalle_productos
    SET cantidad_disponible = cantidad_disponible - @diferencia
    WHERE id_producto = v_id_producto;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER trg_update_cantidad_pedido
BEFORE UPDATE ON tb_detalle_pedidos
FOR EACH ROW
BEGIN
    -- Llamar al procedimiento almacenado para actualizar la cantidad de productos
    CALL sp_actualizar_cantidad_producto(OLD.id_detalle, NEW.cantidad_pedido);
END //

DELIMITER ;	


