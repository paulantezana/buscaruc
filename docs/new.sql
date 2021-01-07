-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-01-2021 a las 20:29:54
-- Versión del servidor: 10.3.27-MariaDB-log-cll-lve
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `paulpvad_ruc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_authorizations`
--

CREATE TABLE `app_authorizations` (
  `app_authorization_id` int(11) NOT NULL,
  `module` varchar(64) NOT NULL,
  `action` varchar(64) DEFAULT '',
  `description` varchar(64) DEFAULT '',
  `state` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `app_authorizations`
--

INSERT INTO `app_authorizations` (`app_authorization_id`, `module`, `action`, `description`, `state`) VALUES
(1, 'home', 'home', 'dashboard', 1),
(2, 'rol', 'listar', 'listar roles', 1),
(3, 'rol', 'crear', 'crear nuevos rol', 1),
(4, 'rol', 'eliminar', 'Eliminar un rol', 1),
(5, 'rol', 'modificar', 'Acualizar los roles', 1),
(6, 'usuario', 'listar', 'listar usuarios', 1),
(7, 'usuario', 'crear', 'crear nuevo usuarios', 1),
(8, 'usuario', 'eliminar', 'Eliminar un usuario', 1),
(9, 'usuario', 'modificar', 'Acualizar los datos del usuario exepto la contraseña', 1),
(10, 'usuario', 'modificarContraseña', 'Solo se permite actualizar la contraseña', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `census`
--

CREATE TABLE `census` (
  `ruc` bigint(20) NOT NULL,
  `social_reason` varchar(255) NOT NULL,
  `taxpayer_state` varchar(64) DEFAULT '',
  `domicile_condition` varchar(64) DEFAULT '',
  `ubigeo` varchar(12) DEFAULT '',
  `type_road` varchar(12) DEFAULT '',
  `name_road` varchar(128) DEFAULT '',
  `zone_code` varchar(32) DEFAULT '',
  `type_zone` varchar(128) DEFAULT '',
  `number` varchar(64) DEFAULT '',
  `inside` varchar(64) DEFAULT '',
  `lot` varchar(64) DEFAULT '',
  `department` varchar(64) DEFAULT '',
  `kilometer` varchar(64) DEFAULT '',
  `address` varchar(150) DEFAULT '',
  `full_address` varchar(250) DEFAULT '',
  `last_update_sunat` varchar(64) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `census_files`
--

CREATE TABLE `census_files` (
  `census_file_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `is_process` tinyint(4) DEFAULT 0,
  `file_type` varchar(64) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` enum('0','1','2') DEFAULT '2',
  `avatar` varchar(64) DEFAULT '',
  `email` varchar(64) DEFAULT '',
  `user_role_id` int(11) NOT NULL,
  `phone` varchar(32) DEFAULT '',
  `is_verified` tinyint(4) DEFAULT 0,
  `date_verified` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `updated_user_id` int(11) DEFAULT NULL,
  `state` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `full_name`, `gender`, `avatar`, `email`, `user_role_id`, `phone`, `is_verified`, `date_verified`, `updated_at`, `created_at`, `created_user_id`, `updated_user_id`, `state`) VALUES
(1, 'admin1', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', 'admin1', '1', '', 'admin@admin.com', 2, '', 0, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_forgots`
--

CREATE TABLE `user_forgots` (
  `user_forgot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `secret_key` varchar(128) NOT NULL,
  `used` tinyint(4) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `updated_user_id` int(11) DEFAULT NULL,
  `state` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `user_role_id` int(11) NOT NULL,
  `description` varchar(64) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `updated_user_id` int(11) DEFAULT NULL,
  `state` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_roles`
--

INSERT INTO `user_roles` (`user_role_id`, `description`, `updated_at`, `created_at`, `created_user_id`, `updated_user_id`, `state`) VALUES
(1, 'Usuario', NULL, '2020-02-17 00:00:00', 0, NULL, 1),
(2, 'Administrador', NULL, '2020-02-17 00:00:00', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_role_authorizations`
--

CREATE TABLE `user_role_authorizations` (
  `user_role_id` int(11) NOT NULL,
  `app_authorization_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_role_authorizations`
--

INSERT INTO `user_role_authorizations` (`user_role_id`, `app_authorization_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(1, 1),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_tokens`
--

CREATE TABLE `user_tokens` (
  `user_token_id` int(11) NOT NULL,
  `api_token` varchar(64) DEFAULT '',
  `query_count` int(11) DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `updated_user_id` int(11) DEFAULT NULL,
  `state` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_tokens`
--

INSERT INTO `user_tokens` (`user_token_id`, `api_token`, `query_count`, `user_id`, `updated_at`, `created_at`, `created_user_id`, `updated_user_id`, `state`) VALUES
(1, 'eyJ1c2VySWQiOjEsInVzZXJUb2tlbklkIjoxfQ.KEqxZNc0_PqcsJj786nZC1Knh', 9, 1, '2020-12-25 17:36:12', '2020-11-06 13:00:53', 1, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `app_authorizations`
--
ALTER TABLE `app_authorizations`
  ADD PRIMARY KEY (`app_authorization_id`);

--
-- Indices de la tabla `census`
--
ALTER TABLE `census`
  ADD PRIMARY KEY (`ruc`);

--
-- Indices de la tabla `census_files`
--
ALTER TABLE `census_files`
  ADD PRIMARY KEY (`census_file_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_user_roles` (`user_role_id`);

--
-- Indices de la tabla `user_forgots`
--
ALTER TABLE `user_forgots`
  ADD PRIMARY KEY (`user_forgot_id`),
  ADD KEY `fk_user_forgots_user` (`user_id`);

--
-- Indices de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_role_id`);

--
-- Indices de la tabla `user_role_authorizations`
--
ALTER TABLE `user_role_authorizations`
  ADD KEY `fk_user_roles_authorization_user_roles` (`user_role_id`),
  ADD KEY `fk_user_roles_authorization_app_authorizations` (`app_authorization_id`);

--
-- Indices de la tabla `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`user_token_id`),
  ADD KEY `fk_user_tokens_user` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `app_authorizations`
--
ALTER TABLE `app_authorizations`
  MODIFY `app_authorization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `census_files`
--
ALTER TABLE `census_files`
  MODIFY `census_file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user_forgots`
--
ALTER TABLE `user_forgots`
  MODIFY `user_forgot_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `user_token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_user_roles` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`user_role_id`);

--
-- Filtros para la tabla `user_forgots`
--
ALTER TABLE `user_forgots`
  ADD CONSTRAINT `fk_user_forgots_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `user_role_authorizations`
--
ALTER TABLE `user_role_authorizations`
  ADD CONSTRAINT `fk_user_roles_authorization_app_authorizations` FOREIGN KEY (`app_authorization_id`) REFERENCES `app_authorizations` (`app_authorization_id`),
  ADD CONSTRAINT `fk_user_roles_authorization_user_roles` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`user_role_id`);

--
-- Filtros para la tabla `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `fk_user_tokens_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;