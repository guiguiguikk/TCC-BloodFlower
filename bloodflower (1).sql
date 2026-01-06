-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 06-Jan-2026 às 16:33
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
-- Estrutura da tabela `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id_avaliacao` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `comentario` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `nota` int DEFAULT NULL,
  PRIMARY KEY (`id_avaliacao`),
  KEY `fk_avaliacoes_produto` (`produto_id`),
  KEY `fk_avaliacoes_usuario` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id_carrinho` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id_carrinho`),
  KEY `fk_carrinhos_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `carrinhos`
--

INSERT INTO `carrinhos` (`id_carrinho`, `usuario_id`) VALUES
(9, 3),
(3, 7),
(4, 8),
(5, 10),
(6, 11),
(10, 13),
(11, 14),
(13, 16),
(21, 19),
(27, 20),
(24, 21),
(25, 21),
(28, 22),
(29, 22),
(30, 23),
(31, 23),
(32, 24),
(33, 25),
(34, 25),
(35, 26),
(36, 26),
(37, 27),
(38, 27),
(39, 28),
(40, 28);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome`) VALUES
(1, 'camiseta'),
(2, 'calça'),
(3, 'moletom'),
(4, 'Jaqueta'),
(5, 'Vestido'),
(6, 'Saia'),
(7, 'Tênis'),
(8, 'Boné'),
(9, 'Acessórios'),
(10, 'Top'),
(11, 'Moletom Oversized'),
(12, 'Blusa de Manga Longa'),
(13, 'Colete'),
(14, 'Bermuda'),
(15, 'Bolsa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id_endereco` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `cep` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rua` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cidade` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `usuario_id`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `tipo`) VALUES
(6, 18, '97503710', 'Rua Albertino Pires', '1001', 'Cabo Luís Quevedo', 'Uruguaiana', 'RS', ''),
(8, 20, '97503710', 'Rua Albertino Pires', '4222', 'Cabo Luís Quevedo', 'Uruguaiana', 'RS', ''),
(10, 23, '97503740', 'Rua Roberto Kraemer', '6', 'Cabo Luís Quevedo', 'Uruguaiana', 'RS', ''),
(12, 23, '88330116', 'Avenida Marginal Leste', '096', 'Centro', 'Balneário Camboriú', 'SC', ''),
(13, 23, '97501760', 'Avenida Presidente Getúlio Vargas', '2190', 'Bela Vista', 'Uruguaiana', 'RS', ''),
(14, 23, '97503740', 'Rua Roberto Kraemer', '6', 'Cabo Luís Quevedo', 'Uruguaiana', 'RS', ''),
(18, 26, '97538000', 'Monteiro Lobato', '40', 'Centro', 'Barra do Quaraí', 'RS', ''),
(19, 24, '97504800', 'Rua Monteiro Lobato', '0107', 'Tabajara Brites', 'Uruguaiana', 'RS', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE IF NOT EXISTS `favorito` (
  `id_favorito` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id_favorito`),
  KEY `fk_favorito_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `favorito`
--

INSERT INTO `favorito` (`id_favorito`, `usuario_id`) VALUES
(1, 3),
(2, 16),
(3, 17),
(4, 18),
(5, 20),
(6, 21),
(7, 22),
(8, 23),
(10, 24),
(9, 25),
(11, 26),
(12, 27),
(13, 28);

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
  KEY `fk_item_favorito_favorito` (`favorito_id`),
  KEY `fk_item_favorito_produto` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `tamanho` int NOT NULL,
  PRIMARY KEY (`id_item_carrinho`),
  KEY `fk_itens_carrinho_carrinho` (`carrinho_id`),
  KEY `fk_itens_carrinho_produto` (`produto_id`),
  KEY `fk_tamanho` (`tamanho`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `tamanho` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_itens_pedido_produto` (`id_produto`),
  KEY `fk_tamanho_pedido` (`tamanho`),
  KEY `fk_itens_pedido_pedido` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `id_marca` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `marca`
--

INSERT INTO `marca` (`id_marca`, `nome`) VALUES
(2, 'nike'),
(3, 'adidas'),
(4, 'acessorio'),
(5, 'Converse'),
(6, 'Urban Edge'),
(7, 'Black Flower'),
(8, 'Rebel Wear'),
(9, 'Alternative Style'),
(10, 'Dark Threads'),
(11, 'Gothic Roots'),
(12, 'Skull & Roses'),
(13, 'Vans');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `metodo_pagamento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pago','Parecelado','Cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pago',
  `data_pagamento` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pagamentos_pedido` (`id_pedido`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `id_pedido`, `metodo_pagamento`, `status`, `data_pagamento`) VALUES
(1, 13, 'Cartão', '', '2025-08-06 13:47:01'),
(2, 14, 'Cartão', '', '2025-08-06 13:50:28'),
(3, 15, 'Cartão', '', '2025-08-06 14:54:58'),
(4, 16, 'Cartão', '', '2025-08-06 15:05:13'),
(5, 17, 'Pix', '', '2025-08-06 15:18:24'),
(6, 18, 'Cartão', 'Pago', '2025-08-07 01:07:21'),
(7, 19, 'Cartão', 'Pago', '2025-08-10 20:51:36'),
(8, 20, 'Cartão', 'Pago', '2025-08-13 08:16:35'),
(9, 21, 'Pix', 'Pago', '2025-08-13 10:57:33'),
(10, 22, 'Cartão', 'Pago', '2025-08-13 13:03:54'),
(11, 23, 'Cartão', 'Pago', '2025-08-13 13:45:11'),
(12, 24, 'Cartão', 'Pago', '2025-08-19 12:10:16'),
(13, 25, 'Cartão', 'Pago', '2025-09-09 16:47:15'),
(14, 26, 'Pix', 'Pago', '2025-10-19 13:17:15'),
(15, 27, 'cartao', 'Pago', '2025-10-24 10:46:10'),
(16, 28, 'cartao', 'Pago', '2025-10-24 10:47:39'),
(17, 29, 'cartao', 'Pago', '2025-10-24 14:47:01'),
(18, 30, 'cartao', 'Pago', '2025-10-24 15:41:40'),
(19, 31, 'cartao', 'Pago', '2025-10-24 15:43:57'),
(20, 32, 'pix', 'Pago', '2025-12-05 22:37:28'),
(21, 33, 'pix', 'Pago', '2025-12-05 22:40:53'),
(22, 34, 'pix', 'Pago', '2025-12-05 22:41:12'),
(23, 35, 'pix', 'Pago', '2025-12-09 10:06:49'),
(24, 36, 'pix', 'Pago', '2025-12-09 10:10:32'),
(25, 37, 'pix', 'Pago', '2025-12-09 10:11:39'),
(26, 38, 'pix', 'Pago', '2025-12-09 10:11:58'),
(27, 39, 'boleto', 'Pago', '2025-12-09 10:23:27'),
(28, 40, 'boleto', 'Pago', '2025-12-09 10:28:41'),
(29, 41, 'boleto', 'Pago', '2025-12-09 10:30:55'),
(30, 42, 'boleto', 'Pago', '2025-12-09 10:33:53'),
(31, 43, 'boleto', 'Pago', '2025-12-09 10:52:25'),
(32, 44, 'boleto', 'Pago', '2025-12-09 11:06:02'),
(33, 45, 'boleto', 'Pago', '2025-12-09 11:14:10'),
(34, 46, 'pix', 'Pago', '2025-12-09 11:15:31'),
(35, 47, 'boleto', 'Pago', '2025-12-12 14:28:33'),
(36, 48, 'pix', 'Pago', '2025-12-12 14:59:20'),
(37, 49, 'boleto', 'Pago', '2025-12-12 15:03:19'),
(38, 50, 'boleto', 'Pago', '2025-12-12 16:25:00'),
(39, 51, 'pix', 'Pago', '2026-01-05 10:01:39'),
(40, 52, 'pix', 'Pago', '2026-01-05 10:15:02'),
(41, 53, 'pix', 'Pago', '2026-01-05 16:11:23'),
(42, 54, 'pix', 'Pago', '2026-01-05 16:12:45'),
(43, 55, 'pix', 'Pago', '2026-01-05 16:15:12'),
(44, 56, 'pix', 'Pago', '2026-01-05 16:17:46'),
(45, 57, 'pix', 'Pago', '2026-01-05 16:21:21'),
(46, 58, 'boleto', 'Pago', '2026-01-05 19:47:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Aguardando','Enviado','Entregue','Cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Aguardando',
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `data_pedido`, `status`, `total`) VALUES
(10, 3, '2025-08-03 12:47:26', '', '8994.00'),
(11, 17, '2025-08-06 01:09:58', 'Enviado', '10.00'),
(12, 17, '2025-08-06 01:13:08', '', '239.80'),
(13, 17, '2025-08-06 13:47:01', '', '1070.90'),
(14, 17, '2025-08-06 13:50:28', 'Entregue', '89.90'),
(15, 17, '2025-08-06 14:54:58', 'Aguardando', '98.09'),
(16, 17, '2025-08-06 15:05:13', 'Aguardando', '239.80'),
(17, 17, '2025-08-06 15:18:24', 'Aguardando', '89.90'),
(18, 18, '2025-08-07 01:07:21', 'Aguardando', '89.90'),
(19, 18, '2025-08-10 20:51:36', 'Aguardando', '2998.00'),
(20, 20, '2025-08-13 08:16:35', 'Aguardando', '686.63'),
(21, 20, '2025-08-13 10:57:33', 'Aguardando', '98.09'),
(22, 20, '2025-08-13 13:03:53', 'Aguardando', '89.90'),
(23, 20, '2025-08-13 13:45:11', 'Aguardando', '247.99'),
(24, 20, '2025-08-19 12:10:16', 'Aguardando', '909.00'),
(25, 22, '2025-09-09 16:47:15', 'Entregue', '89.90'),
(26, 23, '2025-10-19 13:17:15', 'Entregue', '98.09'),
(27, 23, '2025-10-24 10:46:10', 'Aguardando', '98.09'),
(28, 23, '2025-10-24 10:47:39', 'Aguardando', '199.80'),
(29, 23, '2025-10-24 14:47:01', 'Aguardando', '493.79'),
(30, 23, '2025-10-24 15:41:40', 'Aguardando', '89.90'),
(31, 23, '2025-10-24 15:43:57', 'Aguardando', '119.90'),
(32, 24, '2025-12-05 22:37:28', 'Aguardando', '239.80'),
(33, 24, '2025-12-05 22:40:53', 'Aguardando', '159.90'),
(34, 24, '2025-12-05 22:41:12', 'Entregue', '129.90'),
(35, 24, '2025-12-09 10:06:49', 'Aguardando', '100.00'),
(36, 24, '2025-12-09 10:10:32', 'Aguardando', '100.00'),
(37, 24, '2025-12-09 10:11:39', 'Aguardando', '129.90'),
(38, 24, '2025-12-09 10:11:58', 'Aguardando', '129.90'),
(39, 24, '2025-12-09 10:23:27', 'Aguardando', '229.80'),
(40, 24, '2025-12-09 10:28:41', 'Aguardando', '129.90'),
(41, 24, '2025-12-09 10:30:55', 'Aguardando', '129.90'),
(42, 24, '2025-12-09 10:33:53', 'Aguardando', '129.90'),
(43, 26, '2025-12-09 10:52:25', 'Aguardando', '369.70'),
(44, 26, '2025-12-09 11:06:02', 'Aguardando', '129.90'),
(45, 26, '2025-12-09 11:14:10', 'Aguardando', '159.90'),
(46, 26, '2025-12-09 11:15:31', 'Aguardando', '99.90'),
(47, 24, '2025-12-12 14:28:33', 'Aguardando', '599.40'),
(48, 24, '2025-12-12 14:59:20', 'Aguardando', '10000.00'),
(49, 24, '2025-12-12 15:03:19', 'Aguardando', '169.90'),
(50, 24, '2025-12-12 16:25:00', 'Aguardando', '159.90'),
(51, 24, '2026-01-05 10:01:39', 'Aguardando', '1200.00'),
(52, 24, '2026-01-05 10:15:02', 'Aguardando', '69.90'),
(53, 24, '2026-01-05 16:11:23', 'Aguardando', '317.89'),
(54, 24, '2026-01-05 16:12:45', 'Aguardando', '10000.00'),
(55, 24, '2026-01-05 16:15:12', 'Aguardando', '198.09'),
(56, 24, '2026-01-05 16:17:46', 'Entregue', '6669.90'),
(57, 24, '2026-01-05 16:21:21', 'Entregue', '18059.60'),
(58, 24, '2026-01-05 19:47:58', 'Aguardando', '69.90');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `preco` decimal(10,2) NOT NULL,
  `preco_desconto` decimal(10,2) DEFAULT NULL,
  `estoque` int DEFAULT '0',
  `categoria_id` int DEFAULT NULL,
  `marca_id` int DEFAULT NULL,
  `imagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produtos_categoria` (`categoria_id`),
  KEY `fk_produtos_marca` (`marca_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `preco_desconto`, `estoque`, `categoria_id`, `marca_id`, `imagem`) VALUES
(2, 'Moletom Rebel', 'Moletom cinza com capuz e bordado da marca Rebel Wear.', '159.90', '149.90', 0, 3, 7, 'moletom-rebel.jpg'),
(3, 'Calça Urban Edge', 'Calça jogger preta com detalhes cinza da Urban Edge.', '129.90', '119.90', 0, 2, 6, 'calca-urban-edge.jpg'),
(4, 'Camiseta Gothic Rose', 'Camiseta com estampa de rosas góticas.', '99.90', '89.90', 0, 1, 11, 'camiseta-gothic-rose.jpg'),
(5, 'Moletom Skull & Bones', 'Moletom preto com estampa de caveira estilizada.', '169.90', '159.90', 0, 3, 12, 'moletom-skull-bones.jpg'),
(6, 'Calça Vans Street', 'Calça estilo streetwear com logo da Vans.', '119.90', '109.90', 0, 2, 4, 'calca-vans-street.jpg'),
(7, 'Camiseta Converse All Star', 'Camiseta branca com logo clássico da Converse.', '89.90', '79.90', 0, 1, 5, 'camiseta-converse.jpg'),
(8, 'Moletom Black Flower', 'Moletom preto oversized da marca Black Flower.', '159.90', '149.90', 0, 3, 8, 'moletom-black-flower.jpg'),
(9, 'Calça Dark Threads Jogger', 'Calça jogger preta com detalhes vermelhos.', '139.90', '129.90', 0, 2, 10, 'calca-dark-threads.jpg'),
(10, 'Camiseta Rebel Wear Logo', 'Camiseta cinza com logo Rebel Wear estampado.', '95.90', '85.90', 0, 1, 7, 'camiseta-rebel-logo.jpg'),
(11, 'Moletom Alternative Style Hoodie', 'Moletom cinza com capuz da Alternative Style.', '149.90', '139.90', 0, 3, 9, 'moletom-alternative-style.jpg'),
(12, 'Calça Adidas Street', 'Calça preta com listras brancas clássicas Adidas.', '129.90', '119.90', 0, 2, 3, 'calca-adidas-street.jpg'),
(13, 'Camiseta Nike Urban', 'Camiseta preta com logo minimalista Nike.', '99.90', '89.90', 0, 1, 2, 'camiseta-nike-urban.jpg'),
(14, 'Moletom Vans Capuz', 'Moletom cinza com capuz da Vans.', '159.90', '149.90', 0, 3, 4, 'moletom-vans.jpg'),
(24, 'Camiseta Oversized Preta', 'Camiseta unissex em algodão premium com modelagem oversized.', '89.90', '69.90', 50, 1, 4, 'Camiseta-Oversized-Preto.jpeg'),
(25, 'Calça Cargo Caqui', 'Calça cargo masculina com bolsos utilitários e elástico na barra.', '149.90', '129.90', 30, 2, 2, 'Calça-Cargo-Sarja.jpeg'),
(27, 'Jaqueta Corta Vento Reflective', 'Jaqueta leve com tecido refletivo e zíper frontal, resistente ao vento.', '98.09', '179.90', 20, 1, 3, 'cortavento.jpeg'),
(30, 'Boina', 'Boina Chapéu Cinza Italiana Masculina', '10.00', '10.00', 10, 3, 3, 'Boina Chapéu Italiana Masculina Estilo Peaky Blinders.jpeg'),
(32, 'camisa', 'camisa branca', '100.00', '0.00', 100, 1, 3, 'camisa.jpeg'),
(34, 'luva de pedreiro', 'perceba', '10000.00', '0.00', 0, 1, 7, 'perceba.jpg'),
(36, 'guilherme', 'camisa', '900.00', '899.00', 0, 14, 12, 'WIN_20251031_13_58_47_Pro.jpg'),
(37, 'gui', '500', '600.00', '0.00', 0, 13, 12, 'WIN_20251031_13_58_47_Pro.jpg'),
(38, 'guilherme000', '700', '600.00', '599.00', 0, 13, 11, 'WIN_20251031_13_58_47_Pro.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_tamanhos`
--

DROP TABLE IF EXISTS `produto_tamanhos`;
CREATE TABLE IF NOT EXISTS `produto_tamanhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `tamanho_id` int NOT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produto_tamanhos_produto` (`produto_id`),
  KEY `fk_produto_tamanhos_tamanho` (`tamanho_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tamanhos`
--

DROP TABLE IF EXISTS `tamanhos`;
CREATE TABLE IF NOT EXISTS `tamanhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tamanhos`
--

INSERT INTO `tamanhos` (`id`, `nome`) VALUES
(1, 'P'),
(2, 'M'),
(3, 'G'),
(4, 'GG');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `tipo_usuario` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `cpf`, `telefone`, `data_nascimento`, `tipo_usuario`) VALUES
(3, 'thiago', 'thiago@gmail.com', '$2y$10$t8jdbZDRDPw9XBxRzFKbweGImvmPZGCf4hK5hkhKD5R1Bo2SlFy3m', '5438934639659', '5458253485394', '2000-01-01', 0),
(4, 'guizao', 'gui@email.com', '$2y$10$r3u4sH4uib0XfSt85ZpnsOCjCYkskCJd90k9bDWHnm18aUi3jKSji', '235346564', '2353465645', '2000-11-11', 1),
(7, 'Nader Iad Choli', 'nader.2023319952@aluno.iffar.edu.br', '$2y$10$v6oTzIdBW8Z9l/dMLLMSqug5r3uom65mM452GnYqzyuCAupI8GxOC', '05808500052', '55999983729', '2007-09-12', 0),
(8, 'Jorge Gomes de Lima', 'jorge@gmail.com', '$2y$10$9DFJbYDtaQbq0xwZVQB5q.dAJN6b6mM8D6LTu6b.NMZo.nndQLnY6', '05790502032', '6969696969', '2025-05-02', 0),
(9, 'Fafas', 'abertolf@gmail.com', '$2y$10$lu5n.IgQ1.NGCrUnszCUue0b1btXEV6Iqr689RJ6PVr8VvCWDxa1S', '123456789787', '1234567891011', '2006-08-06', 0),
(10, 'guileme', 'pedro@gmail.com', '$2y$10$XaQI7cJaAE6kTEGZ9zLhiOaRQbqmvtrJORTO2VPR3N291mmSPavYi', '54353654', '41352352', '2010-10-10', 0),
(11, 'guileme', 'jonas@gmail.com', '$2y$10$DSnk4kI5LpNt4V0aP2/L.Ozwjy5F4Xqo7BoHSmFnaMD.Ka2kbqoTG', '5346903525923', '450634506', '2000-09-09', 0),
(13, 'Paulo ', 'paulo.202231036@aluno.iffar.edu.br', '$2y$10$36P9kzlAmXllDBEwWlLlVOgD3OYPrhanLbHCHclEGa53lBidAWu8C', '04566672026', '55991423225', '2007-02-02', 0),
(14, 'dimitri fernandes', 'dimitri.2023317573@aluno.iffar.edu.br', '$2y$10$QF1wAzimNTZvS2nKLzh/nOBYcFcO3ZfWCooub64DLmQoa6DUKt91W', '32342424242424', '2342424242424', '2025-07-25', 0),
(16, 'camiesta cinza', 'darksity09@gmail.com', '$2y$10$W.b0S4U9ie.NDC0CsZnB0OF8XcuJknJ0ggxjBfzzZqP3i0xBr0K2.', '03713500002', '559998982313', '2025-08-07', 0),
(17, 'oguileme', 'guilherme@gmail.com', '$2y$10$OB3uxvWEJHUJ1t745PQekescfAMWe8NGaDsr8bu0lr/6bzYPujF6i', '12345678912', '6969696969', '2001-10-10', 1),
(18, 'victoriaa', 'vic3@gmail.com', '$2y$10$Z5euwQeMjukSTv9sOonTA.zQyju3UTN5sb1c0dcKAOf.GMepddzpe', '12345678977', '305948595734', '2000-10-10', 0),
(19, 'jorge', 'jorge1@gmail.com', '$2y$10$7n7ro4ywGzvDLI.4ex7vguivmk5YpupQprwEapK1xtw673awe.JaG', '1234567890', '559998982313', '2000-08-11', 0),
(20, 'asddevfgf', 'guilherme1@gmail.com', '$2y$10$gjtcFwI8dnszh41d0gBam.iCt2uZ.Lp8Vz8z8h70QE6dWZcjxmCCm', '12345678919', '6969696968', '2011-11-11', 1),
(21, 'paulo', 'paulo@gmail.com', '$2y$10$y9NKVMXuQl/3hkCERYB1JO6DNwAnfuCeJ/UunTD3y1CMFisvycbyK', '12345678905', '9999999999', '2007-02-02', 0),
(22, 'aaaa', 'guilherme12@gmail.com', '$2y$10$NfsDpkOOz/m9CIaoRXFKt.5ooqw6isA6KBiWasc3E.XxvZmNtVUW.', '00000000001', '2232342423', '2000-12-12', 0),
(23, 'guilherme moreira', 'gui.moreira@gmail.com', '$2y$10$oTr87IAlt0c/h3fq8bs5GePRcJFeGtYjkkwtj0HW/cETRZtTCdjMa', '0987654321', '77777777777', '2000-12-12', 0),
(24, 'jeferson junior', 'jeferson@gmail.com', '$2y$10$4oQShpfWKfuWSzZPi19iMOvAN8XYhL.qM24Uiy7D.KNF/J3/.1Wre', '60197119000', '55984272911', '2006-12-08', 0),
(25, 'guilherme teste', 'guilherme.2021321666@aluno.iffar.edu.br', '$2y$10$zH.FOO/l0hix3JpkaWfDw.fDxQKaJYL5iZWUO9V9nm.Vpf83GD4rm', '12345678914', '5598071212', '2006-03-14', 0),
(26, 'nader choli', 'nader@gmail.com', '$2y$10$/pDwfaQbC28gH1WbCVtUZ.xMVYWl.Nipq0JQljvSXbcMD.VUPe6jy', '00010000001', '12345679', '2007-09-12', 0),
(27, 'aaaaa', 'eduardo.2023318418@aluno.iffar.edu.br', '$2y$10$mwzQSTsuEQFEGhn5.DyBJ.ODiGs77K6cKqy9/FQtuEkpb6F0XUoHS', '391423972954', '32235872542', '2025-12-03', 0),
(28, 'Melina Mörschbächer', 'melina.morschbacher@gmail.com', '$2y$10$b655lT3hRD0wtlcb4oYMtOoaTlJ7/k9kBWWupMtuagM5HaFJvpzwS', '00000000000', '51991476110', '1989-08-19', 0);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD CONSTRAINT `fk_carrinhos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `fk_favorito_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `item_favorito`
--
ALTER TABLE `item_favorito`
  ADD CONSTRAINT `fk_item_favorito_favorito` FOREIGN KEY (`favorito_id`) REFERENCES `favorito` (`id_favorito`),
  ADD CONSTRAINT `fk_item_favorito_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  ADD CONSTRAINT `fk_itens_carrinho_carrinho` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinhos` (`id_carrinho`),
  ADD CONSTRAINT `fk_itens_carrinho_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_tamanho` FOREIGN KEY (`tamanho`) REFERENCES `tamanhos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_itens_pedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itens_pedido_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_tamanho_pedido` FOREIGN KEY (`tamanho`) REFERENCES `tamanhos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `fk_pagamentos_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `fk_produtos_marca` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id_marca`);

--
-- Limitadores para a tabela `produto_tamanhos`
--
ALTER TABLE `produto_tamanhos`
  ADD CONSTRAINT `fk_produto_tamanhos_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_produto_tamanhos_tamanho` FOREIGN KEY (`tamanho_id`) REFERENCES `tamanhos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
