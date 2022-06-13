-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2022 a las 06:24:01
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bacchettatp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `dni` int(20) NOT NULL,
  `clave` int(11) NOT NULL,
  `puesto` varchar(50) NOT NULL,
  `puntaje` float NOT NULL,
  `fecha_de_alta` date NOT NULL,
  `fecha_de_baja` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `dni`, `clave`, `puesto`, `puntaje`, `fecha_de_alta`, `fecha_de_baja`) VALUES
(11, 'Tomás', 37008547, 1234, 'Mozo', 0, '2022-06-02', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `numero` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`numero`, `estado`) VALUES
(1000, 'Cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `num_orden` int(11) NOT NULL,
  `num_pedido` int(11) NOT NULL,
  `num_producto` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `tiempo_inicio` varchar(50) NOT NULL,
  `tiempo_estimado` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `calificacion_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`num_orden`, `num_pedido`, `num_producto`, `descripcion`, `cantidad`, `subtotal`, `tiempo_inicio`, `tiempo_estimado`, `estado`, `calificacion_empleado`) VALUES
(34, 17, 4, 'Milanesa', 3, 1500, '2022-06-07 05:58:46', '00:05:00', 'en_preparacion', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `num_pedido` int(11) NOT NULL,
  `num_mesa` int(11) NOT NULL,
  `num_mozo` int(11) NOT NULL,
  `total` float NOT NULL,
  `tiempo_estimado` varchar(50) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `estado` varchar(50) NOT NULL,
  `calificacion_mozo` int(11) NOT NULL,
  `calificacion_mesa` int(11) NOT NULL,
  `calificacion_restaurante` int(11) NOT NULL,
  `comentario` varchar(66) NOT NULL,
  `foto_mesa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`num_pedido`, `num_mesa`, `num_mozo`, `total`, `tiempo_estimado`, `fecha_pedido`, `estado`, `calificacion_mozo`, `calificacion_mesa`, `calificacion_restaurante`, `comentario`, `foto_mesa`) VALUES
(17, 1000, 1, 1500, '00:05:00', '2022-06-07', 'Con orden', 0, 0, 0, '', 'FotosMesas/17@mesa.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `tiempo_estimado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `descripcion`, `precio`, `stock`, `sector`, `tiempo_estimado`) VALUES
(4, 'Milanesa', 500, 85, 'Cocina', '00:05:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`numero`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`num_orden`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`num_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `num_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `num_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
