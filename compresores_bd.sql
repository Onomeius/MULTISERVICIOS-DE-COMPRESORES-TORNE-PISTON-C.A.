-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2024 a las 22:49:34
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
-- Base de datos: `compresores_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estatus` enum('Respondido','En Proceso','Pendiente') NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `fecha`, `estatus`) VALUES
(3, 'Juan Pérez', 'juan.perez@example.com', 'Consulta sobre productos', 'Hola, quisiera más información sobre sus compresores.', '2024-10-21 03:18:34', 'En Proceso'),
(4, 'María López', 'maria.lopez@example.com', 'Soporte técnico', 'Necesito ayuda con el compresor que compré.', '2024-10-21 03:18:34', 'Pendiente'),
(5, 'Carlos Ruiz', 'carlos.ruiz@example.com', 'Sugerencia', 'Me gustaría sugerir algunos productos nuevos.', '2024-10-21 03:18:34', 'Pendiente'),
(6, 'Ana Gómez', 'ana.gomez@example.com', 'Reclamo', 'El producto llegó dañado, ¿qué puedo hacer?', '2024-10-21 03:18:34', 'Pendiente'),
(7, 'Luis Fernández', 'luis.fernandez@example.com', 'Consulta de precio', '¿Cuál es el precio del compresor modelo X?', '2024-10-21 03:18:34', 'Pendiente'),
(8, 'Sofía Martínez', 'sofia.martinez@example.com', 'Consulta de garantía', 'Quiero saber más sobre la garantía de los compresores.', '2024-10-21 03:18:34', 'Pendiente'),
(9, 'Pedro Sánchez', 'pedro.sanchez@example.com', 'Información sobre la entrega', '¿Cuánto tardan en entregar un compresor?', '2024-10-21 03:18:34', 'Pendiente'),
(10, 'Laura Díaz', 'laura.diaz@example.com', 'Pedido urgente', 'Necesito un compresor lo antes posible.', '2024-10-21 03:18:34', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'superadmin'),
(2, 'admin'),
(3, 'generico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `clave_encriptada` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `clave_encriptada`, `fecha_creacion`, `rol_id`) VALUES
(1, 'ejemplo@correo.com', '982ff749380b3d6f5b1d6fc7c929d2184523b3d87310b4e10c31a5db4ce3625f', '2024-10-21 03:09:20', NULL),
(2, 'superadmin@correo.com', 'Superadmin12.', '2024-10-25 18:10:34', 2),
(3, 'admin@correo.com', 'f273c45989b463ac01adbf70dec430f22cd2eb56ec5cb9b421a4488736a66237', '2024-10-25 18:10:34', 3),
(4, 'generico@correo.com', 'Prueba12.', '2024-10-25 18:10:34', 4),
(8, 'Pedroperez@correo.com', 'Pedroperez456..', '2024-10-25 20:13:19', 3),
(10, 'juanperez@correo.com', 'Juanjose45..', '2024-10-25 20:38:29', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
