-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Jul-2022 às 16:45
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sisfaibd`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `inserir_aluno` (`ra` BIGINT, `statusa` TINYINT, `email` VARCHAR(100), `fone` BIGINT, `nome` VARCHAR(50), `tipoUsuario` INT, `semestre` INT, `senha` VARCHAR(255), `curso` INT)   BEGIN
 DECLARE raAluno bigint;
    SET raAluno = (SELECT ra_aluno FROM aluno where ra_aluno=ra);
IF(raAluno>0)
THEN
UPDATE aluno SET semestre=semestre where ra_aluno=ra;
COMMIT;
ELSE
INSERT INTO aluno VALUES (ra, statusa, email, fone, nome, tipoUsuario, semestre, senha, curso);
COMMIT;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inserir_vinculoPTG` (`professor` INT, `aluno` BIGINT, `semestre` INT, `dupla` BIGINT)   BEGIN
 DECLARE cont int;
 DECLARE hae int;
 SET cont = (SELECT count(*) FROM vinculoptg where professor = professor);
 SET cont=cont+1;
 SET hae = (SELECT qtdHAE FROM docente WHERE matricula_docente = professor);
 IF(hae=0)
            THEN
            SELECT "Professor não possui mais horas disponíveis para orientação";
            ROLLBACK;
ELSEIF(cont=5 OR cont=10 OR cont=15 OR cont=20 OR cont=25 OR cont=30)
THEN
UPDATE docente SET qtdHAE=qtdHAE-1 where matricula_docente=professor;
INSERT INTO vinculoptg VALUES (professor,aluno,semestre,dupla);
            COMMIT;
ELSE
INSERT INTO vinculoptg VALUES (professor,aluno,semestre,dupla);
COMMIT;
END IF;
END$$

--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `retornar_nome_dupla` (`ra` BIGINT) RETURNS VARCHAR(50) CHARSET utf8mb4  BEGIN
   RETURN (SELECT a.nome_aluno from aluno a where a.ra_aluno = ra);  
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `ra_aluno` bigint(11) NOT NULL,
  `status_aluno` tinyint(1) DEFAULT NULL,
  `email_aluno` varchar(50) DEFAULT NULL,
  `fone_aluno` bigint(20) DEFAULT NULL,
  `nome_aluno` varchar(50) DEFAULT NULL,
  `tipoUsuario_aluno` int(1) DEFAULT 1,
  `semestre` varchar(20) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`ra_aluno`, `status_aluno`, `email_aluno`, `fone_aluno`, `nome_aluno`, `tipoUsuario_aluno`, `semestre`, `senha`, `id_curso`) VALUES
(145, 1, NULL, NULL, 'TESTE ALUNO N', NULL, '20262', '50336bc687eb161ee9fb0ddb8cf2b7e65bad865f', 5),
(482013045, 1, NULL, NULL, 'SIMONE MENDES DA SILVA', NULL, '20231', '324b1f9b466567347ae4cc7babcb0faf16beb372', 1),
(1050291721002, 1, NULL, NULL, 'HENRIQUE FLORENCE WAGNER CIPRI', NULL, '20231', 'f8f073bf929cb23482dd7746f5ecf02c95611085', 1),
(1050291721022, 1, NULL, NULL, 'MÁRCIO FERRAZ', NULL, '20231', '416dbc879a731ba7684c77790ba2ac27458e465d', 1),
(1050291721033, 1, NULL, NULL, 'WILIAN NATAN DE MORAES QUEIROZ', NULL, '20231', '0aa8540d4c6d9cfe7c90188eab8e83af6654abdb', 1),
(1050481713022, 1, NULL, NULL, 'AMAZILES JOSÉ ANTÔNIO MARTINS ', NULL, '20231', 'fa9891f6b13531141d19f648b54b70bf66825d20', 1),
(1050481713027, 1, NULL, NULL, 'RAFAEL DOS SANTOS FRACASSO', NULL, '20231', '35934693a1e4abe643955241a8df6a7700550e82', 1),
(1050481723046, 1, NULL, NULL, 'IGOR RAIA DE MOURA', NULL, '20231', '88c7df948e3b36f2d7256fd2f87c162aa5cf396a', 1),
(1050481813038, 1, NULL, NULL, 'MARCOS PAULO DA COSTA', NULL, '20231', '3eb07f9ed48aced28330579b62ae7f9583de13fe', 1),
(1050481813048, 1, NULL, NULL, 'ALAN DE JESUS ELIAS DE SOUZA', NULL, '20231', '1b272d56fd07e3866938549a47bb2a4255448584', 1),
(1050481813051, 1, NULL, NULL, 'ANDERSON CESAR DIAS', NULL, '20231', '2f9eac14d515e48632124519c404502d0407a770', 1),
(1050481823024, 1, NULL, NULL, 'FABIO MATHEUS RODRIGUES', NULL, '20231', '953f1b940f5f87073928438b3726bde825f85c85', 1),
(1050481823053, 1, NULL, NULL, 'SIDNEI PEREIRA DE SOUZA', NULL, '20231', '1f0b14f7eff246c532df378fd52d89ae8b4042e0', 1),
(1050481913001, 1, NULL, NULL, 'VÍCTOR RODRIGUES GUIRÁU', NULL, '20231', '60809e7b4de0b29df86ddcc5f77d3a76379a0f9e', 1),
(1050481913004, 1, NULL, NULL, 'LUCAS GIBIM PILOTO', NULL, '20231', '506bfbb22dc02692e32bc4d460deee6c04cb33f4', 1),
(1050481913014, 1, NULL, NULL, 'BRUNO ROVERI BALDINI', NULL, '20231', 'aabadd4a3e3a699ce7a73d83501ebf931c3d060a', 1),
(1050481913023, 1, NULL, NULL, 'LUCAS DOS SANTOS SILVA', NULL, '20231', 'ee4f753e09eddd79e592abd6228b0bdb9aeb6a07', 1),
(1050481913029, 1, NULL, NULL, 'GUSTAVO CARVALHO COUTO', NULL, '20231', 'fd1390735b25df50cc14e1d9b6dd5381555e70f7', 1),
(1050481913048, 1, NULL, NULL, 'LEONARDO KEIJI DE OLIVEIRA BAR', NULL, '20231', 'a86cddae01a6cabe54e629426012c9b963a08aff', 1),
(1050481913049, 1, NULL, NULL, 'BEATRIZ GEIELE DE OLIVEIRA FER', NULL, '20231', 'c50f2372da72887309632857759ad0f5d982576b', 1),
(1050481913051, 1, NULL, NULL, 'LUCAS PINAFI DE ANDRADE', NULL, '20231', 'bc8af092ae0180f77d3ec9e001ae62d2a9348149', 1),
(1050481923007, 1, NULL, NULL, 'ELTON SILVA BUONANI', NULL, '20231', '651f01b2cbc7b63d4dd2c08bf6c608a3ab1d9e4d', 1),
(1050481923009, 1, NULL, NULL, 'LEONARDO GARCIA BOMBASSEI', NULL, '20231', '0647ffa5c723c8996538884d0f89f3a07d71150d', 1),
(1050481923017, 1, NULL, NULL, 'GABRIEL CONTI MACHADO', NULL, '20231', '196cd2253b3e4cb132c859fdb6329185e94edb74', 1),
(1050481923024, 1, NULL, NULL, 'VIVIAN MAGDA SOARES PADIAL MOR', NULL, '20231', '0732eadb13ff18fd4355df119430310fe4c97c3a', 1),
(1050481923029, 1, NULL, NULL, 'JONAS BATISTA DE SOUZA FILHO', NULL, '20231', 'e2a50e65f1f46098d4560cf91917f19f55484f3e', 1),
(1050481923032, 1, NULL, NULL, 'JENIFER DE ALMEIDA SOUZA', NULL, '20231', 'c4eae95a6053d519d9392a42c3621502394f0721', 1),
(1050481923037, 1, NULL, NULL, 'MATEUS VIEIRA BARBOZA FONTES  ', NULL, '20231', '14817948fcb73d0c3fea86fb94bdac953bd6d1df', 1),
(1050481923043, 1, NULL, NULL, 'CAIO VINICIUS DOS SANTOS ROSSI', NULL, '20231', '755d770ad9fbc5789951c359072a589302c70f24', 1),
(1050481923050, 1, NULL, NULL, 'JUAN GUSTAVO DA SILVA', NULL, '20231', '130ba94c0ca5349fdf4bbd563975b54920c91cf0', 1),
(1050482013005, 1, NULL, NULL, 'LUCAS DIAS CALADO', NULL, '20231', 'bd3d9f06e6b8a854a56487348e3e05045bca75ac', 1),
(1050482013006, 1, NULL, NULL, 'WESLEY HENRIQUE FAVERI DE OLIV', NULL, '20231', 'd8a468a694c0fc2fb05c3dcc304cdf11c27364ac', 1),
(1050482013008, 1, NULL, NULL, 'GIULIANA CAMPREGHER MISSIO', NULL, '20231', '742f4ef0a7e4f3963a2efeeec0147081d073f1ca', 1),
(1050482013011, 1, NULL, NULL, 'CAIO VINICIUS ALVES RODRIGUES', NULL, '20231', 'e09f6138ece3ab53ac649a4334cf9dd90aa38db7', 1),
(1050482013015, 1, NULL, NULL, 'ANDRÉ LUIZ DE ALMEIDA', NULL, '20231', '3c09390d772a0aa426a44d72c9d0db2d3f44bf13', 1),
(1050482013017, 1, NULL, NULL, 'MURILO DE PAULA LEOPOLDINO', NULL, '20231', '7fdf9603653212de4441a36372c7e79c6f74a216', 1),
(1050482013019, 1, NULL, NULL, 'ROBSON GARCIA DOS ANJOS', NULL, '20231', 'd082fecaf50c0a1404608bb29582effd771a451f', 1),
(1050482013027, 1, NULL, NULL, 'GABRIEL ZECCHI BASILIO', NULL, '20231', 'f148f72225dd3379e8ca96cd27b446b819fa5991', 1),
(1050482013029, 1, NULL, NULL, 'LUCA SCHUTZENHOFER', NULL, '20231', '6961c436ddd957688af7581d33fc7e7a3c9c6201', 1),
(1050482013030, 1, NULL, NULL, 'CARLOS HENRIQUE MARCIANO JUNIO', NULL, '20231', '58b250045ffa5119178695e18b93ff70c1068377', 1),
(1050482013034, 1, NULL, NULL, 'JULIA ROMANI BARRETA', NULL, '20231', 'a9e461a8ed0223b1c96b64c54660415d906c0f09', 1),
(1050482013037, 1, NULL, NULL, 'RYAGO TAKEO OZAWA', NULL, '20231', '95cab8cf571cc04ec21fac6ef44a56dbe156383e', 1),
(1050482013041, 1, NULL, NULL, 'VINICIUS VICARI DE ALMEIDA', NULL, '20231', 'b338743be9cb0f66f523da5c10af1f3c340375a7', 1),
(1050482013045, 1, NULL, NULL, 'YOLANDA FERREIRA DE SOUZA', NULL, '20231', '6b35be3926a8e5b374baeffd18a50326c5f10fbc', 1),
(1050482023005, 1, NULL, NULL, 'LAIANE PEREIRA GONCALVES ROSA', NULL, '20231', 'f16a37232b8955a4881db12cf38ba125d883e9c7', 1),
(1050482023006, 1, NULL, NULL, 'RENIS DE SOUZA MOREIRA', NULL, '20231', '83c38167cf5391c22d83179fe315ad44c136acde', 1),
(1050482023014, 1, NULL, NULL, 'GIOVANI CANOVA FOLTRAN', NULL, '20231', '94f9e85a1cee983d824b3132601d78eee1ea6f98', 1),
(1050482023015, 1, NULL, NULL, 'GILBERTO ROCHA MARTINS FILHO', NULL, '20231', '4964d7dacaca2c2789ee60b45b6855e716f245d2', 1),
(1050482023016, 1, NULL, NULL, 'GUSTAVO HENRIQUE ARAUJO DE PAU', NULL, '20231', '1aaee5609ea793c64df0804c48270b5dc8467365', 1),
(1050482023018, 1, NULL, NULL, 'OTAVIO AUGUSTO FIGUEIREDO FACC', NULL, '20231', '9f51ddadba4fdcfbe4528f327d57df74aecf21b1', 1),
(1050482023021, 1, NULL, NULL, 'THALITA BRITO JANUARIO', NULL, '20231', '074e3f3b5739358604591ec9dcbcc6592fc3a0a2', 1),
(1050482023023, 1, NULL, NULL, 'DAVID DOS SANTOS', NULL, '20231', 'a37124b615551c198b1ec7d3b2140036d22ab458', 1),
(1050482023026, 1, NULL, NULL, 'IGOR HENRIQUE CANIL', NULL, '20231', 'fcbaed97569995cd05825051368ca09911a9133e', 1),
(1050482023032, 1, NULL, NULL, 'RODRIGO BARBIERI', NULL, '20231', 'd19c1dbe60f6378c2da23fad7dfe098c3f2f3d06', 1),
(1050482023034, 1, NULL, NULL, 'MATEUS MARQUES FRAHM', NULL, '20231', '52e7644b72b4369b4c166af74a354378d1aa1c19', 1),
(1050482023036, 1, NULL, NULL, 'VITOR JOSE DO NASCIMENTO SILVA', NULL, '20231', '3d286b266e0e0fff86633c60acecb1068538d5c2', 1),
(1050482023039, 1, NULL, NULL, 'ALICE VITORIA ALVES', NULL, '20231', '6fc1eb62e38c48f48784238fd4957b5d501abb38', 1),
(1050482023044, 1, NULL, NULL, 'LUCAS MARQUES ROMERA', NULL, '20231', 'c3e56f6eb677ad55e6f534ab88ef1c884ba78e18', 1),
(1050482023046, 1, NULL, NULL, 'EDUARDO BATISTA FERNANDES', NULL, '20231', '99e6c2d6056616c38f81fd003e7a2dfed52cad71', 1),
(1050482113010, 1, NULL, NULL, 'LEIANNY GISELI RIBEIRO POIANI', NULL, '20231', '646694e461d96a99cc6ac72e6be820e3aec2d3c5', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL,
  `periodo_curso` varchar(20) DEFAULT NULL,
  `nome_curso` varchar(50) NOT NULL,
  `matricula_coordenador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id_curso`, `periodo_curso`, `nome_curso`, `matricula_coordenador`) VALUES
(1, 'Noite', 'Análise e Desenvolvimento de Sistemas', 45129),
(2, 'Manhã', 'Redes de Computadores', 51415),
(3, 'Noite', 'Comércio Exterior', 23660),
(4, 'Manhã', 'Gestão de Serviços', 45675),
(5, 'Tarde', 'Gestão Empresarial', 55170),
(6, 'Noite', 'Gestão Empresarial', 55170),
(7, 'Manhã', 'Logística Aeroportuária', 45668);

-- --------------------------------------------------------

--
-- Estrutura da tabela `docente`
--

CREATE TABLE `docente` (
  `matricula_docente` int(11) NOT NULL,
  `nome_docente` varchar(40) NOT NULL,
  `status_docente` tinyint(1) NOT NULL,
  `TipoUsuario_docente` int(1) DEFAULT 2,
  `qtdHAE` int(11) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `docente`
--

INSERT INTO `docente` (`matricula_docente`, `nome_docente`, `status_docente`, `TipoUsuario_docente`, `qtdHAE`, `senha`) VALUES
(276, 'João Manoel de Campos', 1, 1, NULL, '6d363479c97439b921ad2bcba054992d8eda9a0c'),
(408, 'Eugênio Tadeu Bertagnoli', 1, 1, NULL, 'beba4d5d3ffb8fac7fe5ce87ac1eb2f75c4cd1a2'),
(9324, 'Ivanete Bellucci Pires de Alme', 1, 1, NULL, '3c8e2662d780e327599fe1291f295b89ee434599'),
(11224, 'Reinaldo Toso Junior', 1, 1, NULL, 'cd6a5336ad43cdac6fec2852678741899b6ad884'),
(12002, 'Danilo Sergio Sorroce', 1, 1, NULL, 'e6cce22f31a0aabd0396c382996dad590fe5a4d3'),
(12065, 'Cláudio Roberto Leandro', 1, 1, NULL, '370a84043f43d2714a7bb4383c9577bd0f5bf297'),
(17274, 'João Cantarelli Junior', 1, 1, NULL, 'ad22f16b222761c9377569c5858bfa862d7c80d9'),
(17684, 'Wilton Sturm', 1, 1, NULL, 'b500d03f24b7fdd1f32ac63ce2f8dd5394b41b29'),
(18192, 'Wilson José de Oliveira', 1, 1, NULL, '9f71664fe789d2321f44b75974925f605cfd4ff4'),
(18880, 'Magali Barçante', 1, 1, NULL, '90f74b0750f53d925337e7a5c1f83e4368a5c7c7'),
(18960, 'Sérgio Furgeri', 1, 1, NULL, '9322788353ed6b8df7c5f8eb185ee85920748a88'),
(18962, 'Viviane Di Battisti', 1, 1, NULL, '587af0af378cd09e3aaa1aedb5ca328a1b07485c'),
(19968, 'Yara Brito Brasileiro', 1, 1, NULL, '0875dd6b9299e83d6c8a59de4004fed6fa90306e'),
(20790, 'Sandro Roberto da Silva Calabr', 1, 1, NULL, 'e523650f0159ac2379f1e350fedac87c7c979957'),
(21856, 'Sérgio Donisete Clauss', 1, 1, NULL, 'b36b62de9fae1e347530e469a4cee87d0b2fc88b'),
(23659, 'Francisco Carlos Benedetti', 1, 1, NULL, 'ba044b0f77ce094cf3b35ca10424a963c1fd4749'),
(23660, 'Ricardo Sérgio Neiva Nóbrega', 1, 1, NULL, '35f98d8bc9bbf0353d0aca80733a97909a13cafd'),
(23661, 'Virgílio Itauiti Panzetti', 1, 1, NULL, 'd378740d733aa286e8d0d33e4999e74d4ea249bb'),
(26444, 'José Luiz Marques', 1, 1, NULL, 'b68b48aad6582b549c5c517a56ab369d40dfe71e'),
(26451, 'Aldo Nascimento Pontes', 1, 1, NULL, '3dfc5bfee68725b7f8c5b2c4c20776f4571f6c39'),
(26589, 'Maria Margarida Massignan de A', 1, 1, NULL, '5183079626343aa7f87bcca5ed2063f46146598b'),
(30066, 'Maria das Graças J. M. Tomazel', 1, 1, NULL, '873467d318a65d61c31a9862e8b2daea85000cdd'),
(34416, 'Elisiane Sartori Menezes Garci', 1, 1, NULL, '46d4ba4834b08128d79e236fc9c7161b0015d3c6'),
(34417, 'Vera Márcia Gabaldi  ', 1, 1, NULL, 'f31dea193e7feb41e047343def7e080635510fc0'),
(38468, 'Carlos Antonio Fragoso', 1, 1, NULL, '6e9c2014c5f5a1ec3d9bc5a6b0a257c371531eb4'),
(38608, 'Valter Castelhano de Oliveira ', 1, 1, NULL, '0c614959d570fd960d273a49ef3e9bdff177c0dd'),
(43597, 'Rosana Helena Nunes', 1, 1, NULL, '71f249565bb0710da7b53edba8786014ba6bee8b'),
(43634, 'André Luiz Silva', 1, 1, NULL, 'ecfd0d59d20b5dfca877daf2989e7dd87a16757d'),
(43636, 'Vilma Maria de Lima', 1, 1, NULL, '6e0c3952e2be9c193805a176ccd3c4d278192379'),
(43639, 'Elenir Almeida Silva', 1, 1, NULL, 'ff4c5ad7db52d8a8bac98cd68e0e56a2bd475fb9'),
(44857, 'Carlos Henrique Dias', 1, 1, NULL, '938a153af380701253ef99364349442e331fd32f'),
(45119, 'Lincon Moreira Peretto', 1, 1, NULL, '5cb9a0206108786ebdf1b32cd0d8066d5a4ba29b'),
(45129, 'Michel Moron Munhoz', 1, 2, NULL, 'c06ddea88c5aa05e52f64a83f734d89ee266fbae'),
(45188, 'Paulo Roberto Nunes Fortaleza', 1, 1, NULL, '051d302965a4e19d5de98a35483120468a72dac8'),
(45192, 'Luciana de Carvalho', 1, 1, NULL, 'd8702c295e4a9476c3d31e1694fbb318711922f9'),
(45668, 'Sandro Roberto da Silva Calabr', 1, 1, NULL, '245c461ccd6b578bbeb89fc7cf88ea3fc5c6c8bc'),
(45675, 'Juliana Silva Watanabe', 1, 2, 4, 'eb4eabf059a430b5de037061b1a5f19b33fed0ba'),
(46484, 'Lilian Simão Oliveira', 1, 1, NULL, 'ebe77dd7638686ed81d4c9de11b763d094072cc4'),
(46485, 'Janaine Cristiane de Souza Ara', 1, 1, NULL, 'cc3eb42c83509e370a7945cc3cc0cf5bd9d1461d'),
(46487, 'Simone Tiemi Taketa Bicalho', 1, 1, NULL, '1699858c3845d626b17c6a30a134b9c3545d6815'),
(47972, 'Alexandre Serrano', 1, 1, NULL, '0c9eb79e1081ca140675e55c603ab21f274ee416'),
(47974, 'Rita Maria Cunha Leite Coentro', 1, 1, NULL, 'b3444902668d43c32aa2378e1e9f2747fa443f7f'),
(47975, 'José Renato de Siqueira Lopes', 1, 1, NULL, 'e5c49fae3bc90e3a67ac2c230573ead5c9a9cc1e'),
(47977, 'Renata Pierri Lucietto Rossett', 1, 1, NULL, '4414594001ec7e8beb46a06731661be2a46b34ba'),
(47979, 'José Estanislau Sigrist', 1, 1, NULL, 'af91b6ae2ba492d54b6d9ab8d0a6a2e5e0d00c53'),
(51404, 'André Meschiatti Nogueira', 1, 1, NULL, 'c7618f9112f8dbde4c0708c714bfad45759fa1b8'),
(51409, 'Edson Luiz Pereira', 1, 1, NULL, 'd6170adfe4808861e40057f49c80987752e59c7c'),
(51411, 'Marcelo Carvalho Costa', 1, 1, NULL, 'f5aea892b22268701ea34f0b729f069e1c77bb1d'),
(51415, 'Wellignton Roque', 1, 2, NULL, '94db4f7e5014bfbe60da72e4ce72e7255c36dd48'),
(55167, 'Leila Ribeiro de Caldas ', 1, 1, NULL, '6e57952e6bcbb7faf8b347410cad5d70b22a726c'),
(55170, 'Benedito Carlos Florêncio Silv', 1, 1, NULL, 'b3976e5856692a72149f07f70b3f9e2df4398cf9'),
(55171, 'Carlos Alberto Bucheroni', 1, 1, NULL, '7e5106bbe7327d86f3b9c580e8a76b62a605fa72'),
(55174, 'Laerte Zotte Junior', 1, 1, NULL, '050a4e319600f893a48cd294ad3393fdf7ccf04a'),
(55182, 'Talita Annunciato Rodrigues', 1, 1, NULL, '89e721dfc4a24bf2c8bfd66efebfb31441cb7bea'),
(55185, 'Osmar Alves Teixeira', 1, 1, NULL, 'bed43d496345bc50fd7d5d3e9056fabc29dcb502'),
(55186, 'José William Pinto Gomes', 1, 1, NULL, '4525967791967ad34c9231345e7ee1311ae3ba8c'),
(55190, 'Rafaeli Cardozo Modolo Begalli', 1, 1, NULL, 'e21e88df5b5ace3da17e681eb66a9e64a29f8fc3'),
(55191, 'Jones Artur Gonçalves', 1, 1, NULL, '3bdafa18d6bb1a575cf14f5e7c47b5f3f378811b'),
(55192, 'Wylds Carlos Giusti', 1, 1, NULL, '3fa9fed52ad8e22678b67962b654832499bd198a'),
(56433, 'Sérgio Scuotto', 1, 1, NULL, '1605ca5a317199f330f270da2bd885fa506123c6'),
(57335, 'Rogerio Antonio Alves', 1, 1, NULL, 'bd13843806ba390826d2dbdbf89e9d76a58961c7'),
(57342, 'Maria Fernanda Grosso Lisboa ', 1, 1, NULL, '2b9594b84627ea46e63b8f15ec459f54757515f5'),
(67807, 'Angela Trimer de Oliveira', 1, 1, NULL, '44b1a3fe462db14820720a465203bb6a76c2cd7a'),
(69448, 'Joclenes Emilio Diehl', 1, 1, NULL, '33cba9bedb0f143c313b1e7f1ebe20f4f7aaa7f2'),
(69935, 'Helder Pestana', 1, 1, NULL, 'd7e563ff03dede31498cbd2d62bcdc0074571c47'),
(70125, 'Tamires Freire Silva', 1, 1, NULL, 'ff1b3a60876af9fa68a1de523428953563aecc3e'),
(70167, 'Rogerio Rodolfo Baptista', 1, 1, NULL, '76d2b044e9f105691898e004fd42f89430872292'),
(71007, 'Cesar Augusto Della Piazza', 1, 1, NULL, 'a3047060c278172fdfe6801d351dcb1b3649c94e'),
(71095, 'Renato Labbate', 1, 1, NULL, '9767d11c8934c4e1b06ff9e4d9041481db9c32f7'),
(71311, 'Gabriel Adams Castelo Branco A', 1, 1, NULL, 'b67347dcf9bf7608fcd5b60b43e0c50685570fa6'),
(71393, 'Valeria Scomparim', 1, 1, NULL, '64efb9c36fd41812383f847f80c9a971d2dc801d'),
(71394, 'Valdinette Doria', 1, 1, NULL, 'e4de8653731f8b2bd72093e9b6f731de68b314e1'),
(71395, 'Luis Fernando Adorno da Silva', 1, 1, NULL, '2ed2255e0da9161cb4ebb1a2c669a396c27e461c'),
(71505, 'Luciene Novais Mazza', 1, 1, NULL, 'c8feeadad035e2c50c0e4af03f526adbc717dec4'),
(71522, 'Bernardino de Jesus Sanches', 1, 1, NULL, '943ace90cf88fb4b265604007c7606571680d477'),
(71567, 'Alex Rodrigo Moises Costa Wand', 1, 1, NULL, '750de1db04d85db860bc005878521d367bc672f3'),
(71568, 'Simone Mendes da Silva', 1, 1, 1, '0b81975b4d2a8817f0ed376de3c5ef2a34b1eeed'),
(71569, 'Marcio Rogerio Santos Ferraz', 1, 2, 3, '7b0451eac3c93870d011cb49ab9d1723b454f614'),
(71607, 'Luiz Fernando Fontana Rodrigue', 1, 1, NULL, 'cb0d147440447ecd8c15281811df2b9165367a67'),
(72247, 'Sérgio Gustavo Medina Pereira', 1, 1, NULL, '3c3f87b583ba4a292b9634a36194a8fb24e20c70'),
(72475, 'Barbara Regina Lopes Costa', 1, 1, NULL, '315ea9f97da2c7678d9b8b0239778f1901db06ac'),
(72601, 'Ailton Bueno Scorsoline', 1, 1, NULL, '359d875dee25cd44c5cc0448f449f057d7ca1cb8'),
(73165, 'Claudinei Portilho Matheus', 1, 1, NULL, '716842ce9337e6f261eacde4e6c22d70427165ed'),
(73167, 'Jorge Luiz Antonio', 1, 1, NULL, 'e42e17e53e24bd25ef85078ebcc2eeafa1d910af'),
(73233, 'Maria Eugenia Cauduro Cruz', 1, 1, NULL, '8ac9561ec59f09351dc9b4cf712073765c2d572a'),
(73463, 'José Augusto Dias Mome', 1, 1, NULL, 'f3667c39535f85c21a91954c274f76c3566f7161'),
(73890, 'Mariana do Campo Souza Vieira', 1, 1, NULL, '432e0d1ed516b7fda16ab3a3c423041b19232337');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `listar_vinculoptg`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `listar_vinculoptg` (
`professor` int(11)
,`aluno` bigint(20)
,`semestre` int(11)
,`dupla_ptg` bigint(20)
,`nome_docente` varchar(40)
,`nome_aluno` varchar(50)
,`retornar_nome_dupla(ptg.dupla_ptg)` varchar(50)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vinculoptg`
--

CREATE TABLE `vinculoptg` (
  `professor` int(11) NOT NULL,
  `aluno` bigint(20) NOT NULL,
  `semestre` int(11) NOT NULL,
  `dupla_ptg` bigint(20) DEFAULT NULL,
  `titulo` varchar(50) NOT NULL,
  `primeira_nota` decimal(10,2) NOT NULL,
  `link_video` varchar(50) NOT NULL,
  `link_drive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vinculoptg`
--

INSERT INTO `vinculoptg` (`professor`, `aluno`, `semestre`, `dupla_ptg`, `titulo`, `primeira_nota`, `link_video`, `link_drive`) VALUES
(71568, 1050291721002, 20222, 1050481823024, '', '0.00', '', ''),
(71568, 1050481713027, 20222, 1050481913001, '', '0.00', '', ''),
(71568, 1050481913014, 20222, 1050481923009, '', '0.00', '', '');

-- --------------------------------------------------------

--
-- Estrutura para vista `listar_vinculoptg`
--
DROP TABLE IF EXISTS `listar_vinculoptg`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `listar_vinculoptg`  AS SELECT `ptg`.`professor` AS `professor`, `ptg`.`aluno` AS `aluno`, `ptg`.`semestre` AS `semestre`, `ptg`.`dupla_ptg` AS `dupla_ptg`, `d`.`nome_docente` AS `nome_docente`, `a`.`nome_aluno` AS `nome_aluno`, `retornar_nome_dupla`(`ptg`.`dupla_ptg`) AS `retornar_nome_dupla(ptg.dupla_ptg)` FROM ((`vinculoptg` `ptg` join `docente` `d`) join `aluno` `a`) WHERE `ptg`.`professor` = `d`.`matricula_docente` AND `ptg`.`aluno` = `a`.`ra_aluno``ra_aluno`  ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`ra_aluno`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Índices para tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD KEY `matricula_coordenador` (`matricula_coordenador`);

--
-- Índices para tabela `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`matricula_docente`);

--
-- Índices para tabela `vinculoptg`
--
ALTER TABLE `vinculoptg`
  ADD PRIMARY KEY (`professor`,`aluno`,`semestre`),
  ADD KEY `aluno` (`aluno`),
  ADD KEY `dupla_ptg` (`dupla_ptg`);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`);

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`matricula_coordenador`) REFERENCES `docente` (`matricula_docente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
