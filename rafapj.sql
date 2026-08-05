-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Ago-2026 às 22:32
-- Versão do servidor: 8.0.29
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rafapj`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `hora_triagem` time DEFAULT NULL,
  `historico` text,
  `medicamentos` text,
  `alergias` text,
  `pressao` varchar(20) DEFAULT NULL,
  `temperatura` varchar(10) DEFAULT NULL,
  `frequencia` int DEFAULT NULL,
  `saturacao` varchar(10) DEFAULT NULL,
  `dor` int DEFAULT NULL,
  `risco` varchar(20) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_triagem` date DEFAULT NULL,
  `queixa_principal` text,
  `sintomas` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `nome`, `data_nascimento`, `hora_triagem`, `historico`, `medicamentos`, `alergias`, `pressao`, `temperatura`, `frequencia`, `saturacao`, `dor`, `risco`, `criado_em`, `data_triagem`, `queixa_principal`, `sintomas`) VALUES
(1, 'Rafael Felipe', '2008-11-04', '23:15:00', 'wadsawd', 'sadasda', 'wadad', '120x80', '36.5', 80, '98%', 5, 'Vermelho', '2026-08-05 20:22:37', '2025-09-04', 'Dor de cabeça', 'Muita dor de cabeça'),
(2, 'Manu', '2009-11-04', '22:23:00', 'awdasd', 'adwawsd', 'dwasd', '120x80', '36.5', 80, '98%', 5, 'Verde', '2026-08-05 20:24:47', '2025-08-05', 'Dor de cabeça', 'Dor de cabeça'),
(3, 'andoiahjdoi', '2007-06-05', '22:27:00', 'dawdad', 'adwswad', 'wadadw', '120', '37', 80, '98%', 2, 'Laranja', '2026-08-05 20:27:55', '2026-08-05', 'amwdskmajkdij', 'awdad'),
(4, 'Giovana Sed', '2008-06-04', '22:29:00', 'dasdwa', 'dsaxawd', 'asdwad', '120', '37', 80, '30%', 6, 'Amarelo', '2026-08-05 20:30:08', '2026-08-05', 'wadad', 'asdads');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(3, 'Rafael Felipe', 'prestes.rafael75@gmail.com', '$2y$10$A1kzyPq0oHipcUA2dYA7vugD5XgukJSokQIqdke4c396JxC22Xuwq', '2026-08-05 19:49:29'),
(4, 'Manuzinha', 'manu@gmail.com', '$2y$10$trEraobbOILVHMds.QjkSuFsIXL.aP5/X0YqIUu6dSVsz3hEJ1C5q', '2026-08-05 20:23:27'),
(5, 'Giovana Sed', 'gio@gmail.com', '$2y$10$W7KAeqgKuPjH5jOn8tU7GunpsVlv7kDapQJcFklz3KnW4AtSSS4nq', '2026-08-05 20:29:22');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
