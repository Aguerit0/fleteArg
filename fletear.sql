

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2023 a las 02:16:43
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fletear`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `apellidoCliente` varchar(50) NOT NULL,
  `correoCliente` varchar(50) NOT NULL,
  `dniCliente` varchar(50) NOT NULL,
  `domicilioCliente` varchar(50) NOT NULL,
  `telefonoCliente` varchar(50) NOT NULL,
  `fechaNacCliente` varchar(50) NOT NULL,
  `sexoCliente` int(11) NOT NULL,
  `fechaRegCliente` varchar(50) NOT NULL,
  `eliminadoCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombreCliente`, `apellidoCliente`, `correoCliente`, `dniCliente`, `domicilioCliente`, `telefonoCliente`, `fechaNacCliente`, `sexoCliente`, `fechaRegCliente`, `eliminadoCliente`) VALUES
(9, 'usu', 'usu', 'usu@gmail.com', '1', '1', '1', '0001-11-11', 0, '2023-09-06 21:48:06', 0),
(10, 'fle', 'fle', 'fle@gmail.com', '2', '2', '23123', '0002-02-22', 0, '2023-09-07 00:23:14', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fletero`
--

CREATE TABLE `fletero` (
  `idFletero` int(11) NOT NULL,
  `imagenFletero` longblob NOT NULL,
  `descripcionFletero` varchar(50) NOT NULL,
  `carnetFletero` longblob NOT NULL,
  `cedulaFletero` longblob NOT NULL,
  `cantidadVehiculosFletero` int(11) NOT NULL,
  `cantidadViajesFletero` int(11) NOT NULL,
  `puntajeFletero` int(11) NOT NULL,
  `actividadFletero` int(11) NOT NULL,
  `fechaRegFletero` int(11) NOT NULL,
  `eliminadoFletero` int(11) NOT NULL DEFAULT 0,
  `idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fletero`
--

INSERT INTO `fletero` (`idFletero`, `imagenFletero`, `descripcionFletero`, `carnetFletero`, `cedulaFletero`, `cantidadVehiculosFletero`, `cantidadViajesFletero`, `puntajeFletero`, `actividadFletero`, `fechaRegFletero`, `eliminadoFletero`, `idCliente`) VALUES
(5, 0x2e2e2f696d6167656e6573466c657465726f2f696d6167656e466c657465726f2f696d67312e6a7067, '', 0x2e2e2f696d6167656e6573466c657465726f2f6361726e6574466c657465726f2f696d67312e6a7067, 0x2e2e2f696d6167656e6573466c657465726f2f636564756c61466c657465726f2f696d67312e6a7067, 1, 1, 5, 0, 2147483647, 0, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL,
  `precioServicio` varchar(50) NOT NULL,
  `metodoPagoServicio` int(11) NOT NULL,
  `fechaSalidaServicio` varchar(50) NOT NULL,
  `fechaLlegadaServicio` varchar(50) NOT NULL,
  `estadoServicio` varchar(50) NOT NULL DEFAULT '0',
  `ubicacionSalidaServicio` varchar(50) NOT NULL,
  `ubicacionLlegadaServicio` varchar(50) NOT NULL,
  `distanciaServicio` varchar(50) NOT NULL,
  `tiempoServicio` varchar(50) NOT NULL,
  `descripcionServicio` varchar(50) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idFletero` int(11) NOT NULL,
  `idVehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`idServicio`, `precioServicio`, `metodoPagoServicio`, `fechaSalidaServicio`, `fechaLlegadaServicio`, `estadoServicio`, `ubicacionSalidaServicio`, `ubicacionLlegadaServicio`, `distanciaServicio`, `tiempoServicio`, `descripcionServicio`, `idCliente`, `idFletero`, `idVehiculo`) VALUES
(1, '23491.19', 0, '2023-09-14 20:09:40', '--', 'en camino', 'lat: -28.466876 / long: -65.782814', 'lat: -28.470923 / long: -65.767506', '2.09', '5.49', 'asdsad', 9, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `rol` int(11) NOT NULL,
  `eliminado` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `usuario`, `contraseña`, `rol`, `eliminado`, `idCliente`) VALUES
(1, 'usu', 'usu', 0, 0, 9),
(2, 'fle', 'fle', 1, 0, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `idVehiculo` int(11) NOT NULL,
  `vehiculoVehiculo` longblob NOT NULL,
  `seguroVehiculo` longblob NOT NULL,
  `tituloVehiculo` longblob NOT NULL,
  `patenteVehiculo` longblob NOT NULL,
  `patenteVehiculoText` varchar(50) NOT NULL,
  `tipoVehiculo` varchar(50) NOT NULL,
  `colorVehiculo` varchar(50) NOT NULL,
  `descripcionVehiculo` varchar(50) NOT NULL,
  `fechaRegVehiculo` varchar(50) NOT NULL,
  `solicitudVehiculo` int(11) NOT NULL DEFAULT 0,
  `eliminadoVehiculo` int(11) NOT NULL DEFAULT 0,
  `idFletero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`idVehiculo`, `vehiculoVehiculo`, `seguroVehiculo`, `tituloVehiculo`, `patenteVehiculo`, `patenteVehiculoText`, `tipoVehiculo`, `colorVehiculo`, `descripcionVehiculo`, `fechaRegVehiculo`, `solicitudVehiculo`, `eliminadoVehiculo`, `idFletero`) VALUES
(1, 0x2e2e2f696d6167656e6573466c657465726f2f7665686963756c6f5665686963756c6f2f696d67312e6a7067, 0x2e2e2f696d6167656e6573466c657465726f2f73656775726f5665686963756c6f2f696d67312e6a7067, 0x2e2e2f696d6167656e6573466c657465726f2f746974756c6f5665686963756c6f2f696d67312e6a7067, 0x2e2e2f696d6167656e6573466c657465726f2f706174656e74655665686963756c6f2f696d67312e6a7067, 'asdasd', '1', 'asdad', 'asdasd', '2023-09-14 20:00:04', 0, 0, 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `fletero`
--
ALTER TABLE `fletero`
  ADD PRIMARY KEY (`idFletero`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`idServicio`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idFletero` (`idFletero`),
  ADD KEY `idVehiculo` (`idVehiculo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`idVehiculo`),
  ADD KEY `idFletero` (`idFletero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `fletero`
--
ALTER TABLE `fletero`
  MODIFY `idFletero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `idServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `idVehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fletero`
--
ALTER TABLE `fletero`
  ADD CONSTRAINT `fletero_ibfk_2` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicio_ibfk_2` FOREIGN KEY (`idFletero`) REFERENCES `fletero` (`idFletero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`idFletero`) REFERENCES `fletero` (`idFletero`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
