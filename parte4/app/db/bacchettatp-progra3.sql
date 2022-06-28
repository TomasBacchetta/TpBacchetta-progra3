-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2022 a las 22:15:27
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
(26, 'Walter', 1234, '2022-06-13 04:19:33.000000', '2022-06-27 04:49:42.000000', NULL),
(27, 'Johnny', 1234, '2022-06-15 02:47:45.000000', '2022-06-15 03:07:47.000000', NULL);

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
  `estado` varchar(50) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `clave`, `puesto`, `puntaje`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(38, 'Tomi_Cocinero', 1234, 'Cocinero', 0, 'Activo', '2022-06-28 19:32:20.951142', '2022-06-27 05:19:58.000000', NULL),
(39, 'Tomi_Mozo', 1234, 'Mozo', 0, 'Activo', '2022-06-28 20:14:35.007869', '2022-06-28 22:10:37.000000', NULL),
(40, 'Tomi_Cervecero', 1234, 'Cervecero', 0, 'Activo', '2022-06-28 20:14:40.811328', '2022-06-28 22:10:37.000000', NULL),
(41, 'Tomi_Bartender', 1234, 'Bartender', 0, 'Activo', '2022-06-28 20:14:46.123082', '2022-06-28 22:10:37.000000', NULL);

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
  `comentario` varchar(50) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `pedido_id`, `calificacion_mesa`, `calificacion_restaurante`, `calificacion_mozo`, `calificacion_cocinero`, `calificacion_cervecero`, `calificacion_bartender`, `comentario`, `created_at`, `updated_at`, `deleted_at`) VALUES
(53, 78, 8, 9, 5, 10, 8, 6, 'Hermoso el lugar', '2022-06-28 22:10:37.000000', '2022-06-28 22:10:37.000000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `puntaje` float NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `estado`, `puntaje`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10003, 'Cerrada', 0, '2022-06-22 05:05:07.000000', '2022-06-28 22:11:51.000000', NULL),
(10004, 'Cerrada', 0, '2022-06-22 05:05:15.000000', '2022-06-26 06:16:18.000000', NULL);

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
  `con_retraso` varchar(2) NOT NULL DEFAULT 'NO',
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(11, 'Cerveza', 200, 84, 'Barra_Choperas', '00:05:00', '2022-06-13 05:14:22.000000', '2022-06-28 21:47:27.000000', NULL),
(12, 'Coca-Cola 600ml', 200, 84, 'Cocina', '00:05:00', '2022-06-13 07:58:55.000000', '2022-06-25 00:36:58.000000', NULL),
(13, 'Torta', 200, 73, 'Candy_Bar', '00:05:00', '2022-06-13 08:01:32.000000', '2022-06-25 08:19:23.000000', NULL),
(17, 'Daikiri', 200, 67, 'Barra_Tragos', '00:05:00', '2022-06-14 00:09:30.000000', '2022-06-28 21:46:48.000000', NULL),
(18, 'Milanesa Napolitana', 600, 34, 'Cocina', '00:05:00', '2022-06-26 06:05:22.000000', '2022-06-27 05:16:32.000000', NULL),
(19, 'Quatro', 110, 50, 'Barra', '00:05:00', '2022-06-27 04:38:59.000000', '2022-06-27 04:47:47.000000', NULL),
(20, 'Milanesa Napolitana', 600, 40, 'Cocina', '00:05:00', '2022-06-27 04:39:41.000000', '2022-06-27 04:40:48.000000', '2022-06-27 04:40:48.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `empleado` varchar(50) NOT NULL,
  `puesto` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `deleted_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10005;

--
-- AUTO_INCREMENT de la tabla `ordens`
--
ALTER TABLE `ordens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
