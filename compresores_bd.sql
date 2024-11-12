-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2024 a las 19:50:53
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
  `id` int(6) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `asunto` varchar(255) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estatus` enum('Respondido','En Proceso','Pendiente') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `fecha`, `estatus`) VALUES
(1, 'Juan Pérez', 'juan.perez@example.com', 'Requerimiento de servicio de mantenimiento', 'Solicito un servicio de mantenimiento preventivo para mi compresor. ¿Qué días tienen disponibles?', '2024-11-03 03:14:52', 'En Proceso'),
(2, 'María López', 'maria.lopez@example.com', 'Solicitud de reparación urgente', 'Mi compresor está fallando y necesito una reparación urgente. ¿Pueden asistir hoy?', '2024-11-03 01:53:44', 'En Proceso'),
(3, 'Carlos Gómez', 'carlos.gomez@example.com', 'Requerimiento de servicio de instalación', 'Necesito ayuda para instalar un nuevo compresor en mi taller. ¿Cuánto cuesta el servicio?', '2024-11-03 01:53:44', 'Respondido'),
(4, 'Ana Torres', 'ana.torres@example.com', 'Consulta sobre plan de mantenimiento', 'Quisiera saber si ofrecen planes de mantenimiento a largo plazo para compresores.', '2024-11-03 01:53:44', 'Pendiente'),
(5, 'Luis Martínez', 'luis.martinez@example.com', 'Requerimiento de servicio de diagnóstico', 'Tengo un compresor que no funciona correctamente. Necesito un diagnóstico completo.', '2024-11-03 03:46:34', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `nombre_equipo` varchar(100) DEFAULT NULL,
  `foto_equipo` longblob DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `nombre_equipo`, `foto_equipo`, `cargo`, `fecha_creacion`) VALUES
(1, 'Pedro Pérez', 0x68747470733a2f2f6167656e6369612d666f746f6772616669612e636f6d2f77702d636f6e74656e742f75706c6f6164732f323031342f30362f666f746f732d656e2d4d61647269642e6a7067, 'Presidente', '2024-11-03 11:45:28'),
(2, 'Abg. Edith Guevara', 0x68747470733a2f2f6167656e6369612d666f746f6772616669612e636f6d2f77702d636f6e74656e742f75706c6f6164732f323031332f30392f466f746f677261666f2d706167696e61732d70726f666573696f6e616c65732d312e6a7067, 'Asesor Jurídico', '2024-11-03 11:45:28'),
(3, 'Marlin Orta', 0x68747470733a2f2f6167656e6369612d666f746f6772616669612e636f6d2f77702d636f6e74656e742f75706c6f6164732f323031332f30392f466f746f6772616669612d706172612d43562e6a7067, 'Vice-Presidente', '2024-11-03 11:45:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `id_contacto` int(6) NOT NULL,
  `respuesta` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `id_contacto`, `respuesta`, `fecha_envio`) VALUES
(10, 2, 'Listo ', '2024-11-03 17:36:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_rapidas`
--

CREATE TABLE `respuestas_rapidas` (
  `id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `pregunta` text NOT NULL,
  `respuesta` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `respuestas_rapidas`
--

INSERT INTO `respuestas_rapidas` (`id`, `categoria`, `pregunta`, `respuesta`, `fecha_creacion`) VALUES
(1, 'Servicios', '¿Qué servicios ofrecen en Multiservicios de Compresores?', 'Ofrecemos mantenimiento, reparación y venta de compresores de pistón, así como asesoría técnica para la optimización de sistemas.', '2024-11-03 15:49:18'),
(2, 'Productos', '¿Tienen compresores en stock para la venta?', 'Sí, contamos con una variedad de compresores en stock. Puedes consultar nuestro catálogo en línea o visitarnos en nuestras instalaciones.', '2024-11-03 15:49:18'),
(3, 'Soporte Técnico', '¿Cómo puedo solicitar soporte para mi compresor?', 'Puedes solicitar soporte a través de nuestro formulario de contacto en la web o llamando a nuestro número de atención al cliente.', '2024-11-03 15:49:18'),
(4, 'Facturación', '¿Cuáles son los métodos de pago aceptados?', 'Aceptamos pagos en efectivo, tarjetas de crédito y transferencias bancarias.', '2024-11-03 15:49:18'),
(5, 'Garantías', '¿Ofrecen garantía en los servicios realizados?', 'Sí, todos nuestros servicios cuentan con garantía. Consulta los términos específicos según el servicio realizado.', '2024-11-03 15:49:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `fecha_creacion`) VALUES
(1, 'Superadmin', '2024-11-02 17:53:44'),
(2, 'Admin', '2024-11-02 17:53:44'),
(3, 'Genérico', '2024-11-02 17:53:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `icono`, `fecha_creacion`) VALUES
(1, 'Mantenimiento a difusores', 'Realizamos un mantenimiento integral a los difusores para asegurar su correcto funcionamiento y eficiencia en la distribución del aire.', 'fa fa-wrench', '2024-11-03 15:59:41'),
(2, 'Servicio técnico de cava cuartos', 'Ofrecemos servicio técnico especializado para cavas, garantizando un óptimo almacenamiento de productos a temperaturas controladas.', 'fa fa-cog', '2024-11-03 15:59:41'),
(3, 'Servicio de compresores de refrigeración', 'Mantenimiento y reparación de compresores de refrigeración para asegurar su rendimiento y prolongar su vida útil.', 'fa fa-toolbox', '2024-11-03 15:59:41'),
(4, 'Chequeo diario a niveles de aceite', 'Realizamos chequeos diarios a los niveles de aceite de los equipos para prevenir fallas y asegurar un funcionamiento continuo.', 'fa fa-screwdriver', '2024-11-03 15:59:41'),
(5, 'Monitoreo permanente de temperatura de cavas', 'Monitoreo constante de las temperaturas en cavas para garantizar la conservación adecuada de los productos.', 'fa fa-industry', '2024-11-03 15:59:41'),
(6, 'Mantenimiento de aires acondicionados y equipos de refrigeración y congelación', 'Mantenimiento preventivo y correctivo de aires acondicionados y equipos de refrigeración y congelación para un rendimiento óptimo.', 'fa fa-users', '2024-11-03 15:59:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `clave_encriptada` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rol_id` int(11) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `clave_encriptada`, `fecha_creacion`, `rol_id`, `estado`) VALUES
(1, 'superadmin@correo.com', '6d1358e3312bfee9d8de82a0427b56c158ba3d60bca648a1b47a3691e47b80f1', '2024-11-02 23:19:15', 1, 'activo'),
(2, 'admin@correo.com', '5b28154dad70a218177d8dfae4b10d5abf3b8c56d38bcb77dc9cca5fffa107d5', '2024-11-03 14:33:04', 2, 'activo'),
(3, 'generico@correo.com', '25fb1b3bef6cddd4099bac5f47c28578ca84b8a8595ff350456efa7d7f56958d', '2024-11-03 00:06:52', 3, 'activo'),
(12, 'Pedroperez@correo.com', '25fb1b3bef6cddd4099bac5f47c28578ca84b8a8595ff350456efa7d7f56958d', '2024-11-03 15:21:04', 3, 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_contacto` (`id_contacto`);

--
-- Indices de la tabla `respuestas_rapidas`
--
ALTER TABLE `respuestas_rapidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `respuestas_rapidas`
--
ALTER TABLE `respuestas_rapidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`id_contacto`) REFERENCES `contactos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
