-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2025 a las 06:23:40
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
-- Base de datos: `db_mig_unificada`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_movimiento` (IN `p_producto_id` INT, IN `p_tipo` ENUM('entrada','salida'), IN `p_cantidad` INT, IN `p_observaciones` TEXT)   BEGIN
  -- Insertar el movimiento
  INSERT INTO inventario_movimientos (producto_id, tipo, cantidad, observaciones)
  VALUES (p_producto_id, p_tipo, p_cantidad, p_observaciones);

  -- Actualizar el stock del producto
  IF p_tipo = 'entrada' THEN
    UPDATE productos SET stock = stock + p_cantidad WHERE id = p_producto_id;
  ELSE
    UPDATE productos SET stock = stock - p_cantidad WHERE id = p_producto_id;
  END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_movimientos`
--

CREATE TABLE `inventario_movimientos` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `tipo` enum('entrada','salida') DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario_movimientos`
--

INSERT INTO `inventario_movimientos` (`id`, `producto_id`, `tipo`, `cantidad`, `fecha`, `observaciones`) VALUES
(1, 1, 'entrada', 34, '2025-07-18 16:01:39', 'Stock inicial'),
(2, 1, 'salida', 8, '2025-07-18 16:01:52', 'papas fritas');

--
-- Disparadores `inventario_movimientos`
--
DELIMITER $$
CREATE TRIGGER `trg_actualizar_stock` AFTER INSERT ON `inventario_movimientos` FOR EACH ROW BEGIN
  IF NEW.tipo = 'entrada' THEN
    UPDATE productos SET stock = stock + NEW.cantidad WHERE id = NEW.producto_id;
  ELSE
    UPDATE productos SET stock = stock - NEW.cantidad WHERE id = NEW.producto_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `MesaID` int(11) NOT NULL,
  `Numero` int(11) NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Estado` enum('Disponible','Ocupada','Reservada') DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`MesaID`, `Numero`, `Capacidad`, `Estado`) VALUES
(1, 1, 4, 'Disponible'),
(2, 2, 2, 'Disponible'),
(3, 3, 6, 'Reservada'),
(4, 4, 4, 'Disponible'),
(5, 5, 8, 'Disponible'),
(6, 6, 4, 'Disponible'),
(7, 7, 5, 'Disponible'),
(8, 8, 2, 'Disponible'),
(9, 9, 5, 'Disponible'),
(10, 10, 0, 'Disponible'),
(11, 11, 0, 'Disponible'),
(12, 12, 0, 'Disponible'),
(13, 13, 0, 'Disponible'),
(14, 14, 0, 'Disponible'),
(15, 15, 0, 'Disponible'),
(16, 16, 0, 'Disponible'),
(17, 17, 0, 'Disponible'),
(18, 18, 0, 'Disponible'),
(19, 19, 0, 'Disponible'),
(20, 20, 0, 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `NotificacionID` int(11) NOT NULL,
  `Mensaje` text NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `UsuarioID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `PedidoID` int(11) NOT NULL,
  `Cliente` varchar(100) NOT NULL,
  `Mesa` int(11) NOT NULL,
  `FechaHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`PedidoID`, `Cliente`, `Mesa`, `FechaHora`) VALUES
(2, 'Alastor', 3, '2025-07-18 16:13:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidosdomicilio`
--

CREATE TABLE `pedidosdomicilio` (
  `PedidoID` int(11) NOT NULL,
  `ClienteID` int(11) DEFAULT NULL,
  `DireccionEntrega` text NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Estado` enum('Pendiente','Enviado','Entregado') DEFAULT 'Pendiente',
  `Productos` text DEFAULT NULL,
  `FechaHora` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidosdomicilio`
--

INSERT INTO `pedidosdomicilio` (`PedidoID`, `ClienteID`, `DireccionEntrega`, `Precio`, `Estado`, `Productos`, `FechaHora`) VALUES
(5, 23, '23', 200.00, 'Pendiente', 'ey', '2025-07-18 16:17:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `PlatoID` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`PlatoID`, `nombre`, `descripcion`, `precio`, `cantidad`) VALUES
(1, 'Hamburguesa Clásica', 'Carne de res, lechuga, tomate, queso y salsa especial.', 18000.00, 20),
(2, 'Pizza Margarita', 'Queso mozzarella, tomate y albahaca fresca.', 22000.00, 15),
(3, 'Ensalada César', 'Lechuga, pollo a la plancha, crutones y aderezo César.', 15000.00, 10),
(4, 'Pasta Alfredo', 'Fettuccine con salsa Alfredo cremosa y pollo.', 20000.00, 12),
(5, 'Sándwich de Pollo', 'Pollo a la plancha, lechuga, tomate y mayonesa.', 16000.00, 19),
(16, 'sopa de cerdo', 'sopa con papa y cerdo', 13000.00, 40),
(17, 'poio en salsa', 'pues es pollo bro', 12000.00, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos_pedido`
--

CREATE TABLE `platos_pedido` (
  `PedidoID` int(11) NOT NULL,
  `PlatoID` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos_pedido`
--

INSERT INTO `platos_pedido` (`PedidoID`, `PlatoID`, `Cantidad`) VALUES
(2, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `stock`) VALUES
(1, '1', 'papas', 'pues papas por arroba', 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperacioncontraseña`
--

CREATE TABLE `recuperacioncontraseña` (
  `RecuperacionID` int(11) NOT NULL,
  `UsuarioID` int(11) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `personas` int(11) NOT NULL,
  `mesa_id` int(11) NOT NULL,
  `Estado` enum('Pendiente','Activa','Finalizada') NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `nombre`, `fecha`, `hora`, `personas`, `mesa_id`, `Estado`) VALUES
(3, 'Arley', '2025-07-08', '00:32:00', 4, 7, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_administradores`
--

CREATE TABLE `tb_administradores` (
  `ID_USUARIO` int(11) NOT NULL,
  `NOMBRE` varchar(100) DEFAULT NULL,
  `APELLIDO` varchar(100) DEFAULT NULL,
  `USUARIO` varchar(100) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `PERFIL` varchar(50) DEFAULT 'Administrador',
  `ESTADO` varchar(50) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_administradores`
--

INSERT INTO `tb_administradores` (`ID_USUARIO`, `NOMBRE`, `APELLIDO`, `USUARIO`, `PASSWORD`, `PERFIL`, `ESTADO`) VALUES
(12, 'nadie', 'nadieeee', 'Admin don nadie', '$2y$10$DUD4Wbx3Pj1rlCrBcec5IeqIoj/BR8BhDRSnABjR8FZf5.lI8jYCu', 'Administrador', 'Activo'),
(13, 'lina', 'maria', 'Admin lina', '$2y$10$5QtPDz4FQdEXnGnjP7BuzOguEtSnRyAzmQ4F/bsMIQ8.1/TpYln66', 'Administrador', 'Activo'),
(14, 'dayis', 'dayis', 'Admin dayis', '$2y$10$xyi7x1GuJUWqVUYedXGe8usBEktrtV7/Jm0Fc8Oox7nX0Vo8v9z/i', 'Administrador', 'Activo'),
(15, 'diego', 'juandigu', 'Admin diego', '$2y$10$QZQvy7f4tS9Zd/oNQ3sRheFdrsnIQKCK.45voyGwgSLwm2Q4V63w6', 'Administrador', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_inventario`
--

CREATE TABLE `tb_inventario` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `existencias` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`) VALUES
(23, 'cliente23', 'clave_encriptada'),
(24, 'mesero1', '$2y$10$Og4uP5zu0797f14xl0GSbexjyCPH0c1nnkZxOkGy153gpSZs/dJvS');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_movimientos_inventario`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_movimientos_inventario` (
`id` int(11)
,`producto` varchar(100)
,`tipo` enum('entrada','salida')
,`cantidad` int(11)
,`fecha` datetime
,`observaciones` text
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_pedidos_detallados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_pedidos_detallados` (
`PedidoID` int(11)
,`Cliente` varchar(100)
,`NumeroMesa` int(11)
,`FechaHora` datetime
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_movimientos_inventario`
--
DROP TABLE IF EXISTS `vista_movimientos_inventario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_movimientos_inventario`  AS SELECT `m`.`id` AS `id`, `p`.`nombre` AS `producto`, `m`.`tipo` AS `tipo`, `m`.`cantidad` AS `cantidad`, `m`.`fecha` AS `fecha`, `m`.`observaciones` AS `observaciones` FROM (`inventario_movimientos` `m` join `productos` `p` on(`m`.`producto_id` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_pedidos_detallados`
--
DROP TABLE IF EXISTS `vista_pedidos_detallados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_pedidos_detallados`  AS SELECT `p`.`PedidoID` AS `PedidoID`, `p`.`Cliente` AS `Cliente`, `m`.`Numero` AS `NumeroMesa`, `p`.`FechaHora` AS `FechaHora` FROM (`pedidos` `p` join `mesas` `m` on(`p`.`Mesa` = `m`.`MesaID`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inventario_movimientos`
--
ALTER TABLE `inventario_movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movimientos_producto` (`producto_id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`MesaID`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`NotificacionID`),
  ADD KEY `fk_notificaciones_usuario` (`UsuarioID`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`PedidoID`),
  ADD KEY `fk_pedidos_mesa` (`Mesa`);

--
-- Indices de la tabla `pedidosdomicilio`
--
ALTER TABLE `pedidosdomicilio`
  ADD PRIMARY KEY (`PedidoID`),
  ADD KEY `fk_domicilio_usuario` (`ClienteID`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`PlatoID`);

--
-- Indices de la tabla `platos_pedido`
--
ALTER TABLE `platos_pedido`
  ADD PRIMARY KEY (`PedidoID`,`PlatoID`),
  ADD KEY `fk_pp_plato` (`PlatoID`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recuperacioncontraseña`
--
ALTER TABLE `recuperacioncontraseña`
  ADD PRIMARY KEY (`RecuperacionID`),
  ADD UNIQUE KEY `Token` (`Token`),
  ADD KEY `fk_recuperacion_usuario` (`UsuarioID`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservas_mesa` (`mesa_id`);

--
-- Indices de la tabla `tb_inventario`
--
ALTER TABLE `tb_inventario`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inventario_movimientos`
--
ALTER TABLE `inventario_movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `MesaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `NotificacionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `PedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidosdomicilio`
--
ALTER TABLE `pedidosdomicilio`
  MODIFY `PedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `PlatoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `recuperacioncontraseña`
--
ALTER TABLE `recuperacioncontraseña`
  MODIFY `RecuperacionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inventario_movimientos`
--
ALTER TABLE `inventario_movimientos`
  ADD CONSTRAINT `fk_movimientos_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_notificaciones_usuario` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_mesa` FOREIGN KEY (`Mesa`) REFERENCES `mesas` (`MesaID`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidosdomicilio`
--
ALTER TABLE `pedidosdomicilio`
  ADD CONSTRAINT `fk_domicilio_usuario` FOREIGN KEY (`ClienteID`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `platos_pedido`
--
ALTER TABLE `platos_pedido`
  ADD CONSTRAINT `fk_pp_pedido` FOREIGN KEY (`PedidoID`) REFERENCES `pedidos` (`PedidoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pp_plato` FOREIGN KEY (`PlatoID`) REFERENCES `platos` (`PlatoID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recuperacioncontraseña`
--
ALTER TABLE `recuperacioncontraseña`
  ADD CONSTRAINT `fk_recuperacion_usuario` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reservas_mesa` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`MesaID`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_inventario`
--
ALTER TABLE `tb_inventario`
  ADD CONSTRAINT `fk_inventario_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `limpiar_notificaciones` ON SCHEDULE EVERY 30 DAY STARTS '2025-07-30 23:18:36' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM notificaciones WHERE Fecha < NOW() - INTERVAL 30 DAY$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
