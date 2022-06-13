-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2022 a las 05:54:28
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
(12, 'Tomás', 1234, 'Mozo', 0, '2022-06-12 23:13:53.000000', '2022-06-12 23:13:53.000000', NULL),
(13, 'Tomás', 1234, 'Mozo', 0, '2022-06-13 04:35:32.000000', '2022-06-13 04:35:32.000000', NULL),
(14, 'Tomás', 1234, 'Mozo', 0, '2022-06-13 04:36:58.000000', '2022-06-13 04:36:58.000000', NULL),
(15, 'Tomás', 1234, 'Bartender', 0, '2022-06-13 04:37:07.000000', '2022-06-13 04:37:07.000000', NULL),
(16, 'Tomáss', 1234, 'Bartender', 0, '2022-06-13 04:39:09.000000', '2022-06-13 04:39:09.000000', NULL),
(17, 'Pancho', 1234, 'Mozo', 0, '2022-06-13 07:42:40.000000', '2022-06-13 07:42:40.000000', NULL),
(18, 'Ignacio', 1234, 'Bartender', 0, '2022-06-13 07:43:23.000000', '2022-06-13 07:43:23.000000', NULL),
(19, 'Mauricio', 1234, 'Cervecero', 0, '2022-06-13 07:44:29.000000', '2022-06-13 07:44:29.000000', NULL),
(20, 'Mauricio2', 1234, 'Cocinero', 0, '2022-06-13 08:02:08.000000', '2022-06-13 08:02:08.000000', NULL);

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
(10000, 'Cerrada', '2022-06-13 07:07:37.000000', '2022-06-13 07:10:13.000000', '2022-06-13 07:10:13.000000'),
(10001, 'Cerrada', '2022-06-13 07:09:04.000000', '2022-06-13 07:09:04.000000', NULL);

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
(18, 1000, 1, 0, '', 'Con orden', 'FotosMesas/18@mesa.jpg', '2022-06-12 23:11:45.000000', '2022-06-12 23:28:47.000000', NULL);

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
(10, 'Cerveza', 200, 100, 'Barra', '00:05:00', '2022-06-08 06:57:13.000000', '2022-06-08 09:35:07.000000', '2022-06-08 09:35:07.000000'),
(11, 'Cerveza', 200, 100, 'Barra_Choperas', '00:05:00', '2022-06-13 07:14:22.000000', '2022-06-13 07:14:22.000000', NULL),
(12, 'Coca-Cola 600ml', 200, 100, 'Cocina', '00:05:00', '2022-06-13 07:58:55.000000', '2022-06-13 07:58:55.000000', NULL),
(13, 'Torta', 200, 100, 'Candy_Bar', '00:05:00', '2022-06-13 08:01:32.000000', '2022-06-13 08:01:32.000000', NULL),
(14, 'Petete', 200, 100, 'Candy_Bar', '00:05:00', '2022-06-13 08:25:26.000000', '2022-06-13 08:25:26.000000', NULL),
(15, 'Petetee', 200, 100, 'Candy_Bar', '00:05:00', '2022-06-13 08:26:14.000000', '2022-06-13 08:26:14.000000', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;

--
-- AUTO_INCREMENT de la tabla `ordens`
--
ALTER TABLE `ordens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
