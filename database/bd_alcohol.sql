-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2024 a las 08:52:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `alcohol_quirquincho`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `aceptar_entrega` (IN `p_orden_id` INT)   BEGIN
    UPDATE hoja_carga 
    SET estado_hoja = 'Entregado'
    WHERE orden_id = p_orden_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `aceptar_orden` (IN `id_rec` INT)   BEGIN
    UPDATE orden 
    SET estado_pedido = 'Aceptado'
    WHERE id = id_rec;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_almacen` (IN `idIn` INT, IN `num` INT(50), IN `tipo` VARCHAR(50), IN `cap` VARCHAR(50), IN `prod` VARCHAR(50))   UPDATE almacen SET num_almacen=num, tipo_almacen=tipo, capacidad=cap, tipo_producto=prod WHERE id=idIN$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_estado_hoja` (IN `p_orden_id` INT)   BEGIN
    UPDATE hoja_carga_ordenes
    SET activa = 0
    WHERE hoja_id = p_orden_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_usuario` (IN `p_id` INT, IN `p_name` VARCHAR(255), IN `p_lastname` VARCHAR(255), IN `p_username` VARCHAR(255), IN `p_email` VARCHAR(255))   BEGIN
    UPDATE users
    SET name = p_name,
        lastname = p_lastname,
        username = p_username,
        email = p_email
    WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `almacen1` ()   BEGIN
SELECT DISTINCT
    a.num_almacen,
    concat(e.nombre,' ',e.apellido) AS nombre_empleado,
    i.producto AS producto,
    i.stock
FROM
    almacen a
    JOIN empleado e ON a.empleado_almacen_id = e.id
    JOIN item i ON i.almacen_id = a.id
WHERE
    a.id = 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `almacen2` ()   BEGIN
SELECT DISTINCT
    a.num_almacen,
    concat(e.nombre,' ',e.apellido) AS nombre_empleado,
    i.producto AS producto,
    i.stock
FROM
    almacen a
    JOIN empleado e ON a.empleado_almacen_id = e.id
    JOIN item i ON i.almacen_id = a.id
WHERE
    a.id = 2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `almacen3` ()   BEGIN
SELECT DISTINCT
    a.num_almacen,
    concat(e.nombre,' ',e.apellido) AS nombre_empleado,
    i.producto AS producto,
    i.stock
FROM
    almacen a
    JOIN empleado e ON a.empleado_almacen_id = e.id
    JOIN item i ON i.almacen_id = a.id
WHERE
    a.id = 3;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `almacen4` ()   BEGIN
SELECT DISTINCT
    a.num_almacen,
    concat(e.nombre,' ',e.apellido) AS nombre_empleado,
    i.producto AS producto,
    i.stock
FROM
    almacen a
    JOIN empleado e ON a.empleado_almacen_id = e.id
    JOIN item i ON i.almacen_id = a.id
WHERE
    a.id = 4;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `borrar_almacen` (IN `idIn` INT)   DELETE FROM almacen WHERE id=idIn$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `borrar_logico` (IN `idIn` INT)   UPDATE almacen SET activo=false WHERE id=idIN$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscar` (IN `p_id` INT)   SELECT * from users WHERE id =p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscar_cliente_hoja` (IN `p_cliente_h` VARCHAR(50))   BEGIN
    SELECT 
        o.cliente_id AS cliente_id, 
        hc.estado_hoja AS estado_hoja, 
        o.fecha_pedido AS fecha_pedido, 
        hco.orden_id, 
        hc.fecha_entrega
    FROM 
        hoja_carga_ordenes hco
    JOIN 
        orden o ON hco.orden_id = o.id
    JOIN 
        hoja_carga hc ON hco.hoja_id = hc.id
    WHERE 
        o.cliente_id = p_cliente_h;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscar_fecha` (IN `fecha` DATE)   SELECT orden_compra_id, fecha_orden,SUM(cantidad * precio_U) AS total_precio
FROM orden_item
where fecha_orden=fecha
GROUP BY orden_compra_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscar_fecha_hoja` (IN `fecha_busqueda` DATE)   BEGIN
    DECLARE ultima_fecha DATE;
    SELECT MAX(fecha_entrega) INTO ultima_fecha FROM hoja_carga;
    IF ultima_fecha IS NULL THEN
        SET ultima_fecha = CURDATE();
    END IF;
    SELECT 
        o.cliente_id AS cliente_id, 
		hc.estado_hoja AS estado_hoja, 
        o.fecha_pedido AS fecha_pedido, 
        hco.orden_id, 
        hc.fecha_entrega
    FROM 
        hoja_carga_ordenes hco
    JOIN 
        orden o ON hco.orden_id = o.id
    JOIN 
        hoja_carga hc ON hco.hoja_id = hc.id
    WHERE 
        DATE(hc.fecha_entrega) BETWEEN fecha_busqueda AND ultima_fecha;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscar_orden_hoja` (IN `p_orden_h` INT)   BEGIN
    SELECT 
        o.cliente_id AS cliente_id, 
        hc.estado_hoja AS estado_hoja, 
        o.fecha_pedido AS fecha_pedido, 
        hco.orden_id, 
        hc.fecha_entrega
    FROM 
        hoja_carga_ordenes hco
    JOIN 
        orden o ON hco.orden_id = o.id
    JOIN 
        hoja_carga hc ON hco.hoja_id = hc.id
    WHERE 
        hco.orden_id = p_orden_h;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscar_vista_fecha` (IN `fecha_busqueda` DATE)   BEGIN
    DECLARE ultima_fecha DATE;
    SELECT MAX(fecha_entrega) INTO ultima_fecha FROM hoja_carga;
    IF ultima_fecha IS NULL THEN
        SET ultima_fecha = CURDATE();
    END IF;

    -- Utilizar la vista pedidos_acep y filtrar por fecha_busqueda y ultima_fecha
    SELECT * FROM pedidos_acep
    WHERE fecha_conf BETWEEN fecha_busqueda AND ultima_fecha;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `crear_orden` (IN `fec` VARCHAR(50), IN `est` VARCHAR(10), IN `tip` CHAR(8), IN `eId` INT, IN `cId` INT)   insert into orden VALUES(null, fec, est, tip, eId, cId, null)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `datos_cliente` (IN `idIn` INT)   SELECT * from cliente where id = idIn$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `detalle_completo` (IN `id_compra` INT)   BEGIN
select oi.orden_compra_id,
     CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo,
     CONCAT(p.nombre, '  ', p.apellido) AS proveedor,
     oi.fecha_orden,
       oi.producto, 
       oi.cantidad, 
       oi.precio_U

from orden_item oi
join orden_compra oc on oc.id=oi.orden_compra_id
JOIN 
  empleado_almacen ea ON ea.id = oc.empleado_almacen_id
JOIN 
  empleado e ON e.id = ea.empleado_id
JOIN 
  proveedor p on p.id=oc.proveedor_id

where orden_compra_id=id_compra;
  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `editar` (IN `p_id` INT, IN `nom` VARCHAR(50), IN `ap` VARCHAR(50), IN `us` VARCHAR(50), IN `em` VARCHAR(50))   UPDATE users SET name = nom, lastname = lastnom, username = us, email=em 
where id= p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `edn_hca` ()   BEGIN
	select e.nombre AS nombre_edn,
    e.apellido as apellido_edn
    from
		empleado_distribucion edn
	join
		empleado e on edn.empleado_id = e.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar` (IN `idx` INT)   DELETE FROM users WHERE id=idx$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_1` (IN `id_pa` INT)   BEGIN
    DECLARE last_inserted_confirmar_id INT;

    -- Actualizar el campo hoja_carga_id a NULL en la tabla orden
    UPDATE orden SET hoja_carga_id = NULL WHERE hoja_carga_id = id_pa;

    -- Actualizar el campo activa a 0 en la tabla confirmar para las órdenes asociadas a la hoja_carga con id igual a id_pa
    UPDATE confirmar SET activa = 0 WHERE orden_id IN (SELECT id FROM orden WHERE hoja_carga_id = id_pa);

    -- Eliminar las entradas de la tabla hoja_carga_ordenes que hacen referencia a la hoja_carga con id igual a id_pa
    DELETE FROM hoja_carga_ordenes WHERE hoja_id = id_pa;

    -- Eliminar la entrada de la tabla hoja_carga
    DELETE FROM hoja_carga WHERE id = id_pa;

    -- Obtener el último id insertado en la tabla confirmar
    SELECT MAX(id) INTO last_inserted_confirmar_id FROM confirmar;

    -- Eliminar el último registro insertado en la tabla confirmar
    DELETE FROM confirmar WHERE id = last_inserted_confirmar_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_2` (IN `id_pa` INT)   BEGIN
    -- Eliminar la entrada de la tabla hoja_carga
    DELETE FROM ordenes_por_hoja_carga
    WHERE orden_id = id_pa;

    -- Actualizar el campo activa a 0 en la tabla confirmar
    UPDATE confirmar
    SET activa = 0
    WHERE orden_id = id_pa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_orden` (IN `idx` INT)   BEGIN
    -- Eliminar registros dependientes en `orden_item`
    DELETE FROM orden_item WHERE orden_compra_id = idx;

    -- Luego eliminar el registro en `orden_compra`
    DELETE FROM orden_compra WHERE id = idx;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_usuario` (IN `idIn` INT)   update users set borrado = 1 where id = idIn$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empleado_mas_generado_por_fecha` (IN `fecha_esp` DATE)   select * from empleado_mas_generado where fecha = fecha_esp$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empleado_mas_generado_por_id` (IN `idIn` INT)   SELECT id, nombre, sum(Total_Generado) as Total_Generado from empleado_mas_generado where id = idIN$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empleado_mayores_ventas_fecha` (IN `fecha_esp` VARCHAR(10))   select * from empleado_mas_ventas_fecha where fecha = fecha_esp$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `empleado_mayores_ventas_id` (IN `idIn` INT)   select id, nombre, sum(Total) as Total from empleado_mas_ventas_fecha where id = idIn$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_ci` (IN `username` VARCHAR(50))   select ci from regist where user = username$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hoja_carga_num` ()   BEGIN
-- mostrar siguiente id de hoja carga--
	SELECT IFNULL(MAX(id), 0) + 1 AS sig_id FROM hoja_carga;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar` (IN `num_alm` INT, IN `tip_alm` VARCHAR(50), IN `cap` VARCHAR(50), IN `tip_prod` VARCHAR(50))   INSERT INTO almacen
    VALUES (null, num_alm, tip_alm, cap, tip_prod, true)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_almacen` (IN `idIn` INT, IN `numero` INT, IN `tipo` VARCHAR(50), IN `capacidad` VARCHAR(50), IN `prod` VARCHAR(50))   insert into almacen values(idIn, numero, tipo, capacidad, prod, true)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_cliente` (IN `car` INT, IN `nom` VARCHAR(50), IN `ape` VARCHAR(50), IN `dir` VARCHAR(255), IN `tel` INT, IN `eId` INT)   insert into cliente values(null, car, nom, ape, dir, tel, 0, eId)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_datos_hca` ()   BEGIN
	SELECT
    hc.orden_id, 
    hc.fecha_entrega,
    e.nombre AS nombre_empleado_distribucion,
    e.apellido AS apellido_empleado_distribucion
FROM 
    hoja_carga hc
JOIN 
    orden o ON hc.orden_id = o.id
JOIN 
    empleado_ventas ev ON o.empleado_ventas_id = ev.id
JOIN 
    empleado e ON hc.empleado_distribucion_id = e.id;
 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_empleado` (IN `car` INT, IN `nom` VARCHAR(50), IN `ape` VARCHAR(50), IN `tel` INT, IN `sal` INT)   insert into empleado values(null, car, nom, ape, tel, '08:30:00', sal, 0)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_empleado_ventas` (IN `emp_id` INT)   insert into empleado_ventas values(null, 500, 0, emp_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_orden_compra` (IN `emp_id` INT, IN `prov_id` INT, IN `f_orden` DATE, IN `plaz` DATE, IN `pago` CHAR(8), IN `cant` DECIMAL(10,2))   insert into orden_compra values(null, emp_id, prov_id, f_orden, plaz, pago, cant)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_orden_item` (IN `emp_id` INT, IN `prov_id` INT, IN `f_orden` DATE, IN `plaz` DATE, IN `pag` VARCHAR(10), IN `cant` INT, IN `p_prod` VARCHAR(50), IN `p_id` INT, IN `p_precio` INT, IN `o_compra_id` INT)   BEGIN
    DECLARE orden_c_id INT; -- Declarar la variable para almacenar la ID de la orden de compra

    -- Verificar si el orden_compra_id es proporcionado
    IF o_compra_id IS NULL THEN
        INSERT INTO orden_compra (empleado_almacen_id, proveedor_id, fecha_orden, plazo, pago, cantidad)
        VALUES (emp_id, prov_id, f_orden, plaz, pag, cant);
        -- Obtener la ID de la orden de compra generada automáticamente
        SET orden_c_id = LAST_INSERT_ID();
    ELSE
        -- Usar el orden_compra_id proporcionado
        SET orden_c_id = o_compra_id;
    END IF;
    -- Insertar en orden_item
    INSERT INTO orden_item (item_id, orden_compra_id, producto, cantidad, precio_U, fecha_orden)
    VALUES (p_id, orden_c_id, p_prod, cant, p_precio, f_orden);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_orden_producto` (IN `precioT` DECIMAL, IN `cant` INT, IN `idAdm` INT, IN `idProd` INT)   insert into orden_producto values(null, precioT, cant, idAdm, idProd)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user` (IN `p_name` VARCHAR(50), IN `p_lastname` VARCHAR(50), IN `p_username` VARCHAR(50), IN `p_email` VARCHAR(50), IN `p_telefono` VARCHAR(20), IN `p_employee_number` VARCHAR(20), IN `p_hire_date` DATE, IN `p_type` INT, IN `p_password` VARCHAR(255))   BEGIN
    INSERT INTO users (name, lastname, username, email, telefono, employee_number, hire_date, type, password)
    VALUES (p_name, p_lastname, p_username, p_email, p_telefono, p_employee_number, p_hire_date, p_type, p_password);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_emps` ()   SELECT * FROM vista_users_roles$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_datos_hca` ()   BEGIN
    -- Mostrar los datos donde estado_confi es 1
    SELECT 
        c.orden_id
    FROM
        confirmar c
	JOIN
        orden o ON c.orden_id = o.id
    WHERE
        c.orden_id IS NOT NULL
        AND c.estado_confi = 1
        AND c.activa = 0
        AND o.hoja_carga_id IS NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_ordenes_espera` ()   BEGIN
    Select id
    from orden
    Where estado_pedido = 'Espera';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_cliente` (IN `carnet` INT)   SELECT * from cliente WHERE ci = carnet$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_datos_iniciales` ()   BEGIN
    -- Variable para almacenar la siguiente ID de hoja de carga
    DECLARE sig_id INT;
    
    -- Obtener la siguiente ID de hoja de carga
    SELECT IFNULL(MAX(id), 0) + 1 INTO sig_id FROM hoja_carga;
    
    -- Enviar el resultado de la siguiente ID de hoja de carga
    SELECT sig_id AS sig_id, CURDATE() AS fecha_actual;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_datos_join_regist` ()   SELECT * FROM join_regist$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_id_orden_compra` ()   select id from orden_compra order by id desc limit 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_producto` (IN `p_prod` VARCHAR(50))   select id, precio from item  where id = p_prod$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `papelera` (IN `idx` INT)   UPDATE almacen SET activo = false
where id= idx$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `productos_mas_vendidos` ()   select * from  productos_mas_ventas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `productos_que_mas_generan` ()   SELECT * from producto_mas_genera$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p_mas_pedidos` ()   BEGIN
   select * from productos_mas_comprados;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p_mas_prov1` ()   BEGIN
select* from cantidad_mayor1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p_mas_prov2` ()   BEGIN
select* from cantidad_mayor2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p_mas_prov3` ()   BEGIN
select* from cantidad_mayor3;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p_mas_prov4` ()   BEGIN
select* from cantidad_mayor4;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p_mas_prov5` ()   BEGIN
select* from cantidad_mayor5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `rechazar_orden` (IN `id_rec` INT)   BEGIN
    UPDATE orden 
    SET estado_pedido = 'Rechazado'
    WHERE id = id_rec;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registro_alc` (IN `em` VARCHAR(50), IN `us` VARCHAR(50), IN `pass` VARCHAR(50), IN `carnet` INT)   INSERT INTO regist VALUES (NULL, em, us, pass, carnet)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `restaurar` (IN `idIn` INT)   UPDATE almacen SET activo=true WHERE id=idIN$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `suma_cant` (IN `p_orden_id` INT)   BEGIN
	select op.cantidad, concat(p.envase, ' ', p.capacidad) as nombre, p.precio, (op.cantidad * p.precio) AS total
    from orden_producto op
    join producto p on op.producto_id = p.id
    WHERE op.orden_id = p_orden_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `un_almacen` (IN `idIn` INT)   SELECT * from almacen where id = idIn$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ventas_del_empleado_id` (IN `idIn` INT)   select * from ventas_del_empleado where empleado_id = idIn$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_almacenes` ()   select * from almacen where activo = true$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_almacenes_restaurar` ()   select * from almacen where activo = false$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_almacen_general` ()   BEGIN
    SELECT a.empleado_almacen_id AS empleado, 
           CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo,
           a.num_almacen,
           a.tipo_almacen AS almacen
    FROM almacen a
    JOIN empleado_almacen ea 
      ON ea.id = a.empleado_almacen_id
    JOIN empleado e 
      ON e.id = ea.empleado_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_clientes` ()   SELECT * from cliente$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_clientes_compra_productos` ()   SELECT Id_Cliente, Nombre_Cliente, Id_Producto, Producto, Cantidad from productos_mas_comprados_por_cliente group by Id_Cliente, Id_Producto$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_clientes_compra_producto_Id_Cliente` (IN `idIn` INT)   SELECT Id_Cliente, Nombre_Cliente, Id_Producto, Producto, Cantidad 
from productos_mas_comprados_por_cliente
where Id_Cliente = idIn
group by Id_Cliente, Id_Producto$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_clientes_compra_producto_Id_Producto` (IN `idIn` INT)   SELECT Id_Cliente, Nombre_Cliente, Id_Producto, Producto, Cantidad 
from productos_mas_comprados_por_cliente
where Id_Producto = idIn
group by Id_Cliente, Id_Producto$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_cliente_compra_producto_fecha` (IN `fecha_esp` TEXT)   SELECT Id_Cliente, Nombre_Cliente, Id_Producto, Producto, Cantidad 
from productos_mas_comprados_por_cliente
where Fecha >= fecha_esp
group by Id_Cliente, Id_Producto$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_compras` ()   SELECT * from orden$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_detalle` ()   BEGIN
SELECT orden_compra_id, fecha_orden,SUM(cantidad * precio_U) AS total_precio
FROM orden_item
GROUP BY orden_compra_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_edn_hca` ()   BEGIN
	select hc.empleado_distribucion_id, 
    edn.placa AS placa_vehiculo,
    hc.fecha_entrega
    from
		hoja_carga hc
	join
		empleado_distribucion edn on hc.empleado_distribucion_id = edn.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_hoja` (IN `hoja_carga_id_param` INT)   BEGIN
    SELECT 
        o.id AS orden_id,
        o.cliente_id AS cliente_id,
        o.hoja_carga_id AS hoja_carga_id,
        hc.estado_hoja,
        o.fecha_pedido AS fecha_pedido,
        hc.fecha_entrega
    FROM 
        orden o
    JOIN 
        hoja_carga_ordenes hco ON o.id = hco.orden_id
    JOIN 
        hoja_carga hc ON hc.id = hco.hoja_id
    WHERE 
        hc.estado_hoja = 'Pendiente' AND hc.id = hoja_carga_id_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_hoja_entregado` ()   BEGIN
    SELECT 
        o.id AS orden_id,
        o.cliente_id AS cliente_id,
        hc.id AS hoja_carga_id,
        hc.estado_hoja,
        o.fecha_pedido AS fecha_pedido,
        hc.fecha_entrega
    FROM 
        orden o
    JOIN 
        hoja_carga_ordenes hco ON o.id = hco.orden_id
    JOIN 
        hoja_carga hc ON hc.id = hco.hoja_id
    WHERE 
        hc.estado_hoja = 'Entregado';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_hoja_pedidos` ()   BEGIN
    SELECT 
        hc.id AS hoja_id,
        GROUP_CONCAT(hco.orden_id) AS ordenes,
        hc.fecha_entrega,
        e.nombre AS nombre_empleado,
        e.apellido AS apellido_empleado
    FROM 
        hoja_carga hc
    JOIN 
        hoja_carga_ordenes hco ON hc.id = hco.hoja_id
                              AND hco.activa = 1  -- Agregar condición activa = 1
    JOIN 
        empleado_distribucion ed ON hc.empleado_distribucion_id = ed.id
    JOIN 
        empleado e ON ed.empleado_id = e.id
    WHERE 
        hc.estado_hoja = 'Pendiente'
    GROUP BY 
        hc.id, hc.fecha_entrega, e.nombre, e.apellido; -- Agrupar por hoja_id, fecha_entrega, nombre y apellido
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_info_hca` (IN `p_orden_id` INT)   BEGIN
    SELECT 
        hc.id,
        o.fecha_pedido AS fecha_pedido, 
        o.id as orden_id,
        c.nombre AS nombre_cliente, 
        c.apellido AS apellido_cliente, 
        c.direccion AS direccion_cliente,
        e.nombre AS nombre_empleado,
        e.apellido AS apellido_empleado,
        ed.placa AS placa_vehiculo
    FROM 
        hoja_carga hc
    JOIN 
        hoja_carga_ordenes hco ON hc.id = hco.hoja_id
    JOIN 
        orden o ON hco.orden_id = o.id
    JOIN 
        empleado_distribucion ed ON hc.empleado_distribucion_id = ed.id
    JOIN 
        cliente c ON o.cliente_id = c.id
    JOIN 
        empleado e ON ed.empleado_id = e.id
    WHERE 
        o.id = p_orden_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_mas_compras_realizadas` ()   select id, nombre, sum(Total) as Total from empleado_mas_ventas_fecha group by id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_mas_generado` ()   SELECT id, nombre, sum(Total_Generado) as Total_Generado from empleado_mas_generado group by id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_producto` (IN `idIn` INT)   SELECT * from producto where id = idIn$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_productos` ()   select * from producto$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_productos_proveedor_empleado` ()   BEGIN
  -- para abstraer los nombres y apellido de los empleados
  SELECT ea.id, CONCAT(ea.id,' - ', e.nombre, ' ',e.apellido ) as empleado from empleado_almacen ea
    JOIN empleado e on e.id=ea.empleado_id;
    
  -- para los prodcutos abstraidos de la tabla item 
  SELECT   id, CONCAT(id,'  -  ',producto, ' - ', precio, 'bs.') AS producto_precio FROM item;
    
  -- para los prodcutos abstraidos de la tabla item nombres y apellido de los proveedores 
  SELECT id, CONCAT(id,' -  ',nombre, '  ', apellido) AS proveedor FROM proveedor;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ver_producto_mas_genero_desde` (IN `fecha_min` DATE)   select `a`.`producto_id` AS `id`,concat(`b`.`envase`,' ',`b`.`capacidad`) AS `producto`,sum(`a`.`precio`) AS `total_generado` from (`modificado_alcohol`.`orden_producto` `a` join `modificado_alcohol`.`producto` `b` on(`a`.`producto_id` = `b`.`id`)) join orden c on (a.orden_id = c.id) where c.fecha_pedido >= fecha_min group by `a`.`producto_id` order by c.id, `a`.`producto_id` desc$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_acep` ()   BEGIN
	select * from pedidos_acep;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_almacen` ()   SELECT * FROM view_almacen$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_empleados_almacen` ()   SELECT * FROM view_emp_almacen$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_emps` ()   SELECT * FROM view_emps$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_entrega` ()   BEGIN
	select * from empleados_con_mas_ent_comp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_join_regist` ()   BEGIN
    SELECT * FROM regist_users;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_orden` ()   SELECT * FROM view_orden$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_pendiente` ()   BEGIN
	select * from empleados_con_mas_pen;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_rech` ()   BEGIN
	select * from pedidos_rech;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_resumen` ()   BEGIN
	select * from resumen_entregas;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_usuarios` ()   SELECT * FROM view_usuarios$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calcular_precio` (`idIn` INT, `cant` INT) RETURNS INT(1)  BEGIN
declare precioT int;
select precio * cant into precioT from producto where id = idIn;
return precioT;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `calcular_total_orden` (`p_orden_id` INT) RETURNS DECIMAL(10,2) DETERMINISTIC READS SQL DATA BEGIN
    DECLARE total DECIMAL(10, 2);
    
    SELECT SUM(op.cantidad * p.precio) INTO total
    FROM orden_producto op
    JOIN producto p ON op.producto_id = p.id
    WHERE op.orden_id = p_orden_id;
    
    RETURN IFNULL(total, 0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_client_id` (`carnet` INT) RETURNS INT(11)  BEGIN
declare idClient int;
select id into idClient from cliente where ci = carnet;
return idClient;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_emp_id` (`carnet` INT) RETURNS INT(11)  BEGIN
declare idEmpleado int;
select id into idEmpleado from empleado where ci = carnet;
return idEmpleado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_emp_ventas_id` (`id_emp` INT) RETURNS INT(11)  BEGIN
declare idEmpleado int;
select id into idEmpleado from empleado_ventas where empleado_id = id_emp;
return idEmpleado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_image` (`prod_id` INT) RETURNS TEXT CHARSET utf8 COLLATE utf8_general_ci  BEGIN
declare rutaImg text;
select ruta into rutaImg from imagen where id_producto = prod_id; 
return rutaImg;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `nombre_empleado` (`idIn` INT) RETURNS VARCHAR(50) CHARSET utf8 COLLATE utf8_general_ci  BEGIN
declare nom varchar(50);
select concat(b.nombre, ' ', b.apellido) into nom from empleado_ventas a 
join empleado b on a.empleado_id = b.id WHERE a.id = idIn; 
return nom;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_pedidos_aceptados` () RETURNS INT(11) DETERMINISTIC BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM pedidos_acep;
    RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_pedidos_rechazados` () RETURNS INT(11) DETERMINISTIC BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM pedidos_rech;
    RETURN total;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ultima_orden` () RETURNS INT(11)  BEGIN
declare id_actual int;
select id into id_actual from orden order by id desc limit 1; 
return id_actual;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ultimo_empleado` () RETURNS INT(11)  BEGIN
declare idEmpleado int;
select id into idEmpleado from empleado order by id desc limit 1;
return idEmpleado;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id` int(11) NOT NULL,
  `empleado_almacen_id` int(11) NOT NULL,
  `num_almacen` int(11) NOT NULL,
  `tipo_almacen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id`, `empleado_almacen_id`, `num_almacen`, `tipo_almacen`) VALUES
(1, 1, 110, 'Productos'),
(2, 4, 2, 'Termocontraibles'),
(3, 2, 3, 'Botellas para Alcohol'),
(4, 1, 4, 'Latas para Alcohol'),
(5, 3, 1, 'Tanques 1000L de Alcohol');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidad_mayor1`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cantidad_mayor1` (
`fecha_orden` date
,`nombre_proveedor` varchar(20)
,`producto` varchar(45)
,`cantidad_total` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidad_mayor2`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cantidad_mayor2` (
`fecha_orden` date
,`nombre_proveedor` varchar(20)
,`producto` varchar(45)
,`cantidad_total` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidad_mayor3`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cantidad_mayor3` (
`fecha_orden` date
,`nombre_proveedor` varchar(20)
,`producto` varchar(45)
,`cantidad_total` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidad_mayor4`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cantidad_mayor4` (
`fecha_orden` date
,`nombre_proveedor` varchar(20)
,`producto` varchar(45)
,`cantidad_total` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cantidad_mayor5`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cantidad_mayor5` (
`fecha_orden` date
,`nombre_proveedor` varchar(20)
,`producto` varchar(45)
,`cantidad_total` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `ci` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `borrado` tinyint(4) NOT NULL DEFAULT 0,
  `empleado_ventas_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `ci`, `nombre`, `apellido`, `direccion`, `telefono`, `borrado`, `empleado_ventas_id`) VALUES
(2, 14704649, 'Jorge', 'Medrano', 'Asucion127', 78789618, 0, 1),
(29, 14501236, 'ElBando32', 'Medrano', 'Asucion127', 78789618, 0, 0),
(53, 3452994, 'Jorge', 'Perez', 'Av. Argentina', 78785963, 0, 0),
(54, 3698110, 'Juan', 'Perez', 'Achumani', 78783256, 0, 1),
(55, 3451002, 'Felipe', 'Machicado', 'Achumani', 77503624, 0, 2),
(56, 87978, 'Cristhian', 'aa', 'asdas', 76713767, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `confirmar`
--

CREATE TABLE `confirmar` (
  `id` int(11) NOT NULL,
  `estado_confi` tinyint(4) NOT NULL DEFAULT 0,
  `fecha` date NOT NULL,
  `orden_id` int(11) NOT NULL,
  `activa` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `confirmar`
--

INSERT INTO `confirmar` (`id`, `estado_confi`, `fecha`, `orden_id`, `activa`) VALUES
(1, 1, '2024-06-15', 2, 1),
(2, 1, '2024-06-15', 3, 1),
(3, 1, '2024-06-15', 2, 0),
(4, 1, '2024-06-15', 3, 0),
(5, 0, '2024-06-15', 1, 0),
(6, 0, '2024-06-15', 2, 0),
(7, 0, '2024-06-15', 2, 0),
(8, 0, '2024-06-15', 3, 0),
(9, 1, '2024-06-15', 4, 1),
(10, 1, '2024-06-15', 5, 1),
(11, 1, '2024-06-15', 4, 0),
(12, 1, '2024-06-15', 5, 0),
(15, 0, '2024-06-17', 17, 0),
(16, 0, '2024-06-17', 18, 0),
(17, 0, '2024-06-17', 19, 0),
(18, 0, '2024-06-17', 20, 0),
(19, 1, '2024-06-17', 6, 1),
(20, 1, '2024-06-17', 7, 1),
(21, 1, '2024-06-17', 8, 1),
(22, 1, '2024-06-17', 6, 0),
(23, 1, '2024-06-17', 7, 0),
(24, 1, '2024-06-17', 9, 1),
(25, 1, '2024-06-17', 8, 0),
(26, 1, '2024-06-17', 9, 0),
(27, 1, '2024-06-17', 10, 1),
(28, 1, '2024-06-17', 11, 1),
(29, 1, '2024-06-17', 10, 0),
(30, 1, '2024-06-17', 11, 0),
(31, 1, '2024-06-17', 8, 0),
(33, 0, '2024-06-17', 12, 0),
(34, 0, '2024-06-17', 21, 0),
(35, 0, '2024-06-17', 22, 0),
(36, 0, '2024-06-19', 23, 0),
(37, 0, '2024-06-19', 24, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `ci` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` int(11) NOT NULL,
  `hora_entrada` time NOT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `borrado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `ci`, `nombre`, `apellido`, `telefono`, `hora_entrada`, `salario`, `borrado`) VALUES
(0, 0, 'Pagina_Web', '', 0, '00:00:00', NULL, 0),
(1, 17705122, 'Juan', 'Perez', 77589630, '08:30:00', 7500.00, 0),
(2, 3452987, 'Jose', 'Mamani', 78781420, '09:00:00', 12500.00, 0),
(3, 1234567, 'Juan', 'Pérez', 77789456, '08:00:00', 1500.50, 0),
(4, 14702529, 'Esteban', 'Medrano', 78789618, '09:00:00', 15000.00, 0),
(5, 9876543, 'María', 'Gómez', 69674896, '09:00:00', 1800.75, 0),
(6, 9699445, 'María', 'Delgado', 74789660, '07:45:00', 2000.15, 0),
(7, 11694788, 'Josue', 'Murillo', 74499663, '08:15:00', 1500.35, 0),
(8, 1478896, 'Oscar', 'Loza', 63214778, '08:40:00', 2500.00, 0),
(9, 1469873, 'Luciana', 'Peredo', 74178532, '09:15:00', 1800.50, 0),
(10, 945112, 'Ana', 'Martínez', 66621004, '07:45:00', 1700.25, 0),
(11, 991445, 'Pedro', 'Rojas', 70012120, '08:30:00', 1600.75, 0),
(12, 1014479, 'Carlos', 'Rodríguez', 66978412, '09:00:00', 1900.00, 0),
(14, 3250669, 'Sebastian', 'Fernandez', 77785123, '08:30:00', 7500.00, 0),
(21, 14203312, 'Esteban', 'Medrano', 78789618, '08:30:00', 9500.00, 0),
(22, 2455893, 'Marco', 'Flores', 77503621, '08:30:00', 9500.00, 0),
(23, 11223344, 'Carlos', 'Garcia', 987654323, '07:30:00', 2450.75, 0),
(24, 44332211, 'Ana', 'Martinez', 987654324, '08:30:00', 2600.00, 0),
(25, 55667788, 'Luis', 'Rodriguez', 987654325, '09:15:00', 2550.20, 0),
(26, 66778899, 'Lucia', 'Fernandez', 987654328, '08:15:00', 2400.60, 0),
(27, 35256970, 'Maria', 'Rivera', 78789618, '08:30:00', 7500.00, 0),
(28, 991212, 'Cristhian', 'Aguilar', 76713767, '08:30:00', 8900.00, 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `empleados_con_mas_ent_comp`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `empleados_con_mas_ent_comp` (
`empleado_id` int(11)
,`nombre` varchar(30)
,`apellido` varchar(45)
,`total_entregas` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `empleados_con_mas_pen`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `empleados_con_mas_pen` (
`empleado_id` int(11)
,`nombre` varchar(30)
,`apellido` varchar(45)
,`total_entregas` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_almacen`
--

CREATE TABLE `empleado_almacen` (
  `id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `puesto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empleado_almacen`
--

INSERT INTO `empleado_almacen` (`id`, `empleado_id`, `puesto`) VALUES
(1, 1, 'Gestion'),
(2, 23, 'Supervisador'),
(3, 24, 'Supervisador'),
(4, 25, 'Supervisador'),
(5, 26, 'Supervisador'),
(6, 26, 'Supervisador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_distribucion`
--

CREATE TABLE `empleado_distribucion` (
  `id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `vehiculo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empleado_distribucion`
--

INSERT INTO `empleado_distribucion` (`id`, `empleado_id`, `placa`, `vehiculo`) VALUES
(1, 5, 'ABC123', 'Toyota Corolla'),
(2, 8, 'MNO345', 'Nissan'),
(3, 10, 'JKL012', 'Chevrolet'),
(5, 9, 'GHI789', 'Ford');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `empleado_mas_generado`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `empleado_mas_generado` (
`fecha` date
,`id` int(11)
,`nombre` varchar(30)
,`Total_Generado` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `empleado_mas_ventas_fecha`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `empleado_mas_ventas_fecha` (
`fecha` date
,`id` int(11)
,`nombre` varchar(30)
,`Total` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_ventas`
--

CREATE TABLE `empleado_ventas` (
  `id` int(11) NOT NULL,
  `bono` decimal(10,2) NOT NULL,
  `borrado` tinyint(4) NOT NULL DEFAULT 0,
  `empleado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empleado_ventas`
--

INSERT INTO `empleado_ventas` (`id`, `bono`, `borrado`, `empleado_id`) VALUES
(0, 0.00, 0, 0),
(1, 500.00, 0, 2),
(2, 1200.00, 0, 4),
(22, 500.00, 0, 21),
(23, 500.00, 0, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hoja_carga`
--

CREATE TABLE `hoja_carga` (
  `id` int(11) NOT NULL,
  `empleado_distribucion_id` int(11) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `estado_hoja` varchar(50) DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `hoja_carga`
--

INSERT INTO `hoja_carga` (`id`, `empleado_distribucion_id`, `fecha_entrega`, `estado_hoja`) VALUES
(1, 1, '2024-06-22', 'Entregado'),
(2, 1, '2024-06-16', 'Entregado'),
(3, 2, '2024-06-21', 'Pendiente'),
(4, 1, '2024-06-24', 'Pendiente'),
(6, 5, '2024-07-05', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hoja_carga_ordenes`
--

CREATE TABLE `hoja_carga_ordenes` (
  `id` int(11) NOT NULL,
  `hoja_id` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `activa` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `hoja_carga_ordenes`
--

INSERT INTO `hoja_carga_ordenes` (`id`, `hoja_id`, `orden_id`, `activa`) VALUES
(1, 1, 2, 0),
(2, 2, 3, 0),
(3, 3, 4, 0),
(4, 3, 5, 0),
(5, 4, 6, 0),
(6, 4, 7, 0),
(9, 6, 10, 1),
(10, 6, 11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `id` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`id`, `ruta`, `id_producto`) VALUES
(1, 'https://pp.centramerica.com/pp/imgs/prodlarge/49839.png', 1),
(2, 'data:image/jpeg;base64,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', 2),
(3, 'data:image/jpeg;base64,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', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `producto` varchar(45) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `almacen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`id`, `producto`, `stock`, `precio`, `almacen_id`) VALUES
(1, 'tanques 1000L', 20, 300.00, 5),
(2, 'termocontraibles', 140, 30.00, 2),
(3, 'Botellas de 200 ml', 30, 9.00, 3),
(4, 'Botellas de 400 ml', 135, 7.00, 3),
(5, 'Botellas de 900 ml', 225, 10.00, 3),
(6, 'Botellas de 500 ml', 125, 9.00, 3),
(7, 'Botellas de 300 ml', 15, 6.00, 3),
(8, 'Latas de 1L', 15, 12.00, 4),
(9, 'Latas de 4L', 20, 20.00, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `join_regist`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `join_regist` (
`regist_id` int(11)
,`regist_user` varchar(50)
,`regist_password` varchar(50)
,`users_id` int(11)
,`users_username` varchar(50)
,`users_password` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id` int(11) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `estado_pedido` varchar(10) NOT NULL,
  `tipo_pago` char(8) NOT NULL,
  `empleado_ventas_id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `hoja_carga_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`id`, `fecha_pedido`, `estado_pedido`, `tipo_pago`, `empleado_ventas_id`, `cliente_id`, `hoja_carga_id`) VALUES
(1, '2024-06-04', 'Entregado', 'tarjeta', 1, 2, NULL),
(2, '2024-06-07', 'Entregado', 'tarjeta', 0, 2, 1),
(3, '2024-06-07', 'Entregado', 'efectivo', 0, 2, 2),
(4, '2024-06-07', 'Aceptado', 'efectivo', 0, 2, 3),
(5, '2024-06-07', 'Aceptado', 'efectivo', 0, 2, 3),
(6, '2024-06-07', 'Aceptado', 'efectivo', 0, 2, 4),
(7, '2024-06-07', 'Aceptado', 'efectivo', 0, 2, 4),
(8, '2024-06-07', 'Aceptado', 'efectivo', 0, 53, NULL),
(9, '2024-06-07', 'Aceptado', 'efectivo', 1, 2, NULL),
(10, '2024-06-14', 'Aceptado', 'tarjeta', 1, 54, 6),
(11, '2024-06-14', 'Aceptado', 'tarjeta', 1, 2, 6),
(12, '2024-06-14', 'Rechazado', 'efectivo', 1, 2, NULL),
(13, '2024-06-14', 'Espera', 'efectivo', 1, 2, NULL),
(14, '2024-06-14', 'Espera', 'tarjeta', 2, 2, NULL),
(15, '2024-06-14', 'Espera', 'efectivo', 0, 54, NULL),
(16, '2024-06-14', 'Espera', 'efectivo', 0, 54, NULL),
(17, '2024-06-17', 'Espera', 'efectivo', 2, 55, NULL),
(18, '2024-06-17', 'Espera', 'efectivo', 2, 2, NULL),
(19, '2024-06-17', 'Espera', 'tarjeta', 0, 55, NULL),
(20, '2024-06-17', 'Espera', 'tarjeta', 22, 2, NULL),
(21, '2024-06-17', 'Espera', 'efectivo', 2, 2, NULL),
(22, '2024-06-17', 'Espera', 'tarjeta', 0, 54, NULL),
(23, '2024-06-19', 'Espera', 'tarjeta', 2, 2, NULL),
(24, '2024-06-19', 'Espera', 'efectivo', 0, 53, NULL);

--
-- Disparadores `orden`
--
DELIMITER $$
CREATE TRIGGER `confirmar_orden` AFTER UPDATE ON `orden` FOR EACH ROW BEGIN
	DECLARE est INT;
    
    IF NEW.estado_pedido = 'Aceptado' THEN
        SET est = 1;
    ELSE
        SET est = 0;
    END IF;
    INSERT INTO confirmar (id,estado_confi,fecha,orden_id)
    VALUES (NULL, est, NOW(), new.id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertar_fecha` AFTER INSERT ON `orden` FOR EACH ROW BEGIN 
	DECLARE est INT;
    SET est = 0;
    INSERT INTO confirmar (estado_confi, orden_id, fecha)
    VALUES (est, new.id, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_por_hoja_carga`
--

CREATE TABLE `ordenes_por_hoja_carga` (
  `id` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `activa` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ordenes_por_hoja_carga`
--

INSERT INTO `ordenes_por_hoja_carga` (`id`, `orden_id`, `activa`) VALUES
(1, 2, 0),
(2, 3, 0),
(3, 4, 0),
(4, 5, 0),
(5, 6, 0),
(6, 7, 0),
(7, 8, 0),
(8, 9, 0),
(9, 10, 0),
(10, 11, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE `orden_compra` (
  `id` int(11) NOT NULL,
  `empleado_almacen_id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `fecha_orden` date NOT NULL,
  `plazo` date NOT NULL,
  `pago` char(8) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `orden_compra`
--

INSERT INTO `orden_compra` (`id`, `empleado_almacen_id`, `proveedor_id`, `fecha_orden`, `plazo`, `pago`, `cantidad`) VALUES
(1, 1, 1, '2024-06-17', '2024-06-20', 'tarjeta', 200),
(2, 2, 2, '2024-06-17', '2024-06-20', 'tarjeta', 100),
(3, 1, 2, '2024-06-17', '2024-06-20', 'Tarjeta', 400),
(4, 5, 5, '2024-06-17', '2024-06-20', 'transfer', 10),
(5, 2, 1, '2024-06-17', '2024-06-20', 'Tarjeta', 100),
(6, 1, 5, '2024-06-17', '2024-06-20', 'Tarjeta', 100),
(7, 4, 4, '2024-06-19', '2024-06-22', 'Tarjeta', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_item`
--

CREATE TABLE `orden_item` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `orden_compra_id` int(11) NOT NULL,
  `producto` varchar(45) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_U` decimal(10,2) NOT NULL,
  `fecha_orden` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `orden_item`
--

INSERT INTO `orden_item` (`id`, `item_id`, `orden_compra_id`, `producto`, `cantidad`, `precio_U`, `fecha_orden`) VALUES
(1, 2, 1, '2  -  termocontraibles - 30.00bs.', 100, 30.00, '0000-00-00'),
(2, 4, 2, '4  -  Botellas de 400 ml - 7.00bs.', 100, 7.00, '2024-06-17'),
(3, 3, 3, '3  -  Botellas de 200 ml - 9.00bs.', 400, 9.00, '2024-06-17'),
(4, 4, 4, '4  -  Botellas de 400 ml - 7.00bs.', 10, 7.00, '2024-06-17'),
(5, 2, 4, '2  -  termocontraibles - 30.00bs.', 10, 30.00, '2024-06-17'),
(6, 3, 4, '3  -  Botellas de 200 ml - 9.00bs.', 10, 9.00, '2024-06-17'),
(7, 5, 5, '5  -  Botellas de 900 ml - 10.00bs.', 100, 10.00, '2024-06-17'),
(8, 5, 6, '5  -  Botellas de 900 ml - 10.00bs.', 100, 10.00, '2024-06-17'),
(9, 2, 6, '2  -  termocontraibles - 30.00bs.', 120, 30.00, '2024-06-17'),
(10, 6, 6, '6  -  Botellas de 500 ml - 9.00bs.', 100, 9.00, '2024-06-17'),
(11, 4, 7, '4  -  Botellas de 400 ml - 7.00bs.', 100, 7.00, '2024-06-19');

--
-- Disparadores `orden_item`
--
DELIMITER $$
CREATE TRIGGER `actualizar_almacen` BEFORE INSERT ON `orden_item` FOR EACH ROW IF EXISTS (SELECT * FROM item WHERE id = NEW.item_id) THEN

        UPDATE item

        SET stock = stock + NEW.cantidad

        WHERE id = NEW.item_id;

    END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_producto`
--

CREATE TABLE `orden_producto` (
  `id` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `orden_producto`
--

INSERT INTO `orden_producto` (`id`, `precio`, `cantidad`, `orden_id`, `producto_id`) VALUES
(1, 3.00, 1, 1, 1),
(2, 9.00, 3, 3, 1),
(3, 9.00, 3, 4, 1),
(4, 9.00, 3, 5, 1),
(5, 9.00, 3, 6, 1),
(6, 9.00, 3, 7, 1),
(7, 6.00, 2, 8, 1),
(8, 16.00, 2, 8, 2),
(9, 21.00, 7, 9, 1),
(10, 51.00, 17, 10, 1),
(11, 21.00, 7, 11, 1),
(12, 33.00, 11, 12, 1),
(13, 16.00, 2, 12, 2),
(14, 12.00, 4, 13, 1),
(15, 15.00, 5, 14, 1),
(16, 15.00, 5, 16, 1),
(17, 40.00, 5, 16, 2),
(18, 15.00, 5, 17, 1),
(19, 32.00, 4, 17, 2),
(20, 15.00, 5, 18, 1),
(21, 40.00, 5, 18, 2),
(22, 30.00, 10, 19, 1),
(23, 80.00, 10, 19, 2),
(24, 30.00, 10, 20, 1),
(25, 32.00, 4, 20, 2),
(26, 15.00, 5, 21, 1),
(27, 32.00, 4, 21, 2),
(28, 30.00, 10, 22, 1),
(29, 80.00, 10, 22, 2),
(30, 15.00, 5, 23, 1),
(31, 40.00, 5, 23, 2),
(32, 15.00, 5, 24, 1),
(33, 24.00, 3, 24, 2),
(34, 30.00, 3, 24, 3);

--
-- Disparadores `orden_producto`
--
DELIMITER $$
CREATE TRIGGER `after_delete_orden_producto` AFTER DELETE ON `orden_producto` FOR EACH ROW update producto set stock = stock + old.cantidad where id = old.producto_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reducir_stock` AFTER INSERT ON `orden_producto` FOR EACH ROW update producto set stock = (stock - new.cantidad) where id = new.producto_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `pedidos_acep`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `pedidos_acep` (
`orden_id` int(11)
,`nombre_cli` varchar(20)
,`apellido_cli` varchar(45)
,`fecha_conf` date
,`estado_pedido` varchar(10)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `pedidos_rech`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `pedidos_rech` (
`orden_id` int(11)
,`nombre_cli` varchar(20)
,`apellido_cli` varchar(45)
,`fecha_conf` date
,`estado_pedido` varchar(10)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `envase` varchar(45) NOT NULL,
  `capacidad` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `almacen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `envase`, `capacidad`, `precio`, `stock`, `almacen_id`) VALUES
(1, 'Botella', '330cc', 3.00, 871, 1),
(2, 'Botella', '900cc', 8.00, 946, 1),
(3, 'Lata', '1000cc', 10.00, 97, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_mas_comprados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `productos_mas_comprados` (
`producto` varchar(45)
,`cantidad_total` decimal(32,0)
,`proveedor` varchar(66)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_mas_comprados_por_cliente`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `productos_mas_comprados_por_cliente` (
`Fecha` date
,`Id_Cliente` int(11)
,`Nombre_Cliente` varchar(20)
,`Id_Producto` int(11)
,`Producto` varchar(96)
,`Cantidad` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `producto_mas_genera`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `producto_mas_genera` (
`id` int(11)
,`producto` varchar(96)
,`total_generado` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `nombre`, `apellido`, `telefono`, `direccion`) VALUES
(1, 'Diego', 'Fernández', 765432107, 'Calle 6, Villa Adela, El Alto'),
(2, 'Carla', 'Gutierrez', 765432108, 'Avenida 6 de Marzo, Ceja, El Alto'),
(3, 'Pedro', 'Chavez', 765432109, 'Calle 7, Ciudad Satélite, El Alto'),
(4, 'Grinplas SRL', '', 77768721, 'Oficinas El Alto - Bolivia: Calle Eufracio Ibañez, entre calles Warisata y 6 de Junio, No. 4045 Zona'),
(5, 'FABE - Fábrica de En', '', 44288288, 'AV CENTENARIO 4645. ZONA CRUCE TAQUIÑA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regist`
--

CREATE TABLE `regist` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `ci` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `regist`
--

INSERT INTO `regist` (`id`, `email`, `user`, `password`, `ci`) VALUES
(1, 'bandodevelopment@gmail.com', 'admin', '160355', 3452886),
(2, 'alcohol373@gmail.com', 'VENJORMED', '35253525', 14702529),
(4, 'jesteban.medrano@gmail.com', 'ElBando32', '35253525', 14704649),
(5, 'alcohol373@gmail.com', 'UsuarioDePrueba', '12345678', 3452994),
(6, 'juanperez@gmail.com', 'JuanPerez', '12345678', 3698110),
(10, 'jesteban.medrano@gmail.com', 'VEN-ESTMED', 'EsMeY', 14203312),
(11, 'marcoflores@gmail.com', 'VEN-MARFLO', 'MaFlp', 2455893),
(12, 'jemc@gmail.com', 'FelipeMachi', '12345678', 3451002),
(13, 'maririvera@gmail.com', 'ALM-MARRIV', 'MaRiA', 35256970),
(14, 'asdads@gmail.com', 'DIS-CRIAGU', 'CrAgt', 991212),
(15, 'asdads@gmail.com', 'CRISS', 'dasdas', 87978);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `reportes_empleado`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `reportes_empleado` (
`orden_id` bigint(21)
,`fecha` date
,`emp_id` int(11)
,`nombre` varchar(76)
,`Total_Generado` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `resumen_entregas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `resumen_entregas` (
`nombre` varchar(30)
,`apellido` varchar(45)
,`placa` varchar(10)
,`total_entregadas` decimal(23,0)
,`total_pendientes` decimal(23,0)
,`promedio_entregadas` decimal(5,4)
,`promedio_pendientes` decimal(5,4)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `nombre_rol` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`nombre_rol`, `id`) VALUES
('DIST_', 4),
('ALM_', 5),
('VENT_', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('m3qNR6Lgv8R0aJKoHlzvQS6Zxd6gy9fJ7ZHx5LwA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUxSOGJwM2NEQ1RMWXdjekpucTk1YTJpZ1Z6azk2a2JPNE1OQTBHZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kZXRhbGxlP2ZlY2hhPTIwMjQtMDYtMTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1718799843),
('um7jvkhzO9jZNCW2GoXDlxOoPthgDIOCY29PmXkv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibk4zWWs2aFNCejYzM1QzSEJXMkdGNm1zaG9ZaEh5WWhuSkp1SWtxaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC92ZXJfdXN1YXJpb3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1718799428);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `employee_number` varchar(20) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `type` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `borrado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `username`, `email`, `telefono`, `employee_number`, `hire_date`, `type`, `password`, `borrado`) VALUES
(1, 'Admin', 'Admin', 'admin', 'admin3200@gmail.com', 78789618, '0', '0000-00-00', 0, 'adminpassword', 0),
(2, 'Jorge', 'Medrano', 'VENJORMED', 'jesteban.medrano@gmail.com', 78789618, '0001', '2023-05-05', 0, '35253525', 1),
(3, 'Andrea', 'Casas', 'DIS-ANDCAS', 'andreacasas@gmail.com', 78965841, '0002', '2024-06-16', 3500, 'AnCaq', 0),
(5, 'Esteban', 'Medrano', 'VEN-ESTMED', 'jesteban.medrano@gmail.com', 78789618, '0003', '2024-06-17', 4000, 'EsMeD', 0),
(6, 'Marco', 'Flores', 'VEN-MARFLO', 'marcoflores@gmail.com', 77503621, '0004', '2024-06-17', 4000, 'MaFlp', 0),
(7, 'Maria', 'Rivera', 'ALM-MARRIV', 'maririvera@gmail.com', 78789618, '0005', '2024-06-17', 3000, 'MaRiA', 0),
(8, 'Cristhian', 'Aguilar', 'DIS-CRIAGU', 'asdads@gmail.com', 76713767, '0006', '2024-06-19', 3500, 'CrAgt', 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ventas_del_empleado`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `ventas_del_empleado` (
`empleado_id` int(11)
,`orden_id` int(11)
,`fecha_pedido` date
,`estado_pedido` varchar(10)
,`empleado` varchar(76)
,`cliente` varchar(66)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_almacen`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_almacen` (
`nro_de_almacen` int(11)
,`Almacen` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_emps`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_emps` (
`apellidos` varchar(50)
,`nro_emp` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_emp_almacen`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_emp_almacen` (
`id` int(11)
,`name` varchar(50)
,`lastname` varchar(50)
,`username` varchar(50)
,`email` varchar(50)
,`telefono` int(11)
,`employee_number` varchar(20)
,`hire_date` date
,`type` int(11)
,`password` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_orden`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_orden` (
`estado_pedido` varchar(10)
,`fecha_pedido` date
,`tipo_pago` char(8)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_usuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_usuarios` (
`Id` int(11)
,`correo` varchar(50)
,`usuarios` varchar(50)
,`contraseña` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_users_roles`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_users_roles` (
`user_id` int(11)
,`user_name` varchar(50)
,`user_email` varchar(50)
,`user_telefono` int(11)
,`user_employee_number` varchar(20)
,`user_hire_date` date
,`user_type` int(11)
,`user_password` varchar(255)
,`rol_id` int(11)
,`nombre_rol` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidad_mayor1`
--
DROP TABLE IF EXISTS `cantidad_mayor1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidad_mayor1`  AS SELECT `oc`.`fecha_orden` AS `fecha_orden`, `p`.`nombre` AS `nombre_proveedor`, `oi`.`producto` AS `producto`, max(`oi`.`cantidad`) AS `cantidad_total` FROM ((`orden_compra` `oc` join `orden_item` `oi` on(`oi`.`orden_compra_id` = `oc`.`id`)) join `proveedor` `p` on(`oc`.`proveedor_id` = `p`.`id`)) WHERE `p`.`id` = 1 GROUP BY `oc`.`fecha_orden`, `p`.`nombre`, `oi`.`producto`, `p`.`id`, `oc`.`id` ORDER BY max(`oi`.`cantidad`) ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidad_mayor2`
--
DROP TABLE IF EXISTS `cantidad_mayor2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidad_mayor2`  AS SELECT `oc`.`fecha_orden` AS `fecha_orden`, `p`.`nombre` AS `nombre_proveedor`, `oi`.`producto` AS `producto`, max(`oi`.`cantidad`) AS `cantidad_total` FROM ((`orden_compra` `oc` join `orden_item` `oi` on(`oi`.`orden_compra_id` = `oc`.`id`)) join `proveedor` `p` on(`oc`.`proveedor_id` = `p`.`id`)) WHERE `p`.`id` = 2 GROUP BY `oc`.`fecha_orden`, `p`.`nombre`, `oi`.`producto`, `p`.`id`, `oc`.`id` ORDER BY max(`oi`.`cantidad`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidad_mayor3`
--
DROP TABLE IF EXISTS `cantidad_mayor3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidad_mayor3`  AS SELECT `oc`.`fecha_orden` AS `fecha_orden`, `p`.`nombre` AS `nombre_proveedor`, `oi`.`producto` AS `producto`, max(`oi`.`cantidad`) AS `cantidad_total` FROM ((`orden_compra` `oc` join `orden_item` `oi` on(`oi`.`orden_compra_id` = `oc`.`id`)) join `proveedor` `p` on(`oc`.`proveedor_id` = `p`.`id`)) WHERE `p`.`id` = 3 GROUP BY `oc`.`fecha_orden`, `p`.`nombre`, `oi`.`producto`, `p`.`id`, `oc`.`id` ORDER BY max(`oi`.`cantidad`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidad_mayor4`
--
DROP TABLE IF EXISTS `cantidad_mayor4`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidad_mayor4`  AS SELECT `oc`.`fecha_orden` AS `fecha_orden`, `p`.`nombre` AS `nombre_proveedor`, `oi`.`producto` AS `producto`, max(`oi`.`cantidad`) AS `cantidad_total` FROM ((`orden_compra` `oc` join `orden_item` `oi` on(`oi`.`orden_compra_id` = `oc`.`id`)) join `proveedor` `p` on(`oc`.`proveedor_id` = `p`.`id`)) WHERE `p`.`id` = 4 GROUP BY `oc`.`fecha_orden`, `p`.`nombre`, `oi`.`producto`, `p`.`id`, `oc`.`id` ORDER BY max(`oi`.`cantidad`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cantidad_mayor5`
--
DROP TABLE IF EXISTS `cantidad_mayor5`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cantidad_mayor5`  AS SELECT `oc`.`fecha_orden` AS `fecha_orden`, `p`.`nombre` AS `nombre_proveedor`, `oi`.`producto` AS `producto`, max(`oi`.`cantidad`) AS `cantidad_total` FROM ((`orden_compra` `oc` join `orden_item` `oi` on(`oi`.`orden_compra_id` = `oc`.`id`)) join `proveedor` `p` on(`oc`.`proveedor_id` = `p`.`id`)) WHERE `p`.`id` = 5 GROUP BY `oc`.`fecha_orden`, `p`.`nombre`, `oi`.`producto`, `p`.`id`, `oc`.`id` ORDER BY max(`oi`.`cantidad`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `empleados_con_mas_ent_comp`
--
DROP TABLE IF EXISTS `empleados_con_mas_ent_comp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `empleados_con_mas_ent_comp`  AS SELECT `emp`.`id` AS `empleado_id`, `emp`.`nombre` AS `nombre`, `emp`.`apellido` AS `apellido`, count(`hc`.`id`) AS `total_entregas` FROM ((`hoja_carga` `hc` join `empleado_distribucion` `ed` on(`hc`.`empleado_distribucion_id` = `ed`.`id`)) join `empleado` `emp` on(`ed`.`empleado_id` = `emp`.`id`)) WHERE `hc`.`estado_hoja` = 'Entregado' GROUP BY `emp`.`id`, `emp`.`nombre`, `emp`.`apellido` ORDER BY count(`hc`.`id`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `empleados_con_mas_pen`
--
DROP TABLE IF EXISTS `empleados_con_mas_pen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `empleados_con_mas_pen`  AS SELECT `emp`.`id` AS `empleado_id`, `emp`.`nombre` AS `nombre`, `emp`.`apellido` AS `apellido`, count(`hc`.`id`) AS `total_entregas` FROM ((`hoja_carga` `hc` join `empleado_distribucion` `ed` on(`hc`.`empleado_distribucion_id` = `ed`.`id`)) join `empleado` `emp` on(`ed`.`empleado_id` = `emp`.`id`)) WHERE `hc`.`estado_hoja` = 'Pendiente' GROUP BY `emp`.`id`, `emp`.`nombre`, `emp`.`apellido` ORDER BY count(`hc`.`id`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `empleado_mas_generado`
--
DROP TABLE IF EXISTS `empleado_mas_generado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `empleado_mas_generado`  AS SELECT `b`.`fecha_pedido` AS `fecha`, `d`.`id` AS `id`, `d`.`nombre` AS `nombre`, sum(`c`.`precio`) AS `Total_Generado` FROM (((`empleado_ventas` `a` join `orden` `b` on(`a`.`id` = `b`.`empleado_ventas_id`)) join `orden_producto` `c` on(`b`.`id` = `c`.`orden_id`)) join `empleado` `d` on(`a`.`empleado_id` = `d`.`id`)) GROUP BY `b`.`fecha_pedido`, `d`.`id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `empleado_mas_ventas_fecha`
--
DROP TABLE IF EXISTS `empleado_mas_ventas_fecha`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `empleado_mas_ventas_fecha`  AS SELECT `c`.`fecha_pedido` AS `fecha`, `a`.`id` AS `id`, `a`.`nombre` AS `nombre`, count(`c`.`empleado_ventas_id`) AS `Total` FROM ((`empleado` `a` join `empleado_ventas` `b` on(`a`.`id` = `b`.`empleado_id`)) join `orden` `c` on(`b`.`id` = `c`.`empleado_ventas_id`)) GROUP BY `c`.`fecha_pedido`, `c`.`empleado_ventas_id` ORDER BY count(`c`.`empleado_ventas_id`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `join_regist`
--
DROP TABLE IF EXISTS `join_regist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `join_regist`  AS SELECT `r`.`id` AS `regist_id`, `r`.`user` AS `regist_user`, `r`.`password` AS `regist_password`, `u`.`id` AS `users_id`, `u`.`username` AS `users_username`, `u`.`password` AS `users_password` FROM (`regist` `r` left join `users` `u` on(`r`.`id` = `u`.`id`))union all select `r`.`id` AS `regist_id`,`r`.`user` AS `regist_user`,`r`.`password` AS `regist_password`,`u`.`id` AS `users_id`,`u`.`username` AS `users_username`,`u`.`password` AS `users_password` from (`users` `u` left join `regist` `r` on(`r`.`id` = `u`.`id`)) where `r`.`id` is null and `u`.`borrado` = 0  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `pedidos_acep`
--
DROP TABLE IF EXISTS `pedidos_acep`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pedidos_acep`  AS SELECT `o`.`id` AS `orden_id`, `c`.`nombre` AS `nombre_cli`, `c`.`apellido` AS `apellido_cli`, `co`.`fecha` AS `fecha_conf`, `o`.`estado_pedido` AS `estado_pedido` FROM ((`orden` `o` join `confirmar` `co` on(`o`.`id` = `co`.`orden_id`)) join `cliente` `c` on(`o`.`cliente_id` = `c`.`id`)) WHERE `o`.`estado_pedido` = 'Aceptado' ;

-- --------------------------------------------------------

--
-- Estructura para la vista `pedidos_rech`
--
DROP TABLE IF EXISTS `pedidos_rech`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pedidos_rech`  AS SELECT `o`.`id` AS `orden_id`, `c`.`nombre` AS `nombre_cli`, `c`.`apellido` AS `apellido_cli`, `co`.`fecha` AS `fecha_conf`, `o`.`estado_pedido` AS `estado_pedido` FROM ((`orden` `o` join `confirmar` `co` on(`o`.`id` = `co`.`orden_id`)) join `cliente` `c` on(`o`.`cliente_id` = `c`.`id`)) WHERE `o`.`estado_pedido` = 'Rechazado' ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_mas_comprados`
--
DROP TABLE IF EXISTS `productos_mas_comprados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_mas_comprados`  AS SELECT `oi`.`producto` AS `producto`, sum(`oi`.`cantidad`) AS `cantidad_total`, concat(`p`.`nombre`,' ',`p`.`apellido`) AS `proveedor` FROM ((`orden_item` `oi` join `orden_compra` `oc` on(`oi`.`orden_compra_id` = `oc`.`id`)) join `proveedor` `p` on(`oc`.`proveedor_id` = `p`.`id`)) GROUP BY `oi`.`producto`, `p`.`nombre`, `p`.`apellido` ORDER BY sum(`oi`.`cantidad`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_mas_comprados_por_cliente`
--
DROP TABLE IF EXISTS `productos_mas_comprados_por_cliente`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_mas_comprados_por_cliente`  AS SELECT `b`.`fecha_pedido` AS `Fecha`, `a`.`id` AS `Id_Cliente`, `a`.`nombre` AS `Nombre_Cliente`, `d`.`id` AS `Id_Producto`, concat(`d`.`envase`,' ',`d`.`capacidad`) AS `Producto`, count(`d`.`id`) AS `Cantidad` FROM (((`cliente` `a` join `orden` `b` on(`a`.`id` = `b`.`cliente_id`)) join `orden_producto` `c` on(`b`.`id` = `c`.`orden_id`)) join `producto` `d` on(`c`.`producto_id` = `d`.`id`)) GROUP BY `b`.`fecha_pedido`, `a`.`id`, `d`.`id` ORDER BY `d`.`id` DESC, count(`d`.`id`) DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `producto_mas_genera`
--
DROP TABLE IF EXISTS `producto_mas_genera`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `producto_mas_genera`  AS SELECT `a`.`producto_id` AS `id`, concat(`b`.`envase`,' ',`b`.`capacidad`) AS `producto`, sum(`a`.`precio`) AS `total_generado` FROM (`orden_producto` `a` join `producto` `b` on(`a`.`producto_id` = `b`.`id`)) GROUP BY `a`.`producto_id` ORDER BY `a`.`producto_id` DESC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `reportes_empleado`
--
DROP TABLE IF EXISTS `reportes_empleado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reportes_empleado`  AS SELECT count(`b`.`id`) AS `orden_id`, `b`.`fecha_pedido` AS `fecha`, `d`.`id` AS `emp_id`, concat(`d`.`nombre`,' ',`d`.`apellido`) AS `nombre`, sum(`c`.`precio`) AS `Total_Generado` FROM (((`empleado_ventas` `a` join `orden` `b` on(`a`.`id` = `b`.`empleado_ventas_id`)) join `orden_producto` `c` on(`b`.`id` = `c`.`orden_id`)) join `empleado` `d` on(`a`.`empleado_id` = `d`.`id`)) GROUP BY `c`.`orden_id`, `b`.`fecha_pedido`, `d`.`id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `resumen_entregas`
--
DROP TABLE IF EXISTS `resumen_entregas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `resumen_entregas`  AS SELECT `e`.`nombre` AS `nombre`, `e`.`apellido` AS `apellido`, `ed`.`placa` AS `placa`, sum(`hc`.`estado_hoja` = 'Entregado') AS `total_entregadas`, sum(`hc`.`estado_hoja` = 'Pendiente') AS `total_pendientes`, avg(`hc`.`estado_hoja` = 'Entregado') AS `promedio_entregadas`, avg(`hc`.`estado_hoja` = 'Pendiente') AS `promedio_pendientes` FROM ((`empleado` `e` join `empleado_distribucion` `ed` on(`e`.`id` = `ed`.`empleado_id`)) join `hoja_carga` `hc` on(`ed`.`id` = `hc`.`empleado_distribucion_id`)) GROUP BY `e`.`id`, `e`.`nombre`, `e`.`apellido`, `ed`.`placa` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `ventas_del_empleado`
--
DROP TABLE IF EXISTS `ventas_del_empleado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ventas_del_empleado`  AS SELECT `c`.`id` AS `empleado_id`, `a`.`id` AS `orden_id`, `a`.`fecha_pedido` AS `fecha_pedido`, `a`.`estado_pedido` AS `estado_pedido`, concat(`d`.`nombre`,' ',`d`.`apellido`) AS `empleado`, concat(`b`.`nombre`,' ',`b`.`apellido`) AS `cliente` FROM (((`orden` `a` join `cliente` `b` on(`a`.`cliente_id` = `b`.`id`)) join `empleado_ventas` `c` on(`a`.`empleado_ventas_id` = `c`.`id`)) join `empleado` `d` on(`c`.`empleado_id` = `d`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_almacen`
--
DROP TABLE IF EXISTS `view_almacen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_almacen`  AS SELECT `almacen`.`num_almacen` AS `nro_de_almacen`, `almacen`.`tipo_almacen` AS `Almacen` FROM `almacen` WHERE 1 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_emps`
--
DROP TABLE IF EXISTS `view_emps`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_emps`  AS SELECT `users`.`lastname` AS `apellidos`, `users`.`employee_number` AS `nro_emp` FROM `users` WHERE 1 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_emp_almacen`
--
DROP TABLE IF EXISTS `view_emp_almacen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_emp_almacen`  AS SELECT `users`.`id` AS `id`, `users`.`name` AS `name`, `users`.`lastname` AS `lastname`, `users`.`username` AS `username`, `users`.`email` AS `email`, `users`.`telefono` AS `telefono`, `users`.`employee_number` AS `employee_number`, `users`.`hire_date` AS `hire_date`, `users`.`type` AS `type`, `users`.`password` AS `password` FROM `users` WHERE `users`.`type` >= 3000 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_orden`
--
DROP TABLE IF EXISTS `view_orden`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_orden`  AS SELECT `orden`.`estado_pedido` AS `estado_pedido`, `orden`.`fecha_pedido` AS `fecha_pedido`, `orden`.`tipo_pago` AS `tipo_pago` FROM `orden` WHERE 1 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_usuarios`
--
DROP TABLE IF EXISTS `view_usuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_usuarios`  AS SELECT `regist`.`id` AS `Id`, `regist`.`email` AS `correo`, `regist`.`user` AS `usuarios`, `regist`.`password` AS `contraseña` FROM `regist` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_users_roles`
--
DROP TABLE IF EXISTS `vista_users_roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_users_roles`  AS SELECT `u`.`id` AS `user_id`, `u`.`name` AS `user_name`, `u`.`email` AS `user_email`, `u`.`telefono` AS `user_telefono`, `u`.`employee_number` AS `user_employee_number`, `u`.`hire_date` AS `user_hire_date`, `u`.`type` AS `user_type`, `u`.`password` AS `user_password`, `r`.`id` AS `rol_id`, `r`.`nombre_rol` AS `nombre_rol` FROM (`users` `u` left join `rol` `r` on(`u`.`id` = `r`.`id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_almacen_UNIQUE` (`num_almacen`),
  ADD KEY `fk_almacen_empleado_almacen1_idx` (`empleado_almacen_id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ci_UNIQUE` (`ci`),
  ADD KEY `fk_cliente_empleado_ventas1_idx` (`empleado_ventas_id`),
  ADD KEY `CI_INDEX` (`ci`);

--
-- Indices de la tabla `confirmar`
--
ALTER TABLE `confirmar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_confirmar_orden1_idx` (`orden_id`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ci_UNIQUE` (`ci`),
  ADD UNIQUE KEY `CI_INDEX_EMP` (`ci`);

--
-- Indices de la tabla `empleado_almacen`
--
ALTER TABLE `empleado_almacen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empleado_almacen_empleado1_idx` (`empleado_id`);

--
-- Indices de la tabla `empleado_distribucion`
--
ALTER TABLE `empleado_distribucion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa_UNIQUE` (`placa`),
  ADD KEY `fk_empleado_distribucion_empleado1_idx` (`empleado_id`);

--
-- Indices de la tabla `empleado_ventas`
--
ALTER TABLE `empleado_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empleado_ventas_empleado1_idx` (`empleado_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `hoja_carga`
--
ALTER TABLE `hoja_carga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hoja_carga_empleado_distribucion1_idx` (`empleado_distribucion_id`);

--
-- Indices de la tabla `hoja_carga_ordenes`
--
ALTER TABLE `hoja_carga_ordenes`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_hoja_carga_ordenes_hoja_carga1_idx` (`hoja_id`),
  ADD KEY `fk_hoja_carga_ordenes_orden1_idx` (`orden_id`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_imagen_producto_idx` (`id_producto`);

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_almacen1_idx` (`almacen_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_empleado_ventas1_idx` (`empleado_ventas_id`),
  ADD KEY `fk_orden_cliente1_idx` (`cliente_id`),
  ADD KEY `FECHA_INDEX` (`fecha_pedido`),
  ADD KEY `fk_orden_hoja_carga` (`hoja_carga_id`);

--
-- Indices de la tabla `ordenes_por_hoja_carga`
--
ALTER TABLE `ordenes_por_hoja_carga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordenes_por_hoja_carga_orden1_idx` (`orden_id`);

--
-- Indices de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_compra_empleado_almacen1_idx` (`empleado_almacen_id`),
  ADD KEY `fk_orden_compra_proveedor1_idx` (`proveedor_id`);

--
-- Indices de la tabla `orden_item`
--
ALTER TABLE `orden_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_item_item1_idx` (`item_id`),
  ADD KEY `fk_orden_item_orden_compra1_idx` (`orden_compra_id`),
  ADD KEY `buscar_la_fecha` (`fecha_orden`);

--
-- Indices de la tabla `orden_producto`
--
ALTER TABLE `orden_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_producto_orden1_idx` (`orden_id`),
  ADD KEY `fk_orden_producto_producto1_idx` (`producto_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_almacen1_idx` (`almacen_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regist`
--
ALTER TABLE `regist`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_UNIQUE` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `confirmar`
--
ALTER TABLE `confirmar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `empleado_almacen`
--
ALTER TABLE `empleado_almacen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empleado_distribucion`
--
ALTER TABLE `empleado_distribucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empleado_ventas`
--
ALTER TABLE `empleado_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hoja_carga`
--
ALTER TABLE `hoja_carga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `hoja_carga_ordenes`
--
ALTER TABLE `hoja_carga_ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `ordenes_por_hoja_carga`
--
ALTER TABLE `ordenes_por_hoja_carga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `orden_item`
--
ALTER TABLE `orden_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `orden_producto`
--
ALTER TABLE `orden_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `regist`
--
ALTER TABLE `regist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `fk_almacen_empleado_almacen1` FOREIGN KEY (`empleado_almacen_id`) REFERENCES `empleado_almacen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_empleado_ventas1` FOREIGN KEY (`empleado_ventas_id`) REFERENCES `empleado_ventas` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `confirmar`
--
ALTER TABLE `confirmar`
  ADD CONSTRAINT `fk_confirmar_orden1` FOREIGN KEY (`orden_id`) REFERENCES `orden` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado_almacen`
--
ALTER TABLE `empleado_almacen`
  ADD CONSTRAINT `fk_empleado_almacen_empleado1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado_distribucion`
--
ALTER TABLE `empleado_distribucion`
  ADD CONSTRAINT `fk_empleado_distribucion_empleado1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado_ventas`
--
ALTER TABLE `empleado_ventas`
  ADD CONSTRAINT `fk_empleado_ventas_empleado1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `hoja_carga`
--
ALTER TABLE `hoja_carga`
  ADD CONSTRAINT `fk_hoja_carga_empleado_distribucion1` FOREIGN KEY (`empleado_distribucion_id`) REFERENCES `empleado_distribucion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `hoja_carga_ordenes`
--
ALTER TABLE `hoja_carga_ordenes`
  ADD CONSTRAINT `fk_hoja_carga_ordenes_hoja_carga1` FOREIGN KEY (`hoja_id`) REFERENCES `hoja_carga` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_hoja_carga_ordenes_orden1` FOREIGN KEY (`orden_id`) REFERENCES `orden` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `fk_imagen_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_item_almacen1` FOREIGN KEY (`almacen_id`) REFERENCES `almacen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `fk_orden_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_empleado_ventas1` FOREIGN KEY (`empleado_ventas_id`) REFERENCES `empleado_ventas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_hoja_carga` FOREIGN KEY (`hoja_carga_id`) REFERENCES `hoja_carga` (`id`);

--
-- Filtros para la tabla `ordenes_por_hoja_carga`
--
ALTER TABLE `ordenes_por_hoja_carga`
  ADD CONSTRAINT `fk_ordenes_por_hoja_carga_orden1` FOREIGN KEY (`orden_id`) REFERENCES `orden` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD CONSTRAINT `fk_orden_compra_empleado_almacen1` FOREIGN KEY (`empleado_almacen_id`) REFERENCES `empleado_almacen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_compra_proveedor1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_item`
--
ALTER TABLE `orden_item`
  ADD CONSTRAINT `fk_orden_item_item1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_item_orden_compra1` FOREIGN KEY (`orden_compra_id`) REFERENCES `orden_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_producto`
--
ALTER TABLE `orden_producto`
  ADD CONSTRAINT `fk_orden_producto_orden1` FOREIGN KEY (`orden_id`) REFERENCES `orden` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_almacen1` FOREIGN KEY (`almacen_id`) REFERENCES `almacen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

