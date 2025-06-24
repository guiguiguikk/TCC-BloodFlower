-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 24-Jun-2025 às 11:48
-- Versão do servidor: 8.0.27
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bloodflower`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id_carrinho` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id_carrinho`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `carrinhos`
--

INSERT INTO `carrinhos` (`id_carrinho`, `usuario_id`) VALUES
(9, 3),
(2, 6),
(3, 7),
(4, 8),
(5, 10),
(6, 11),
(7, 12),
(10, 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id_endereco` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rua` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cidade` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `usuario_id`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`) VALUES
(1, 12, '69375395', 'presidente', '4406', 'centro', 'uruguaiana', 'RS'),
(2, 13, '97503710', 'albertino pires', '4222', 'cabo luiz quevedo', 'uruguaiana', 'RS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE IF NOT EXISTS `favorito` (
  `id_favorito` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id_favorito`),
  KEY `fk_usuario` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_favorito`
--

DROP TABLE IF EXISTS `item_favorito`;
CREATE TABLE IF NOT EXISTS `item_favorito` (
  `id_item_favorito` int NOT NULL AUTO_INCREMENT,
  `favorito_id` int NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id_item_favorito`),
  KEY `fk_produto` (`favorito_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_carrinho`
--

DROP TABLE IF EXISTS `itens_carrinho`;
CREATE TABLE IF NOT EXISTS `itens_carrinho` (
  `id_item_carrinho` int NOT NULL AUTO_INCREMENT,
  `carrinho_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_item_carrinho`),
  KEY `carrinho_id` (`carrinho_id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens_carrinho`
--

INSERT INTO `itens_carrinho` (`id_item_carrinho`, `carrinho_id`, `produto_id`, `quantidade`) VALUES
(3, 2, 1, 1),
(4, 3, 1, 1),
(5, 3, 7, 1),
(6, 4, 6, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_pedido`
--

DROP TABLE IF EXISTS `itens_pedido`;
CREATE TABLE IF NOT EXISTS `itens_pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_produto` (`id_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `id_pedido`, `id_produto`, `quantidade`, `preco`, `subtotal`) VALUES
(1, 2, 24, 90, '89.90', '8091.00'),
(2, 2, 25, 90909, '149.90', '13627259.10'),
(3, 2, 26, 1, '59.90', '59.90'),
(4, 2, 27, 1, '199.90', '199.90'),
(5, 3, 26, 1, '59.90', '59.90'),
(6, 4, 26, 10, '59.90', '599.00'),
(7, 4, 27, 7, '199.90', '1399.30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `id_marca` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `marca`
--

INSERT INTO `marca` (`id_marca`, `nome`) VALUES
(1, 'camiseta'),
(2, 'calca'),
(3, 'moletom'),
(4, 'acessorio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `metodo_pagamento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pendente','aprovado','rejeitado') COLLATE utf8mb4_general_ci DEFAULT 'pendente',
  `data_pagamento` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pendente','pago','cancelado') COLLATE utf8mb4_general_ci DEFAULT 'pendente',
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `data_pedido`, `status`, `total`) VALUES
(1, 3, '2025-05-27 16:43:32', 'pendente', '89.90'),
(2, 3, '2025-05-27 16:47:03', 'pendente', '13635609.90'),
(3, 13, '2025-06-18 13:42:00', 'pendente', '59.90'),
(4, 3, '2025-06-22 22:25:01', 'pendente', '1998.30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `preco` decimal(10,2) NOT NULL,
  `preco_desconto` decimal(10,2) DEFAULT NULL,
  `estoque` int DEFAULT '0',
  `categoria_id` int DEFAULT NULL,
  `marca_id` int DEFAULT NULL,
  `imagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `marca_id` (`marca_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `preco_desconto`, `estoque`, `categoria_id`, `marca_id`, `imagem`) VALUES
(27, 'Jaqueta Corta Vento Reflective', 'Jaqueta leve com tecido refletivo e zíper frontal, resistente ao vento.', '199.90', '179.90', 20, 4, 3, 'cortavento.jpeg'),
(26, 'Boné Street Style Preto', 'Boné ajustável com bordado frontal e aba curva.', '59.90', NULL, 80, 3, 2, 'bone.jpeg'),
(25, 'Calça Cargo Caqui', 'Calça cargo masculina com bolsos utilitários e elástico na barra.', '149.90', '129.90', 30, 2, 1, 'Calça-Cargo-Sarja.jpeg'),
(24, 'Camiseta Oversized Preta', 'Camiseta unissex em algodão premium com modelagem oversized.', '89.90', '69.90', 50, 1, 4, 'Camiseta-Oversized-Preto.jpeg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `tipo_usuario` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `cpf`, `telefone`, `data_nascimento`, `tipo_usuario`) VALUES
(6, 'ariel', 'ariel@gmail.com', '$2y$10$vfpS1/O/wp55xUnSG9keLO0QJmlPEkZLEIJudP62TGGGS7/r2paTW', '43689567', '305948595734', '2000-09-16', 0),
(3, 'thiago', 'thiago@gmail.com', '$2y$10$t8jdbZDRDPw9XBxRzFKbweGImvmPZGCf4hK5hkhKD5R1Bo2SlFy3m', '5438934639659', '5458253485394', '2000-01-01', 0),
(4, 'guizao', 'gui@email.com', '$2y$10$r3u4sH4uib0XfSt85ZpnsOCjCYkskCJd90k9bDWHnm18aUi3jKSji', '235346564', '2353465645', '2000-11-11', 1),
(7, 'Nader Iad Choli', 'nader.2023319952@aluno.iffar.edu.br', '$2y$10$v6oTzIdBW8Z9l/dMLLMSqug5r3uom65mM452GnYqzyuCAupI8GxOC', '05808500052', '55999983729', '2007-09-12', 0),
(8, 'Jorge Gomes de Lima', 'jorge@gmail.com', '$2y$10$9DFJbYDtaQbq0xwZVQB5q.dAJN6b6mM8D6LTu6b.NMZo.nndQLnY6', '05790502032', '6969696969', '2025-05-02', 0),
(9, 'Fafas', 'abertolf@gmail.com', '$2y$10$lu5n.IgQ1.NGCrUnszCUue0b1btXEV6Iqr689RJ6PVr8VvCWDxa1S', '123456789787', '1234567891011', '2006-08-06', 0),
(10, 'guileme', 'pedro@gmail.com', '$2y$10$XaQI7cJaAE6kTEGZ9zLhiOaRQbqmvtrJORTO2VPR3N291mmSPavYi', '54353654', '41352352', '2010-10-10', 0),
(11, 'guileme', 'jonas@gmail.com', '$2y$10$DSnk4kI5LpNt4V0aP2/L.Ozwjy5F4Xqo7BoHSmFnaMD.Ka2kbqoTG', '5346903525923', '450634506', '2000-09-09', 0),
(12, 'vic', 'vic@gmail.com', '$2y$10$q1hpL6HPtlIeNFVWqwL16uVG4RTsjNv1LsSB9A3sL8hgrUTBtR2MC', '436984563845', '3595467434', '2011-11-11', 0),
(13, 'Paulo Juarez Nunes Camoretto Neto', 'paulo.2022310836@aluno.iffar.edu.br', '$2y$10$36P9kzlAmXllDBEwWlLlVOgD3OYPrhanLbHCHclEGa53lBidAWu8C', '04566672026', '55991423225', '2007-02-02', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
