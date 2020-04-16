-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2019 a las 21:41:05
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plantilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Rol/Permiso',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT 'Usuario',
  `created_at` datetime NOT NULL COMMENT 'Creado el'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('r-admin', 1, '2019-05-01 14:38:10'),
('r-super-admin', 1, '2019-05-01 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Rol/Permiso',
  `type` int(11) NOT NULL COMMENT 'Tipo',
  `description` text COLLATE utf8_unicode_ci COMMENT 'Descripción',
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre regla asociada',
  `data` text COLLATE utf8_unicode_ci COMMENT 'Data',
  `created_at` datetime NOT NULL COMMENT 'Creado el',
  `updated_at` datetime NOT NULL COMMENT 'Actualizado el'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('p-auth-all', 2, 'Para que tenga acceso a todo el manejo de roles y permisos', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-auth-assignment-all', 2, 'Permite asignar roles y permisos a los usuarios', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-auth-item-all', 2, 'Tiene acceso CRUD de permisos y roles', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-auth-item-child-all', 2, 'Puede cambiar la jerarquía de permisos', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-auth-menu-item-all', 2, 'Puede organizar el menú de la aplicación', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-configuracion-all', 2, 'Permite configurar el sistema', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-menu-basico', 2, 'Sólo se usa para generar el menú', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-parametrizacion-avanzada-all', 2, 'Hacer labores de parametrización', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-parametrizacion-sistema-all', 2, 'Parametrización que puede hacer el coordinador', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('p-user-all', 2, 'Puede gestionar los usuarios', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('r-admin', 1, 'Encargado de realizar la administración del sistema', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('r-super-admin', 1, 'Es el todo poderoso del sistema.  Puede cambiar los roles y permisos.  ', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Rol/Permiso padre',
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Rol/Permiso hijo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('p-auth-all', 'p-auth-assignment-all'),
('p-auth-all', 'p-auth-item-all'),
('p-auth-all', 'p-auth-item-child-all'),
('p-auth-all', 'p-auth-menu-item-all'),
('r-admin', 'p-menu-basico'),
('r-admin', 'p-parametrizacion-sistema-all'),
('r-admin', 'p-user-all'),
('r-super-admin', 'p-auth-all'),
('r-super-admin', 'p-configuracion-all'),
('r-super-admin', 'p-parametrizacion-avanzada-all'),
('r-super-admin', 'r-admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_menu_item`
--

CREATE TABLE `auth_menu_item` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `padre` int(11) DEFAULT '1' COMMENT 'Padre',
  `orden` tinyint(4) DEFAULT '1' COMMENT 'Orden en que aparecerán las opciones',
  `auth_item` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Permiso al que esta asociado el item',
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del item',
  `label` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Texto que verá el usuario',
  `ruta` varchar(255) COLLATE utf8_unicode_ci DEFAULT '/' COMMENT 'Ruta a la cual lleva el menú',
  `icono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Icono que se verá al lado del menú',
  `separador` tinyint(1) NOT NULL DEFAULT '0' COMMENT '¿Incluye separador después del item?',
  `tipo` enum('root','administracion','aplicacion') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'aplicacion' COMMENT '¿A cuál aplicación pertenece?',
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Actualmente lo puede ver el usuario',
  `descripcion` tinytext COLLATE utf8_unicode_ci COMMENT 'Descripción',
  `creado_por` int(11) UNSIGNED NOT NULL COMMENT 'Creado por',
  `creado_el` datetime NOT NULL COMMENT 'Creado el',
  `actualizado_por` int(11) UNSIGNED NOT NULL COMMENT 'Actualizado por',
  `actualizado_el` datetime NOT NULL COMMENT 'Actualizado el'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0;

--
-- Volcado de datos para la tabla `auth_menu_item`
--

INSERT INTO `auth_menu_item` (`id`, `padre`, `orden`, `auth_item`, `name`, `label`, `ruta`, `icono`, `separador`, `tipo`, `visible`, `descripcion`, `creado_por`, `creado_el`, `actualizado_por`, `actualizado_el`) VALUES
(1, NULL, 0, 'p-menu-basico', 'root', 'root', '/', NULL, 0, 'root', 1, NULL, 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(2, 1, 0, 'p-parametrizacion-sistema-all', 'm-parametrizacion-sistema', 'Sistema', '/', '', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(3, 2, 0, 'r-admin', 'm-parametrizacion-basica', 'Parametrización básica', '/', 'glyphicon glyphicon-cog', 0, 'administracion', 1, 'Parametrizaciones básicas del sistema. Lo puede hacer el administrador y el super administrador.', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(4, 3, 0, 'p-user-all', 'm-administracion-user', 'Usuarios', '/user', 'glyphicon glyphicon-user', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(6, 2, 1, 'p-parametrizacion-avanzada-all', 'm-parametrizacion-avanzada', 'Parametrización avanzada', '/', 'glyphicon glyphicon-cog', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(7, 6, 0, 'p-auth-item-all', 'm-auth-item', 'Roles y permisos', '/auth-item', 'glyphicon glyphicon-lock', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(8, 6, 2, 'p-auth-item-child-all', 'm-auth-item-child', 'Jerarquía de permisos', '/auth-item-child', 'typcn typcn-flow-merge', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(9, 6, 3, 'p-auth-menu-item-all', 'm-auth-menu-item', 'Menú', '/auth-menu-item', 'glyphicon glyphicon-tasks', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(10, 2, 2, 'p-configuracion-all', 'm-config-util', 'Utilidades', '/', 'glyphicon glyphicon-flash', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(11, 10, 1, 'r-super-admin', 'm-auth-rbac', 'RBAC gráfico', '/rbac', 'icon-vector', 1, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(12, 10, 2, 'p-configuracion-all', 'm-config-util-arbol-permisos', 'Vista árbol: permisos', '/configuracion/arbol-permisos/', 'icon-forest-tree', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(13, 10, 3, 'p-configuracion-all', 'm-arbol-menu-administracion', 'Vista árbol: menú administracion', '/configuracion/arbol-menu-administracion/', 'icon-forest-tree', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(14, 10, 4, 'p-configuracion-all', 'm-arbol-menu-aplicacion', 'Vista árbol: menú aplicacion', '/configuracion/arbol-menu-aplicacion/', 'icon-forest-tree', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(15, 10, 5, 'p-auth-assignment-all', 'm-auth-assignment', 'Permisos VS Usuarios', '/auth-assignment', 'icon-vendetta', 0, 'administracion', 1, '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre',
  `data` text COLLATE utf8_unicode_ci COMMENT 'Data',
  `created_at` datetime NOT NULL COMMENT 'Creado el',
  `updated_at` datetime NOT NULL COMMENT 'Actualizado el'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID' PRIMARY KEY,
  `id_number` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Número de identificación del usuario',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombres',
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Apellidos',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de usuario',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Correo personal',
  `estado` tinyint(1) NOT NULL COMMENT '¿Está activo?',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `creado_por` int(11) UNSIGNED DEFAULT NULL COMMENT 'Creado por',
  `created_at` datetime NOT NULL COMMENT 'Creado el',
  `actualizado_por` int(11) UNSIGNED DEFAULT NULL COMMENT 'Actualizado por',
  `updated_at` datetime NOT NULL COMMENT 'Modificado el'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `id_number`, `name`, `surname`, `username`, `email`, `estado`, `auth_key`, `password_hash`, `password_reset_token`, `verification_token`, `creado_por`, `created_at`, `actualizado_por`, `updated_at`) VALUES
(1, '1053835981', 'Fabian Augusto', 'Aguilar Sarmiento', 'fabian.aguilars', 'fabian.aguilars@autonoma.edu.co', 1, 'sLH6aXuJGolxMEo964MuqshYdEm56KuV', '$2y$13$def3aCGmr6qdbjOh7mzzz.FXmRTPL9Ydp1eG3uCz9VxAIJ7pPwHLK', NULL, 'g_M7joOcjgzK9R0-CmnP3Aw3eqc4qBwK_1556729591', NULL, '2019-05-01 11:53:11', NULL, '2019-05-01 11:53:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD UNIQUE KEY `item_name_user_id` (`item_name`,`user_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_name` (`item_name`);

--
-- Indices de la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indices de la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD UNIQUE KEY `parent_child` (`parent`,`child`) USING BTREE,
  ADD KEY `child` (`child`),
  ADD KEY `parent` (`parent`);

--
-- Indices de la tabla `auth_menu_item`
--
ALTER TABLE `auth_menu_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `auth_item` (`auth_item`),
  ADD KEY `created_by` (`creado_por`),
  ADD KEY `updated_by` (`actualizado_por`),
  ADD KEY `padre` (`padre`);

--
-- Indices de la tabla `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `creado_por` (`creado_por`),
  ADD KEY `actualizado_por` (`actualizado_por`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auth_menu_item`
--
ALTER TABLE `auth_menu_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_menu_item`
--
ALTER TABLE `auth_menu_item`
  ADD CONSTRAINT `auth_menu_item_fk1` FOREIGN KEY (`auth_item`) REFERENCES `auth_item` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_menu_item_ibfk_1` FOREIGN KEY (`padre`) REFERENCES `auth_menu_item` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_menu_item_ibfk_2` FOREIGN KEY (`creado_por`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_menu_item_ibfk_3` FOREIGN KEY (`actualizado_por`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`creado_por`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`actualizado_por`) REFERENCES `user` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
