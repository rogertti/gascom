-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2017 at 07:04 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gascom`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` bigint(20) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `monitor` char(1) NOT NULL COMMENT 'T ou F;'
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `descricao`, `monitor`) VALUES
(1, 'Outros Gastos', 'T'),
(2, 'Remuneração', 'T'),
(3, 'Rendimento', 'T'),
(4, 'Casa', 'T'),
(5, 'Compras', 'T'),
(6, 'Contas', 'T'),
(7, 'Educação', 'T'),
(8, 'Impostos', 'T'),
(9, 'Poupança', 'T'),
(10, 'Lazer', 'T'),
(11, 'Mercado', 'T'),
(12, 'Outras Rendas', 'T'),
(13, 'Restaurante', 'T'),
(14, 'Saúde', 'T'),
(15, 'Serviços', 'T'),
(16, 'Transporte', 'T'),
(17, 'Viagem', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `lancamento`
--

CREATE TABLE `lancamento` (
  `idlancamento` bigint(20) NOT NULL,
  `categoria_idcategoria` bigint(20) NOT NULL,
  `dia` varchar(2) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `tipo` char(1) NOT NULL COMMENT 'E = entrada; S = saida;',
  `descricao` varchar(150) NOT NULL,
  `valor` decimal(15,2) NOT NULL,
  `pago` char(1) NOT NULL COMMENT 'T ou F;',
  `monitor` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `idlogin` bigint(20) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `monitor` char(1) NOT NULL COMMENT 'T ou F;'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indexes for table `lancamento`
--
ALTER TABLE `lancamento`
  ADD PRIMARY KEY (`idlancamento`),
  ADD KEY `fk_lancamento_categoria_idx` (`categoria_idcategoria`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idlogin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `lancamento`
--
ALTER TABLE `lancamento`
  MODIFY `idlancamento` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `idlogin` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
