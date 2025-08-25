-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-08-2025 a las 04:46:09
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
(4, 2, 'salida', 40, '2025-08-19 19:22:47', '');

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
(19, 19, 8, 'Disponible'),
(20, 20, 8, 'Disponible');

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
  `Mesa` int(11) DEFAULT NULL,
  `FechaHora` datetime NOT NULL,
  `tipo_pedido` enum('mesa','domicilio') NOT NULL DEFAULT 'mesa',
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`PedidoID`, `Cliente`, `Mesa`, `FechaHora`, `tipo_pedido`, `direccion`, `telefono`) VALUES
(2, 'Alastor', 3, '2025-07-18 16:13:08', 'mesa', NULL, NULL),
(14, 'Alastor', 6, '2025-08-18 21:26:09', 'mesa', NULL, NULL),
(15, 'Alastor', 6, '2025-08-19 19:25:17', 'mesa', NULL, NULL),
(16, 'Alastor', 6, '2025-08-19 22:29:08', 'mesa', NULL, NULL),
(17, '', 4, '2025-08-21 22:50:24', 'mesa', NULL, NULL),
(18, 'Alastor', 7, '2025-08-24 20:20:13', 'mesa', NULL, NULL),
(19, 'Alastor', 6, '2025-08-24 20:35:41', 'mesa', NULL, NULL),
(20, 'Alastor', 6, '2025-08-24 20:35:58', 'mesa', NULL, NULL),
(21, 'Alastor', NULL, '2025-08-24 20:52:39', 'domicilio', 'asd', '23432'),
(22, 'Alastor', 6, '2025-08-24 21:43:54', 'mesa', NULL, NULL),
(23, 'pepe', NULL, '2025-08-24 21:44:33', 'domicilio', 'calle 23 ', '12345678');

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
(2, 'Pizza Margarita', 'Queso mozzarella, tomate y albahaca fresca.', 22000.00, 5),
(3, 'Ensalada César', 'Lechuga, pollo a la plancha, crutones y aderezo César.', 15000.00, 5),
(4, 'Pasta Alfredo', 'Fettuccine con salsa Alfredo cremosa y pollo.', 20000.00, 10),
(5, 'Sándwich de Pollo', 'Pollo a la plancha, lechuga, tomate y mayonesa.', 16000.00, 19),
(20, 'Sancocho De Gallina', 'Gallina papa etc', 22000.00, 18),
(21, 'salchipapas', 'pues papas con salchicha', 20000.00, 40),
(23, 'pollo con arroz', 'pollo con arroz', 20000.00, 10);

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
(14, 2, 2),
(14, 3, 4),
(14, 4, 5),
(14, 5, 1),
(14, 20, 2),
(14, 21, 4),
(16, 2, 1),
(16, 3, 3),
(16, 4, 1),
(16, 5, 2),
(16, 20, 3),
(16, 21, 4),
(17, 2, 3),
(17, 3, 1),
(17, 4, 2),
(17, 5, 4),
(17, 20, 3),
(17, 21, 2),
(18, 4, 2),
(19, 2, 5),
(20, 2, 5),
(21, 3, 5),
(22, 23, 5),
(23, 23, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos_productos`
--

CREATE TABLE `platos_productos` (
  `id` int(11) NOT NULL,
  `PlatoID` int(11) DEFAULT NULL,
  `ProductoID` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `unidad_medida` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos_productos`
--

INSERT INTO `platos_productos` (`id`, `PlatoID`, `ProductoID`, `cantidad`, `unidad_medida`) VALUES
(1, 23, 5, 10.00, 'unidad'),
(2, 23, 6, 20.00, 'unidad');

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
(2, '2', 'Ajo', 'por gajo', 10),
(3, '3', 'Cilantro', 'por gajos', 40),
(5, '4', 'arroz', 'por libra', 800),
(6, '6', 'pollo', 'libra', 600);

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
(14, 'pepe', '2025-08-17', '20:14:00', 3, 1, 'Pendiente'),
(15, 'pepe', '2025-08-17', '00:32:00', 3, 1, 'Pendiente'),
(16, 'Arley', '2025-08-18', '17:50:00', 5, 7, 'Pendiente'),
(17, 'Arley', '2025-08-18', '00:32:00', 5, 5, 'Pendiente');

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
-- Estructura Stand-in para la vista `vista_ventas_detalladas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_ventas_detalladas` (
`PedidoID` int(11)
,`Cliente` varchar(100)
,`Ubicacion` varchar(267)
,`TipoPedido` enum('mesa','domicilio')
,`Telefono` varchar(20)
,`FechaHora` datetime
,`Plato` varchar(100)
,`precio` decimal(10,2)
,`Cantidad` int(11)
,`Subtotal` decimal(20,2)
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

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_ventas_detalladas`
--
DROP TABLE IF EXISTS `vista_ventas_detalladas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_ventas_detalladas`  AS SELECT `p`.`PedidoID` AS `PedidoID`, `p`.`Cliente` AS `Cliente`, CASE WHEN `p`.`tipo_pedido` = 'mesa' THEN concat('Mesa ',`m`.`Numero`) ELSE concat('Domicilio - ',`p`.`direccion`) END AS `Ubicacion`, `p`.`tipo_pedido` AS `TipoPedido`, `p`.`telefono` AS `Telefono`, `p`.`FechaHora` AS `FechaHora`, `pl`.`nombre` AS `Plato`, `pl`.`precio` AS `precio`, `pp`.`Cantidad` AS `Cantidad`, `pl`.`precio`* `pp`.`Cantidad` AS `Subtotal` FROM (((`pedidos` `p` left join `mesas` `m` on(`p`.`Mesa` = `m`.`MesaID`)) join `platos_pedido` `pp` on(`p`.`PedidoID` = `pp`.`PedidoID`)) join `platos` `pl` on(`pp`.`PlatoID` = `pl`.`PlatoID`)) ORDER BY `p`.`PedidoID` DESC ;

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
-- Indices de la tabla `platos_productos`
--
ALTER TABLE `platos_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PlatoID` (`PlatoID`),
  ADD KEY `ProductoID` (`ProductoID`);

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
-- Indices de la tabla `tb_administradores`
--
ALTER TABLE `tb_administradores`
  ADD PRIMARY KEY (`ID_USUARIO`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `PedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `PlatoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `platos_productos`
--
ALTER TABLE `platos_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `recuperacioncontraseña`
--
ALTER TABLE `recuperacioncontraseña`
  MODIFY `RecuperacionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tb_administradores`
--
ALTER TABLE `tb_administradores`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Filtros para la tabla `platos_pedido`
--
ALTER TABLE `platos_pedido`
  ADD CONSTRAINT `fk_pp_pedido` FOREIGN KEY (`PedidoID`) REFERENCES `pedidos` (`PedidoID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pp_plato` FOREIGN KEY (`PlatoID`) REFERENCES `platos` (`PlatoID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `platos_productos`
--
ALTER TABLE `platos_productos`
  ADD CONSTRAINT `platos_productos_ibfk_1` FOREIGN KEY (`PlatoID`) REFERENCES `platos` (`PlatoID`),
  ADD CONSTRAINT `platos_productos_ibfk_2` FOREIGN KEY (`ProductoID`) REFERENCES `productos` (`id`);

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
