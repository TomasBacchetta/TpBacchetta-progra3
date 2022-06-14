-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2022 a las 22:37:33
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
-- Base de datos: `bacchettatp-progra3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `clave` int(11) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id`, `nombre`, `clave`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Jorge', 1234, '2022-06-13 03:02:08.000000', '2022-06-13 03:02:08.000000', NULL),
(20, 'Pedro', 1234, '2022-06-13 03:43:14.000000', '2022-06-13 04:26:42.000000', '2022-06-13 04:26:42.000000'),
(21, 'Pedro', 1234, '2022-06-13 04:13:47.000000', '2022-06-13 04:13:47.000000', NULL),
(22, 'Pedro', 1234, '2022-06-13 04:13:57.000000', '2022-06-13 04:13:57.000000', NULL),
(23, 'Pedro', 1234, '2022-06-13 04:16:39.000000', '2022-06-13 04:16:39.000000', NULL),
(24, 'Pedro', 1234, '2022-06-13 04:18:53.000000', '2022-06-13 04:27:10.000000', '2022-06-13 04:27:10.000000'),
(25, 'Pedro', 1234, '2022-06-13 04:18:56.000000', '2022-06-13 04:26:56.000000', '2022-06-13 04:26:56.000000'),
(26, 'Pedro', 1234, '2022-06-13 04:19:33.000000', '2022-06-13 04:19:33.000000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `clave` int(11) NOT NULL,
  `puesto` varchar(50) NOT NULL,
  `puntaje` float NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `clave`, `puesto`, `puntaje`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 'Tomi_Mozo', 1234, 'Mozo', 0, '2022-06-15 00:31:09.000000', '2022-06-15 00:31:09.000000', NULL),
(32, 'Tomi_Cervecero', 1234, 'Cervecero', 0, '2022-06-15 00:34:04.000000', '2022-06-15 00:34:04.000000', NULL),
(33, 'Tomi_Cocinero', 1234, 'Cocinero', 0, '2022-06-15 00:34:13.000000', '2022-06-15 00:34:13.000000', NULL),
(34, 'Tomi_Bartender', 1234, 'Bartender', 0, '2022-06-15 00:34:26.000000', '2022-06-15 00:34:26.000000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `calificacion_mesa` int(11) NOT NULL,
  `calificacion_restaurante` int(11) NOT NULL,
  `calificacion_mozo` int(11) NOT NULL,
  `calificacion_cocinero` int(11) NOT NULL,
  `calificacion_cervecero` int(11) NOT NULL,
  `calificacion_bartender` int(11) NOT NULL,
  `comentario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10001, 'Con cliente comiendo', '2022-06-13 07:09:04.000000', '2022-06-15 01:25:10.000000', NULL),
(10002, 'Cerrada', '2022-06-14 02:14:50.000000', '2022-06-15 00:28:36.000000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordens`
--

CREATE TABLE `ordens` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `tiempo_inicio` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `tiempo_estimado` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ordens`
--

INSERT INTO `ordens` (`id`, `pedido_id`, `producto_id`, `empleado_id`, `descripcion`, `cantidad`, `subtotal`, `tiempo_inicio`, `tiempo_estimado`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(46, 31, 17, 22, 'Daikiri', 1, 200, '2022-06-14 19:39:33.263643', '00:05:00', 'Listo para servir', '2022-06-15 00:36:43.000000', '2022-06-15 00:39:33.000000', NULL),
(47, 32, 17, 22, 'Daikiri', 1, 200, '2022-06-14 20:26:02.925853', '00:05:00', 'Preparada', '2022-06-15 01:17:07.000000', '2022-06-15 01:26:02.000000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `mesa_id` int(11) NOT NULL,
  `mozo_id` int(11) NOT NULL,
  `total` float NOT NULL,
  `tiempo_estimado` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `foto_mesa` varchar(50) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `mesa_id`, `mozo_id`, `total`, `tiempo_estimado`, `estado`, `foto_mesa`, `created_at`, `updated_at`, `deleted_at`) VALUES
(31, 10001, 22, 0, '00:05:00', 'Servido', 'FotosMesas/31@10001-mesa.jpg', '2022-06-15 00:35:34.000000', '2022-06-15 00:41:50.000000', NULL),
(32, 10001, 22, 0, '00:05:00', 'Listo para servir', 'FotosMesas/32@10001-mesa.jpg', '2022-06-15 01:16:47.000000', '2022-06-15 01:20:59.000000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `tiempo_estimado` varchar(50) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `descripcion`, `precio`, `stock`, `sector`, `tiempo_estimado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'Coca-Cola 600ml', 200, 94, 'Barra', '00:05:00', '2022-06-08 06:56:37.000000', '2022-06-13 07:13:45.000000', '2022-06-13 07:13:45.000000'),
(11, 'Cerveza', 200, 100, 'Barra_Choperas', '00:05:00', '2022-06-13 07:14:22.000000', '2022-06-13 07:14:22.000000', NULL),
(12, 'Coca-Cola 600ml', 200, 100, 'Cocina', '00:05:00', '2022-06-13 07:58:55.000000', '2022-06-13 07:58:55.000000', NULL),
(13, 'Torta', 200, 94, 'Candy_Bar', '00:05:00', '2022-06-13 08:01:32.000000', '2022-06-14 02:22:56.000000', NULL),
(17, 'Daikiri', 200, 92, 'Barra_Tragos', '00:05:00', '2022-06-14 02:09:30.000000', '2022-06-15 01:17:07.000000', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordens`
--
ALTER TABLE `ordens`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10003;

--
-- AUTO_INCREMENT de la tabla `ordens`
--
ALTER TABLE `ordens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
