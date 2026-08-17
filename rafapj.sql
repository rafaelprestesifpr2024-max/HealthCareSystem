-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/08/2026 às 02:40
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

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
-- Estrutura para tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `nome_paciente` varchar(150) NOT NULL,
  `email_paciente` varchar(150) NOT NULL,
  `telefone_paciente` varchar(30) NOT NULL,
  `endereco_paciente` varchar(255) NOT NULL,
  `especialidade` varchar(100) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `problema` text NOT NULL,
  `objetivo` varchar(100) NOT NULL,
  `observacoes` text DEFAULT NULL,
  `data_consulta` date NOT NULL,
  `hora_consulta` time NOT NULL,
  `status` enum('agendada','cancelada','concluida') NOT NULL DEFAULT 'agendada',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `consultas`
--

INSERT INTO `consultas` (`id`, `nome_paciente`, `email_paciente`, `telefone_paciente`, `endereco_paciente`, `especialidade`, `motivo`, `problema`, `objetivo`, `observacoes`, `data_consulta`, `hora_consulta`, `status`, `criado_em`) VALUES
(1, 'Rafael Felipe Prestes', 'adrianprestes7@gmail.com', '6546545665r', 'hg,jg,ygygyg', 'Odontologia', 'fkygkuyg', 'buygkugyky', 'Retorno', 'mjgmygkuy', '2026-08-17', '14:00:00', 'agendada', '2026-08-17 00:19:51');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `hora_triagem` time DEFAULT NULL,
  `historico` text DEFAULT NULL,
  `medicamentos` text DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `pressao` varchar(20) DEFAULT NULL,
  `temperatura` varchar(10) DEFAULT NULL,
  `frequencia` int(11) DEFAULT NULL,
  `saturacao` varchar(10) DEFAULT NULL,
  `dor` int(11) DEFAULT NULL,
  `risco` varchar(20) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp(),
  `data_triagem` date DEFAULT NULL,
  `queixa_principal` text DEFAULT NULL,
  `sintomas` text DEFAULT NULL,
  `exibir` tinyint(1) NOT NULL DEFAULT 1,
  `gestante` tinyint(1) DEFAULT 0,
  `imunossuprimido` tinyint(1) DEFAULT 0,
  `cronico` tinyint(1) DEFAULT 0,
  `consciencia` varchar(20) DEFAULT 'normal',
  `hemorragia` tinyint(1) DEFAULT 0,
  `trauma` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `nome`, `data_nascimento`, `hora_triagem`, `historico`, `medicamentos`, `alergias`, `pressao`, `temperatura`, `frequencia`, `saturacao`, `dor`, `risco`, `criado_em`, `data_triagem`, `queixa_principal`, `sintomas`, `exibir`, `gestante`, `imunossuprimido`, `cronico`, `consciencia`, `hemorragia`, `trauma`) VALUES
(1, 'Pedro Gabriel Prestes', '2006-11-04', '01:26:00', 'Asmático, já foi internado por possuir crises respitratória', 'Aerolin', 'Alergia ocular crônica', '140x80', '39', 91, '80', 9, 'Vermelho', '2026-08-16 23:28:25', '2026-08-17', 'Dor forte de cabeça', 'Dor forte de cabeça que induz ao desmaio', 1, 0, 0, 0, 'normal', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(1, 'Rafael Felipe', 'rafael@hospital.com', '$2y$10$MyckpXjHkG5rkzvg6SMYIeYsljumxVz7EfFqXiTpgW07W6rJyEY3m', '2026-08-16 23:26:32'),
(2, 'Rafael Felipe', 'rafael@gmail.com', '$2y$10$IyqvpF9F3ChVgrZpXDdRxuzqu6NkNs/RFhsTBNhm2V9F4wBl4Za7q', '2026-08-16 23:32:36');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_data_hora` (`data_consulta`,`hora_consulta`),
  ADD KEY `idx_status` (`status`);

--
-- Índices de tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
