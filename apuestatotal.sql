-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2024 a las 06:08:07
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
-- Base de datos: `apuestatotal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `idbanco` int(11) NOT NULL,
  `nombre_banco` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `banco`
--

INSERT INTO `banco` (`idbanco`, `nombre_banco`, `estado`) VALUES
(1, 'BCP', 1),
(2, 'BBVA', 1),
(3, 'SCOTIABANK', 1),
(4, 'INTERBANK', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `idtipo_documento` int(11) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `idplayer` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `idtipo_documento`, `dni`, `apellidos`, `nombres`, `email`, `telefono`, `password`, `idplayer`, `estado`) VALUES
(1, 1, '73672250', 'RIO PEREZ', 'JORGE', 'JORGERIOA@GMAIL.COM', '987654321', '73672250', 52749143, 1),
(2, 1, '73672260', 'GUERRA', 'RICARDO', 'RICARDOGUERRA@GMAIL.COM', '987654312', '73672260', 55749144, 1),
(3, 1, '33313136', 'WONG ALIVIARI', 'JOSE CARLOS', 'JOSE@GMAIL.COM', '912345678', '33313136', 52149144, 1),
(4, 1, '72174032', 'Loo Jara', 'Luigui', 'Luigi@hotmail.com', '9411241', '72174032', 52749147, 1),
(5, 1, '12411241', 'GONZALES', 'RUISSO', 'gonzales@hotmail.com', '23532532', '12411241', 52129144, 1),
(11, 1, '88772211', 'Lozano Peralta', 'Jose', 'jose@hotmail.com', '1241241', '88772211', 52749144, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deposito`
--

CREATE TABLE `deposito` (
  `iddeposito` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idtipo_deposito` int(11) NOT NULL,
  `idbanco` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `idusuario` int(11) NOT NULL,
  `nrovoucher` int(11) DEFAULT NULL,
  `idplataforma` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `deposito`
--

INSERT INTO `deposito` (`iddeposito`, `idcliente`, `idtipo_deposito`, `idbanco`, `monto`, `fecha`, `idusuario`, `nrovoucher`, `idplataforma`, `estado`) VALUES
(1, 1, 1, 2, 1313.11, '2024-05-26 17:40:22', 1, 24123412, 1, 1),
(2, 2, 1, 1, 13.00, '2024-05-26 19:38:51', 1, 98472184, 1, 1),
(3, 2, 1, 2, 3.13, '2024-05-26 19:42:29', 1, 51512514, 4, 1),
(4, 2, 1, 2, 13.31, '2024-05-26 19:44:30', 0, 13412414, 3, 2),
(5, 2, 1, 2, 3.11, '2024-05-26 19:45:06', 0, 73141124, 3, 2),
(6, 2, 1, 1, 41.24, '2024-05-26 19:51:58', 0, 41212214, 1, 2),
(7, 1, 1, 1, 12.11, '2024-05-26 20:19:08', 1, 12853123, 1, 1),
(8, 11, 2, 1, 12.12, '2024-05-26 21:53:19', 0, 12998313, 1, 2),
(9, 11, 1, 4, 124.12, '2024-05-26 21:53:54', 1, 12431341, 3, 1),
(10, 4, 1, 1, 50.00, '2024-05-26 22:57:29', 0, 50, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataforma`
--

CREATE TABLE `plataforma` (
  `idplataforma` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `icono` varchar(20) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `plataforma`
--

INSERT INTO `plataforma` (`idplataforma`, `descripcion`, `icono`, `estado`) VALUES
(1, 'WhatsApp', 'fa fa-whatsapp', 1),
(2, 'Messenger', 'fa fa-weixin', 1),
(3, 'Facebook', 'fa fa-facebook', 1),
(4, 'Telegram', 'fa fa-telegram', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_deposito`
--

CREATE TABLE `tipo_deposito` (
  `idtipo_deposito` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_deposito`
--

INSERT INTO `tipo_deposito` (`idtipo_deposito`, `descripcion`, `estado`) VALUES
(1, 'Depósito por banco', 1),
(2, 'Depósito en efectivo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `idtipo_documento` int(11) NOT NULL,
  `documento` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`idtipo_documento`, `documento`, `estado`) VALUES
(1, 'DNI', 1),
(2, 'Pasaporte', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usuario`, `password`, `estado`, `nombre`, `cargo`) VALUES
(1, 'admin', 'admin', 1, 'Luigui Loo', 'Jefe de sistemas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`idbanco`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `idtipo_documento` (`idtipo_documento`);

--
-- Indices de la tabla `deposito`
--
ALTER TABLE `deposito`
  ADD PRIMARY KEY (`iddeposito`),
  ADD KEY `idcliente` (`idcliente`,`idtipo_deposito`,`idbanco`,`idusuario`,`idplataforma`),
  ADD KEY `idplataforma` (`idplataforma`),
  ADD KEY `idbanco` (`idbanco`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `plataforma`
--
ALTER TABLE `plataforma`
  ADD PRIMARY KEY (`idplataforma`);

--
-- Indices de la tabla `tipo_deposito`
--
ALTER TABLE `tipo_deposito`
  ADD PRIMARY KEY (`idtipo_deposito`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`idtipo_documento`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `idbanco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `deposito`
--
ALTER TABLE `deposito`
  MODIFY `iddeposito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `plataforma`
--
ALTER TABLE `plataforma`
  MODIFY `idplataforma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_deposito`
--
ALTER TABLE `tipo_deposito`
  MODIFY `idtipo_deposito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `idtipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`idtipo_documento`) REFERENCES `tipo_documento` (`idtipo_documento`);

--
-- Filtros para la tabla `deposito`
--
ALTER TABLE `deposito`
  ADD CONSTRAINT `deposito_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
  ADD CONSTRAINT `deposito_ibfk_2` FOREIGN KEY (`idplataforma`) REFERENCES `plataforma` (`idplataforma`),
  ADD CONSTRAINT `deposito_ibfk_3` FOREIGN KEY (`idbanco`) REFERENCES `banco` (`idbanco`);

--
-- Filtros para la tabla `tipo_deposito`
--
ALTER TABLE `tipo_deposito`
  ADD CONSTRAINT `tipo_deposito_ibfk_1` FOREIGN KEY (`idtipo_deposito`) REFERENCES `deposito` (`iddeposito`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `deposito` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
