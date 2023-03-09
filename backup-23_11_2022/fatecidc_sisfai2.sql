-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 23-Nov-2022 às 08:24
-- Versão do servidor: 5.7.23-23
-- versão do PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fatecidc_sisfai2`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`fatecidc`@`localhost` PROCEDURE `enviarTrabalho` (IN `var_ra` BIGINT, `var_semestre` INT, `var_titulo` VARCHAR(100), `var_video` VARCHAR(100), `var_drive` VARCHAR(100))  BEGIN
	DECLARE consulta INT;
	DECLARE consulta2 INT;
    	SET consulta = (SELECT COUNT(*) FROM vinculotg WHERE (aluno = var_ra OR dupla_tg = var_ra) AND semestre = var_semestre);

	IF (consulta = 0) THEN
		SET consulta2 = (SELECT COUNT(*) FROM vinculoptg WHERE (aluno = var_ra OR dupla_ptg = var_ra) AND semestre = var_semestre);        
        	IF (consulta2 = 0) THEN
			SELECT 'Não encontrado' AS Msg;
		ELSE
			UPDATE vinculoptg SET titulo = var_titulo, link_video = var_video, link_drive = var_drive WHERE (aluno = var_ra OR dupla_ptg = var_ra) AND semestre = var_semestre;
			COMMIT;
		END IF;
	ELSE
		UPDATE vinculotg SET titulo = var_titulo, link_video = var_video, link_drive = var_drive WHERE (aluno = var_ra OR dupla_tg = var_ra) AND semestre = var_semestre;
			COMMIT;
		END IF;
END$$

CREATE DEFINER=`fatecidc`@`localhost` PROCEDURE `inserir_aluno` (IN `ra` BIGINT, IN `statusa` TINYINT, IN `email` VARCHAR(100), IN `fone` BIGINT, IN `nome` VARCHAR(50), IN `tipoUsuario` INT, IN `semestre` INT, IN `senha` VARCHAR(255), IN `curso` INT, IN `tipo_trabalho` VARCHAR(3))  BEGIN
 DECLARE raAluno bigint;
    SET raAluno = (SELECT ra_aluno FROM aluno where ra_aluno=ra);
IF(raAluno>0)
THEN
UPDATE aluno SET semestre=semestre where ra_aluno=ra;
COMMIT;
ELSE
INSERT INTO aluno VALUES (ra, statusa, email, fone, nome, tipoUsuario, semestre, senha, curso, tipo_trabalho);
COMMIT;
END IF;
END$$

CREATE DEFINER=`fatecidc`@`localhost` PROCEDURE `inserir_vinculoPTG` (`professor` INT, `aluno` BIGINT, `semestre` INT, `dupla` BIGINT)  BEGIN
 DECLARE contTG int;
 DECLARE contPTG int;
 DECLARE qtdTotal int;
 DECLARE hae int;

 SET contTG  = (SELECT qtdTG FROM docente where matricula_docente = professor);
 SET contPTG  = (SELECT qtdPTG FROM docente where matricula_docente = professor);
 SET qtdTotal = (contTG DIV 3) + (contPTG DIV 5);
 SET hae = (SELECT qtdHAE FROM docente WHERE matricula_docente = professor);
 IF(qtdTotal=hae)
            THEN
            SELECT "Professor não possui mais horas disponíveis para orientação";
            ROLLBACK;
ELSEIF (qtdTotal<hae)
	THEN
	INSERT INTO vinculoptg (professor,aluno,semestre,dupla_ptg) VALUES (professor,aluno,semestre,dupla);
	COMMIT;
ELSE
    SELECT "A quantide de horas total está ultrapassando o limite";
    ROLLBACK;
END IF;
END$$

CREATE DEFINER=`fatecidc`@`localhost` PROCEDURE `inserir_vinculoTG` (`professor` INT, `aluno` BIGINT, `semestre` INT, `dupla` BIGINT)  BEGIN
 DECLARE contTG int;
 DECLARE contPTG int;
 DECLARE qtdTotal int;
 DECLARE hae int;

 SET contTG  = (SELECT qtdTG FROM docente where matricula_docente = professor);
 SET contPTG  = (SELECT qtdPTG FROM docente where matricula_docente = professor);
 SET qtdTotal = (contTG DIV 3) + (contPTG DIV 5);
 SET hae = (SELECT qtdHAE FROM docente WHERE matricula_docente = professor);
 IF(qtdTotal=hae)
            THEN
            SELECT "Professor não possui mais horas disponíveis para orientação";
            ROLLBACK;
ELSEIF (qtdTotal<hae)
	THEN
	INSERT INTO vinculotg (professor,aluno,semestre,dupla_tg) VALUES (professor,aluno,semestre,dupla);
	COMMIT;
ELSE
    SELECT "A quantide de horas total está ultrapassando o limite";
    ROLLBACK;
END IF;
END$$

--
-- Funções
--
CREATE DEFINER=`fatecidc`@`localhost` FUNCTION `numeroHAEsPTG` (`horas` INT) RETURNS INT(11) BEGIN
	DECLARE mostrar INT;
    SET mostrar = 0;
IF (horas > 0 AND horas <= 5) THEN
	SET mostrar = 1;
ELSEIF(horas <= 10) THEN
    SET mostrar = 2;
ELSEIF(horas <= 15) THEN
    SET mostrar = 3;
END IF;

RETURN mostrar;
END$$

CREATE DEFINER=`fatecidc`@`localhost` FUNCTION `numeroHAEsTG` (`horas` INT) RETURNS INT(11) NO SQL
BEGIN
	DECLARE mostrar INT;
    SET mostrar = 0;
IF (horas > 0 AND horas <= 3) THEN
	SET mostrar = 1;
ELSEIF(horas <= 6) THEN
    SET mostrar = 2;
ELSEIF(horas <= 9) THEN
    SET mostrar = 3;
ELSEIF(horas <= 12) THEN
    SET mostrar = 4;
ELSEIF(horas <= 15) THEN
    SET mostrar = 5;
END IF;

RETURN mostrar;
END$$

CREATE DEFINER=`fatecidc`@`localhost` FUNCTION `retornar_nome_dupla` (`ra` BIGINT) RETURNS VARCHAR(50) CHARSET utf8mb4 BEGIN
   RETURN (SELECT a.nome_aluno from aluno a where a.ra_aluno = ra);  
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `ra_aluno` bigint(20) NOT NULL,
  `status_aluno` tinyint(1) NOT NULL,
  `email_aluno` varchar(50) DEFAULT NULL,
  `fone_aluno` bigint(20) DEFAULT NULL,
  `nome_aluno` varchar(50) NOT NULL,
  `tipoUsuario_aluno` int(1) DEFAULT '1',
  `semestre` varchar(20) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `tipo_trabalho` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`ra_aluno`, `status_aluno`, `email_aluno`, `fone_aluno`, `nome_aluno`, `tipoUsuario_aluno`, `semestre`, `senha`, `id_curso`, `tipo_trabalho`) VALUES
(1050291721002, 1, '', 0, 'HENRIQUE FLORENCE WAGNER CIPRIANO', 0, '20222', 'e0541222d004692e6fdeed5a4375c7a70cc71ffe', 1, 'ptg'),
(1050481813048, 1, '', 0, 'ALAN DE JESUS ELIAS DE SOUZA', 0, '20222', 'd658c9e1c920a38348635c8abe5a9634b9575988', 1, 'ptg'),
(1050481813051, 1, 'anderson.dias@fatec.sp.gov.br', 19999725028, 'ANDERSON CESAR DIAS', 0, '20222', 'd4c066e11e976f9ef9b77ce821f01627663f789a', 1, 'tg'),
(1050481823001, 1, '', 0, 'RAMON TADEU GONCALVES', 0, '20222', '618d5488c2d533670b3f757d096850d4d123a17c', 1, 'tg'),
(1050481823024, 1, 'fabio.rodrigues29@fatec.sp.gov.br', 19994082867, 'FABIO MATHEUS RODRIGUES', 0, '20222', 'e582df92b77175ca53d8024d6e056748b5674244', 1, 'ptg'),
(1050481823033, 1, '', 0, 'LUIS FERNANDO BORTOLOTTI', 0, '20222', '623226c41d07bf2733e9228fa46c69e85154e708', 1, 'ptg'),
(1050481913004, 1, 'lucas.piloto@fatec.sp.gov.br', 19997507555, 'LUCAS GIBIM PILOTO', 0, '20222', '9663f54d94079087a2af246af22c81434ccf15bb', 1, 'ptg'),
(1050481913014, 1, '', 0, 'BRUNO ROVERI BALDINI', 0, '20222', 'a656be5dcfbfe365bff5f1a9cdcd0ca2cad44976', 1, 'tg'),
(1050481913023, 1, 'ldslucasc@gmail.com', 19981914687, 'LUCAS DOS SANTOS SILVA', 0, '20222', 'c65cbcada17d695e09a24fe8c2a389c4c657ef4f', 1, 'tg'),
(1050481913048, 1, 'leonardo.barba@fatec.sp.gov.br', 19999347999, 'LEONARDO KEIJI DE OLIVEIRA BARBA', 0, '20222', 'dc798c685b186bfb2020118d3a38c220fc07eb79', 1, 'tg'),
(1050481913049, 1, '', 0, 'BEATRIZ GEIELE DE OLIVEIRA FERREIRA', 0, '20222', 'c350714eeac181e211c42866cccc8204471d6b32', 1, 'ptg'),
(1050481913051, 1, '', 0, 'LUCAS PINAFI DE ANDRADE', 0, '20222', '13491c2d8594433b1140f960386c431b2386b15d', 1, 'tg'),
(1050481923001, 1, '', 0, 'VITOR GABRIEL GRACIANO RIBEIRO', 0, '20222', '88800956ea005493e1bf41b34c3a8e0bf597868c', 1, 'tg'),
(1050481923011, 1, '', 0, 'RICARDO SOUZA QUINA DE ASSIS', 0, '20222', '240aca2fd46dec4a336cdc02e200a5246e65d833', 1, 'tg'),
(1050481923013, 1, 'leonardozenni@gmail.com', 19981672571, 'LEONARDO MENEGHIN ZENNI', 0, '20222', '4ba1c24360aa88173270bfe26a8e4277373ce7e1', 1, 'tg'),
(1050481923015, 1, 'luiskamer@hotmail.com', 19982359578, 'LUIS FILIPE DA SILVA KAMER', 0, '20222', '4b945c7c9935cdf5115749647645fb9eb30c0e92', 1, 'ptg'),
(1050481923017, 1, 'contigabriel72@gmail.com', 19971365759, 'GABRIEL CONTI MACHADO', 0, '20222', 'b0416fa3fa35823f4f025a10698da7e64b2123f2', 1, 'ptg'),
(1050481923024, 1, 'vivian.martino@fatec.sp.gov.br', 19992226148, 'VIVIAN MAGDA SOARES PADIAL MORALES DE MARTINO', 0, '20222', 'f393c275691eae0f4910865a97a307fecaa95603', 1, 'tg'),
(1050481923025, 1, '', 0, 'VINICIUS VIEIRA PINHEIRO', 0, '20222', '574a1f3c0f038bc2a6bfb8062fca15f441ae50b3', 1, 'tg'),
(1050481923029, 1, '', 0, 'JONAS BATISTA DE SOUZA FILHO', 0, '20222', '37b261e337796e77fdfb33b728bab864e96ee152', 1, 'ptg'),
(1050481923032, 1, '', 0, 'JENIFER DE ALMEIDA SOUZA', 0, '20222', '62aa590bfd1a76203d02290aa3e3856ee8975df6', 1, 'ptg'),
(1050481923043, 1, 'caio_rossi@outlook.com', 11997880385, 'CAIO VINICIUS DOS SANTOS ROSSI', 0, '20222', 'fa957cab0aed0b29b91e5402069f4864b0f82e5c', 1, 'ptg'),
(1050481923050, 1, 'juangusilva99@gmail.com', 19981422298, 'JUAN GUSTAVO DA SILVA', 0, '20222', 'eecf286cecadb7b26d158f8cec7ce7c682e6d3bd', 1, 'ptg'),
(1050481923053, 1, '', 0, 'GUSTAVO NASCIMENTO QUEIROZ', 0, '20222', 'b61782c04299b17bc58ac19fb88f707bbfbfb13b', 1, 'tg'),
(1050482013005, 1, '', 0, 'LUCAS DIAS CALADO', 0, '20222', 'bbd733b09f71bde5ec8749c69e54a124b43672f5', 1, 'tg'),
(1050482013006, 1, '', 0, 'WESLEY HENRIQUE FAVERI DE OLIVEIRA', 0, '20222', 'be35a6d0d1b9f878b25d7b854117a3fcd72b3155', 1, 'tg'),
(1050482013008, 1, '', 0, 'GIULIANA CAMPREGHER MISSIO', 0, '20222', '234ea348dcb92b088e8678f587ea6674afea731f', 1, 'tg'),
(1050482013011, 1, '', 0, 'CAIO VINICIUS ALVES RODRIGUES', 0, '20222', '8fb159cd598ade2fe9db3ba727126269ff639260', 1, 'tg'),
(1050482013015, 1, '', 0, 'ANDRÉ LUIZ DE ALMEIDA', 0, '20222', '12a6085d2f64874b37d020033ec6a5dce38f04ba', 1, 'tg'),
(1050482013017, 1, '', 0, 'MURILO DE PAULA LEOPOLDINO', 0, '20222', '382ffef74ce183434d0747d58776bc0069e5e650', 1, 'tg'),
(1050482013018, 1, '', 0, 'LUCAS ROBERTO PEREIRA RODRIGUES', 0, '20222', '151bcf80b4d825e9d6a99019921196ca078bc284', 1, 'ptg'),
(1050482013019, 1, 'robson.anjos@fatec.sp.gov.br', 19993985583, 'ROBSON GARCIA DOS ANJOS', 0, '20222', '79ead25e97f21c62f807b5d15ae843e0c5ca3220', 1, 'ptg'),
(1050482013023, 1, 'gleison_souza08@hotmail.com', 19989989009, 'GLEISON GRANADO DE SOUZA', 0, '20222', '1e980b7d1c2e52c16398f5ac7c33fd84c0811ac0', 1, 'ptg'),
(1050482013027, 1, '', 0, 'GABRIEL ZECCHI BASILIO', 0, '20222', '59390a30a2f11a4527e53cb1e60c0ffd084388c9', 1, 'tg'),
(1050482013029, 1, 'lucaschutzenhofer@hotmail.com', 11959487313, 'LUCA SCHUTZENHOFER', 0, '20222', '500e1e9dc67fd0bfb8b9f1c74bd799e14bafaeb3', 1, 'tg'),
(1050482013030, 1, '', 0, 'CARLOS HENRIQUE MARCIANO JUNIOR', 0, '20222', '3a3eee02b9ad1a879cb88507138c1e9af2e1e9cc', 1, 'tg'),
(1050482013032, 1, 'gustavo.zanardin@gmail.com', 19982787426, 'GUSTAVO ZANARDI NUNES', 0, '20222', '32f97295bbfe26d2870ce1b04ca1079b85f73f77', 1, 'ptg'),
(1050482013034, 1, '', 0, 'JULIA ROMANI BARRETA', 0, '20222', 'fb63ac00353e2dcaa9dde2ce9f05d6d145f36c57', 1, 'ptg'),
(1050482013037, 1, '', 0, 'RYAGO TAKEO OZAWA', 0, '20222', '8ad3e3f72b6f8ee3b9d495394b16f3f38e627f4e', 1, 'tg'),
(1050482013039, 1, NULL, NULL, 'WESLEY ISNEY DE JESUS REIS', 0, '20222', 'f81a0ee14dc4e512ea1cd2be122dddcf72d311eb', 1, 'ptg'),
(1050482013041, 1, '', 0, 'VINICIUS VICARI DE ALMEIDA', 0, '20222', 'c348690cc550ffdfaab55270fbe0835fb7f389ce', 1, 'tg'),
(1050482013045, 1, '', 0, 'YOLANDA FERREIRA DE SOUZA', 0, '20222', '6478cec8b1c45c524f9b4a225504b1d1f7b78f9c', 1, 'tg'),
(1050482023005, 1, NULL, NULL, 'LAIANE PEREIRA GONCALVES ROSA', 0, '20222', '721ad892368a8bee62c2ff578347cb90ebd2ebaf', 1, 'tg'),
(1050482023006, 1, '', 0, 'RENIS DE SOUZA MOREIRA', 0, '20222', 'd1bb512da4d89d3adeaee8acf29fe53bd278797d', 1, 'tg'),
(1050482023014, 1, '', 0, 'GIOVANI CANOVA FOLTRAN', 0, '20222', '6062aebd3a67307c8fd3d6b051903efb5ececaa4', 1, 'tg'),
(1050482023015, 1, '', 0, 'GILBERTO ROCHA MARTINS FILHO', 0, '20222', '45e9286ceac42d3b7dc5c7c33734a1754c964a11', 1, 'tg'),
(1050482023016, 1, '', 0, 'GUSTAVO HENRIQUE ARAUJO DE PAULA', 0, '20222', '09f63bd8cc6834f7ec987e7cb33d70d348047409', 1, 'tg'),
(1050482023018, 1, '', 0, 'OTAVIO AUGUSTO FIGUEIREDO FACCIOLI', 0, '20222', '1f63c293489e43db776274fc448a22d551fe1c2b', 1, 'tg'),
(1050482023021, 1, NULL, NULL, 'THALITA BRITO JANUARIO', 0, '20222', '8db5a8ec8a2742187fda28078cc62f93cb3f7586', 1, NULL),
(1050482023023, 1, '', 0, 'DAVID DOS SANTOS', 0, '20222', '68ba8f17a3790a8a6ba082f330602e4062d292c9', 1, 'tg'),
(1050482023026, 1, '', 0, 'IGOR HENRIQUE CANIL', 0, '20222', 'a3b3f360075691c602bd459dd4f8da7e21f0b87e', 1, 'tg'),
(1050482023034, 1, '', 0, 'MATEUS MARQUES FRAHM', 0, '20222', '9bb3dde29825931350c6677eb6f414835d21527e', 1, 'tg'),
(1050482023036, 1, '', 0, 'VITOR JOSE DO NASCIMENTO SILVA', 0, '20222', 'f9e6832958eade4563fe0d45fee6444af7f792a8', 1, 'tg'),
(1050482023039, 1, '', 0, 'ALICE VITORIA ALVES', 0, '20222', '9ce1b86d5987164063f7649017bb610182d9ca7e', 1, 'tg'),
(1050482023044, 1, '', 0, 'LUCAS MARQUES ROMERA', 0, '20222', 'e89919ff3f9c3a0166798e37931460294557140b', 1, 'tg'),
(1050482023046, 1, '', 0, 'EDUARDO BATISTA FERNANDES', 0, '20222', '2ee67f4df90c3beb8bc119d979b8e7d1a4b44524', 1, 'tg'),
(1050482113010, 1, '', 0, 'LEIANNY GISELI RIBEIRO POIANI', 0, '20222', '7712ba765f0e4aa0ab91cec0f9c24fbb4382ceff', 1, 'tg'),
(1050482113012, 1, '', 0, 'LEIDIANE DE SOUZA LOPES FERREIRA', 0, '20222', 'b3405cd94eaeed875d81c7002468f792a044e82a', 1, 'ptg'),
(1050482113013, 1, '', 0, 'MATHEUS ALEXANDRE BRAZ DE OLIVEIRA', 0, '20222', '0af8984dd49b0e1bcdb1a25d0c019f3384507dce', 1, 'ptg'),
(1050482113018, 1, '', 0, 'MURILO GUSTAVO SCHALI DA COSTA', 0, '20222', 'd65800ec4abb0e6e3f4d967be20164a418051b9a', 1, 'ptg'),
(1050482113021, 1, 'dalila.gimenez@fatec.sp.gov.br', 19992773751, 'DALILA RISSI GIMENEZ', 0, '20222', '448ae65864fa3b695287914609947395812a7ddc', 1, 'ptg'),
(1050482113026, 1, 'gianluca.micheli@fatec.sp.gov.br', 19992978232, 'GIANLUCA DIAS DE MICHELI', 0, '20222', 'bb24d322f8e6f7e6a66195c95916d2e21ab70d76', 1, 'ptg'),
(1050482113032, 1, 'caique.scapeline@fatec.sp.gov.br', 11941170146, 'CAIQUE PATELLI SCAPELINE', 0, '20222', '95dfe6a6483774247034cd0ae72d3fbcad6cdeb2', 1, 'ptg'),
(1050482113033, 1, '', 0, 'GUSTAVO SOARES DOS REIS', 0, '20222', '6ae61821fbd24e9eb25676d3a8b53792b980169c', 1, 'ptg'),
(1050482113040, 1, '', 0, 'ALEXANDRE DE CARVALHO AMARAL', 0, '20222', '91449dfb288bc6dbe6ce87dd0aa0e4f3aa01d120', 1, 'ptg'),
(1050482113042, 1, '', 0, 'ADILSON ANTONIO GENARI FILHO', 0, '20222', '8924e78f1ae726e8ed29186f4a6e4ef133fdc31a', 1, 'ptg'),
(1050482113046, 1, 'guga.lucas2015@gmail.com', 19998919591, 'LUCAS GUIMARAES', 0, '20222', '51e4d8279767799036846e90b5c8c018cfb4c7dc', 1, 'ptg'),
(1050482113048, 1, 'abner.silva11@fatec.sp.gov.br', 19994972543, 'ABNER BENEDITO GONCALVES DA SILVA', 0, '20222', 'dcbbc13d6b9b8e4e623e8a1c4326589d69ba9216', 1, 'ptg'),
(1050482223012, 1, NULL, NULL, 'FELIPE BARBOSA DOMINGUESCHE', 0, '20222', '7da4b6d5aa4bf3424c42d979c0866cdf11824abc', 1, 'ptg'),
(1050482223033, 1, '', 0, 'AMAZILES JOSÉ ANTÔNIO MARTINS DE CARVALHO', 0, '20222', '37c29861cefe1bf2630ba8bd1537a35ca0e6fc8f', 1, 'ptg'),
(1050482223045, 1, NULL, NULL, 'MARCOS VINICIUS OTA', 0, '20222', '00390b2fe1d963210f58f284074f104281f50266', 1, 'ptg'),
(1050622013028, 1, 'vic.elena10@gmail.com', 19999318438, 'Victoria Elena Garcia', 0, '20222', '49d7060a701c0de8053055a45929742910effa5f', 3, 'tg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `assinatura`
--

CREATE TABLE `assinatura` (
  `id` int(11) NOT NULL,
  `matricula_docente` int(11) DEFAULT NULL,
  `imagem` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `assinatura`
--

INSERT INTO `assinatura` (`id`, `matricula_docente`, `imagem`) VALUES
(8, 71569, 'bede2d14eb8a56edbf6fb745fb102c3285bb5235.png'),
(9, 71568, '5afc6438941c6d628468e4652a5c1c0663d95c89.jpg'),
(10, 71568, 'e2ce6375b33493586e5433f83d7553cd224955e4.jpg'),
(11, 45675, 'c86e54cd3a22464edef9f6a978f5611a30424906.png'),
(12, 45129, '1a9864e80e4420daabd17c5cdc091356bbad0963.jpg'),
(13, 55186, '20be120d71bd0e8ec166293b3cd8b9fc6aa09a1a.png'),
(14, 73463, 'edbdab57cfd227cc74d797db1bfbcca2df9a6207.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancaptg`
--

CREATE TABLE `bancaptg` (
  `codBanca` int(11) NOT NULL,
  `vinculoPTG` int(11) DEFAULT NULL,
  `professor` int(11) NOT NULL,
  `tipoBanca` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `notaBanca_Final` float DEFAULT NULL,
  `notaBanca` float NOT NULL,
  `data` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `comentario` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `bancaptg`
--

INSERT INTO `bancaptg` (`codBanca`, `vinculoPTG`, `professor`, `tipoBanca`, `notaBanca_Final`, `notaBanca`, `data`, `status`, `comentario`) VALUES
(4, 8, 45129, 'orientador', 0, 0, '2022-11-17 18:59:45', 1, NULL),
(5, 10, 45129, 'orientador', 0, 0, '2022-11-17 18:59:48', 1, NULL),
(6, 11, 45129, 'orientador', 0, 0, '2022-11-17 18:59:51', 1, NULL),
(8, 14, 45129, 'orientador', 0, 0, '2022-11-17 19:00:05', 1, NULL),
(9, 15, 45129, 'orientador', 0, 0, '2022-11-17 19:00:09', 1, NULL),
(10, 16, 45129, 'orientador', 0, 0, '2022-11-17 19:00:30', 1, NULL),
(12, 33, 45129, 'orientador', 0, 0, '2022-11-17 19:00:36', 1, NULL),
(13, 34, 45129, 'orientador', 0, 0, '2022-11-17 19:00:40', 1, NULL),
(14, 35, 45129, 'orientador', 0, 0, '2022-11-17 19:00:44', 1, NULL),
(15, 36, 45129, 'orientador', 0, 0, '2022-11-17 19:00:51', 1, NULL),
(16, 8, 71394, 'área', 0, 0, '2022-11-17 19:02:20', 1, NULL),
(17, 10, 71394, 'área', 0, 0, '2022-11-17 19:02:32', 1, NULL),
(18, 11, 65639, 'área', 0, 0, '2022-11-17 19:02:41', 1, NULL),
(20, 14, 71394, 'área', 0, 0, '2022-11-17 19:02:52', 1, NULL),
(21, 15, 71394, 'área', 0, 0, '2022-11-17 19:03:08', 1, NULL),
(22, 16, 71394, 'área', 0, 0, '2022-11-17 19:03:13', 1, NULL),
(24, 33, 71394, 'área', 0, 0, '2022-11-17 19:03:23', 1, NULL),
(25, 34, 71394, 'área', 0, 0, '2022-11-17 19:03:28', 1, NULL),
(26, 35, 71394, 'área', 0, 0, '2022-11-17 19:03:33', 1, NULL),
(27, 36, 71394, 'área', 0, 0, '2022-11-17 19:03:37', 1, NULL),
(28, 31, 21856, 'orientador', 0, 0, '2022-11-18 18:14:53', 0, NULL),
(29, 5, 21856, 'orientador', 0, 0, '2022-11-18 18:15:48', 0, NULL),
(30, 4, 21856, 'orientador', 0, 0, '2022-11-18 18:16:34', 0, NULL),
(31, 3, 21856, 'orientador', 0, 0, '2022-11-18 18:18:58', 0, NULL),
(33, 21, 73463, 'orientador', 0, 0, '2022-11-20 10:19:27', 0, NULL),
(34, 37, 73463, 'orientador', 0, 0, '2022-11-20 10:19:34', 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancatg`
--

CREATE TABLE `bancatg` (
  `codBanca` int(11) NOT NULL,
  `vinculoTG` int(11) DEFAULT NULL,
  `professor` int(11) NOT NULL,
  `tipoBanca` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `notaBanca_Final` float DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `comentario` text COLLATE utf8_unicode_ci,
  `notaEscrita_01` float DEFAULT NULL,
  `notaEscrita_02` float DEFAULT NULL,
  `notaEscrita_03` float DEFAULT NULL,
  `notaEscrita_04` float DEFAULT NULL,
  `notaEscrita_05` float DEFAULT NULL,
  `notaEscrita_06` float DEFAULT NULL,
  `notaEscrita_07` float DEFAULT NULL,
  `notaOral_01` float DEFAULT NULL,
  `notaOral_02` float DEFAULT NULL,
  `notaOral_03` float DEFAULT NULL,
  `notaOral_04` float DEFAULT NULL,
  `notaOral_05` float DEFAULT NULL,
  `notaOral_06` float DEFAULT NULL,
  `notaOral_07` float DEFAULT NULL,
  `notaFormatacao_01` float DEFAULT NULL,
  `notaFormatacao_02` float DEFAULT NULL,
  `notaFormatacao_03` float DEFAULT NULL,
  `notaFormatacao_04` float DEFAULT NULL,
  `notaFormatacao_05` float DEFAULT NULL,
  `notaFormatacao_06` float DEFAULT NULL,
  `notaFormatacao_07` float DEFAULT NULL,
  `notaFormatacao_08` float DEFAULT NULL,
  `notaFormatacao_09` float DEFAULT NULL,
  `notaFormatacao_10` float DEFAULT NULL,
  `notaFormatacao` float DEFAULT NULL,
  `notaEscrita` float DEFAULT NULL,
  `notaOral` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `bancatg`
--

INSERT INTO `bancatg` (`codBanca`, `vinculoTG`, `professor`, `tipoBanca`, `notaBanca_Final`, `data`, `status`, `comentario`, `notaEscrita_01`, `notaEscrita_02`, `notaEscrita_03`, `notaEscrita_04`, `notaEscrita_05`, `notaEscrita_06`, `notaEscrita_07`, `notaOral_01`, `notaOral_02`, `notaOral_03`, `notaOral_04`, `notaOral_05`, `notaOral_06`, `notaOral_07`, `notaFormatacao_01`, `notaFormatacao_02`, `notaFormatacao_03`, `notaFormatacao_04`, `notaFormatacao_05`, `notaFormatacao_06`, `notaFormatacao_07`, `notaFormatacao_08`, `notaFormatacao_09`, `notaFormatacao_10`, `notaFormatacao`, `notaEscrita`, `notaOral`) VALUES
(1, 18, 71568, 'orientador', NULL, '2022-11-14 21:32:38', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 30, 45129, 'orientador', NULL, '2022-11-17 19:01:10', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 16, 69935, 'orientador', NULL, '2022-11-18 12:16:44', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 3, 21856, 'orientador', NULL, '2022-11-18 18:16:44', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 12, 21856, 'orientador', NULL, '2022-11-18 18:19:19', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 31, 71569, 'orientador', NULL, '2022-11-22 15:37:02', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 21, 71569, 'orientador', NULL, '2022-11-22 22:57:02', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL,
  `periodo_curso` varchar(20) DEFAULT NULL,
  `nome_curso` varchar(60) NOT NULL,
  `matricula_coordenador` int(11) DEFAULT NULL,
  `horas` int(11) NOT NULL DEFAULT '12'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id_curso`, `periodo_curso`, `nome_curso`, `matricula_coordenador`, `horas`) VALUES
(1, 'Noite', 'Análise e Desenvolvimento de Sistemas', 45129, 12),
(2, 'Manhã', 'Redes de Computadores', 51415, 12),
(3, 'Noite', 'Comércio Exterior', 23660, 12),
(4, 'Manhã', 'Gestão de Serviços', 45675, 12),
(5, 'Tarde', 'Gestão Empresarial', 55170, 12),
(6, 'Noite', 'Gestão Empresarial', 55170, 12),
(7, 'Manhã', 'Logística Aeroportuária', 20790, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `docente`
--

CREATE TABLE `docente` (
  `matricula_docente` int(11) NOT NULL,
  `nome_docente` varchar(70) NOT NULL,
  `status_docente` tinyint(1) NOT NULL,
  `TipoUsuario_docente` int(1) DEFAULT '2',
  `qtdHAE` int(11) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `qtdPTG` int(2) NOT NULL,
  `qtdTG` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `docente`
--

INSERT INTO `docente` (`matricula_docente`, `nome_docente`, `status_docente`, `TipoUsuario_docente`, `qtdHAE`, `senha`, `qtdPTG`, `qtdTG`) VALUES
(276, 'João Manoel de Campos', 1, 1, 0, '6d363479c97439b921ad2bcba054992d8eda9a0c', 0, 0),
(408, 'Eugênio Tadeu Bertagnoli', 1, 1, 0, 'beba4d5d3ffb8fac7fe5ce87ac1eb2f75c4cd1a2', 0, 0),
(9324, 'Ivanete Bellucci Pires de Alme', 1, 1, 0, '3c8e2662d780e327599fe1291f295b89ee434599', 0, 0),
(11224, 'Reinaldo Toso Junior', 1, 1, 0, 'cd6a5336ad43cdac6fec2852678741899b6ad884', 0, 0),
(11482, 'Gerson Pastre de Oliveira', 1, 1, 0, '978e11beb222867042ce2edb00adeb6342acc1dc', 0, 0),
(12002, 'Danilo Sergio Sorroce', 1, 1, 0, 'e6cce22f31a0aabd0396c382996dad590fe5a4d3', 0, 0),
(12065, 'Cláudio Roberto Leandro', 1, 1, 0, '370a84043f43d2714a7bb4383c9577bd0f5bf297', 0, 0),
(12210, 'Silma Carneiro Pompeu', 1, 1, 0, 'c2d6cb80001290aa43de21c305e2fcb7dd6192ae', 0, 0),
(13836, 'Dilermando Piva Junior', 1, 1, 0, '40f461e075cec488615fac5113958c6e6cf40e16', 0, 0),
(17274, 'João Cantarelli Junior', 1, 1, 0, 'ad22f16b222761c9377569c5858bfa862d7c80d9', 0, 0),
(17684, 'Wilton Sturm', 1, 1, 0, 'b500d03f24b7fdd1f32ac63ce2f8dd5394b41b29', 0, 0),
(18192, 'Wilson José de Oliveira', 1, 1, 0, '9f71664fe789d2321f44b75974925f605cfd4ff4', 0, 0),
(18880, 'Magali Barçante', 1, 1, 0, '90f74b0750f53d925337e7a5c1f83e4368a5c7c7', 0, 0),
(18960, 'Sérgio Furgeri', 1, 1, 1, '9322788353ed6b8df7c5f8eb185ee85920748a88', 0, 2),
(18962, 'Viviane Di Battisti', 1, 1, 0, '587af0af378cd09e3aaa1aedb5ca328a1b07485c', 0, 0),
(19968, 'Yara Brito Brasileiro', 1, 1, 0, '0875dd6b9299e83d6c8a59de4004fed6fa90306e', 0, 0),
(20790, 'Sandro Roberto da Silva Calabr', 1, 1, 3, 'e523650f0159ac2379f1e350fedac87c7c979957', 0, 0),
(21856, 'Sérgio Donisete Clauss', 1, 1, 10, 'f9e068a3f857c378ff442513e14e5248140b9936', 3, 2),
(23659, 'Francisco Carlos Benedetti', 1, 1, 0, 'ba044b0f77ce094cf3b35ca10424a963c1fd4749', 0, 0),
(23660, 'Ricardo Sérgio Neiva Nóbrega', 1, 3, 0, '35f98d8bc9bbf0353d0aca80733a97909a13cafd', 0, 0),
(23661, 'Virgílio Itauiti Panzetti', 1, 1, 0, 'd378740d733aa286e8d0d33e4999e74d4ea249bb', 0, 0),
(26444, 'José Luiz Marques', 1, 1, 0, 'b68b48aad6582b549c5c517a56ab369d40dfe71e', 0, 0),
(26451, 'Aldo Nascimento Pontes', 1, 1, 0, '3dfc5bfee68725b7f8c5b2c4c20776f4571f6c39', 0, 0),
(26589, 'Maria Margarida Massignan de A', 1, 1, 0, '5183079626343aa7f87bcca5ed2063f46146598b', 0, 0),
(29634, 'Osvaldino Brandão Junior', 1, 1, 0, '28a016f14d52ee5d002925209388d68a7f2b2a40', 0, 0),
(30066, 'Maria das Graças Tomazela', 1, 1, 1, '873467d318a65d61c31a9862e8b2daea85000cdd', 0, 2),
(34416, 'Elisiane Sartori Menezes Garci', 1, 1, 0, '46d4ba4834b08128d79e236fc9c7161b0015d3c6', 0, 0),
(34417, 'Vera Márcia Gabaldi', 1, 1, 0, 'f31dea193e7feb41e047343def7e080635510fc0', 0, 0),
(38457, 'Jaime Alexandre Matiuso', 1, 1, 0, 'c8cf42d86a134b53818a4d076d380fababbf6d2c', 0, 0),
(38468, 'Carlos Antonio Fragoso', 1, 1, 0, '6e9c2014c5f5a1ec3d9bc5a6b0a257c371531eb4', 0, 0),
(38608, 'Valter Castelhano de Oliveira', 1, 1, 0, '0c614959d570fd960d273a49ef3e9bdff177c0dd', 0, 0),
(42794, 'Célio Aparecido Garcia', 1, 1, 0, 'eef6b8874c676fa3690008d36913359998ea3599', 0, 0),
(43591, 'João Carlos de Campos Feital', 1, 1, 0, '39e1c6e816b52a55c5aed6c895b991887a76ac66', 0, 0),
(43597, 'Rosana Helena Nunes', 1, 1, 0, '71f249565bb0710da7b53edba8786014ba6bee8b', 0, 0),
(43634, 'André Luiz Silva', 1, 1, 1, 'ecfd0d59d20b5dfca877daf2989e7dd87a16757d', 0, 1),
(43636, 'Vilma Maria de Lima', 1, 1, 0, '6e0c3952e2be9c193805a176ccd3c4d278192379', 0, 0),
(43639, 'Elenir Almeida Silva', 1, 1, 0, 'ff4c5ad7db52d8a8bac98cd68e0e56a2bd475fb9', 0, 0),
(44857, 'Carlos Henrique Dias', 1, 1, 0, '938a153af380701253ef99364349442e331fd32f', 0, 0),
(45119, 'Lincon Moreira Peretto', 1, 1, 1, '5cb9a0206108786ebdf1b32cd0d8066d5a4ba29b', 0, 2),
(45129, 'Michel Moron Munhoz', 1, 2, 9, 'c06ddea88c5aa05e52f64a83f734d89ee266fbae', 14, 0),
(45188, 'Paulo Roberto Nunes Fortaleza', 1, 1, 0, '051d302965a4e19d5de98a35483120468a72dac8', 0, 0),
(45192, 'Luciana de Carvalho', 1, 1, 0, 'd8702c295e4a9476c3d31e1694fbb318711922f9', 0, 0),
(45675, 'Juliana Silva Watanabe', 1, 2, 0, 'eb4eabf059a430b5de037061b1a5f19b33fed0ba', -1, 0),
(46479, 'Carlos Antonio de Lima Penhalb', 1, 1, 0, '1635bf40a509295261a95bef27111fe6f930de08', 0, 0),
(46484, 'Lilian Simão Oliveira', 1, 1, 1, 'ebe77dd7638686ed81d4c9de11b763d094072cc4', 0, 2),
(46485, 'Janaine Cristiane de Souza Ara', 1, 1, 0, 'cc3eb42c83509e370a7945cc3cc0cf5bd9d1461d', 0, 0),
(46487, 'Simone Tiemi Taketa Bicalho', 1, 1, 0, '1699858c3845d626b17c6a30a134b9c3545d6815', 0, 0),
(47972, 'Alexandre Serrano', 1, 1, 0, '0c9eb79e1081ca140675e55c603ab21f274ee416', 0, 0),
(47974, 'Rita Maria Cunha Leite Coentro', 1, 1, 0, 'b3444902668d43c32aa2378e1e9f2747fa443f7f', 0, 0),
(47975, 'José Renato de Siqueira Lopes', 1, 1, 0, 'e5c49fae3bc90e3a67ac2c230573ead5c9a9cc1e', 0, 0),
(47977, 'Renata Pierri Lucietto Rossett', 1, 1, 0, '4414594001ec7e8beb46a06731661be2a46b34ba', 0, 0),
(47979, 'José Estanislau Sigrist', 1, 1, 0, 'af91b6ae2ba492d54b6d9ab8d0a6a2e5e0d00c53', 0, 0),
(51404, 'André Meschiatti Nogueira', 1, 1, 0, 'c7618f9112f8dbde4c0708c714bfad45759fa1b8', 0, 0),
(51409, 'Edson Luiz Pereira', 1, 1, 0, 'd6170adfe4808861e40057f49c80987752e59c7c', 0, 0),
(51411, 'Marcelo Carvalho Costa', 1, 1, 0, 'f5aea892b22268701ea34f0b729f069e1c77bb1d', 0, 0),
(51415, 'Wellington Roque', 1, 2, 10, '94db4f7e5014bfbe60da72e4ce72e7255c36dd48', 0, 3),
(55167, 'Leila Ribeiro de Caldas', 1, 1, 0, '6e57952e6bcbb7faf8b347410cad5d70b22a726c', 0, 0),
(55170, 'Benedito Carlos Florêncio Silv', 1, 2, 0, 'b3976e5856692a72149f07f70b3f9e2df4398cf9', 0, 0),
(55171, 'Carlos Alberto Bucheroni', 1, 1, 0, '7e5106bbe7327d86f3b9c580e8a76b62a605fa72', 0, 0),
(55174, 'Laerte Zotte Junior', 1, 1, 0, '050a4e319600f893a48cd294ad3393fdf7ccf04a', 0, 0),
(55182, 'Talita Annunciato Rodrigues', 1, 1, 0, '89e721dfc4a24bf2c8bfd66efebfb31441cb7bea', 0, 0),
(55185, 'Osmar Alves Teixeira', 1, 1, 0, 'bed43d496345bc50fd7d5d3e9056fabc29dcb502', 0, 0),
(55186, 'José William Pinto Gomes', 1, 1, 1, '4525967791967ad34c9231345e7ee1311ae3ba8c', 0, 2),
(55189, 'Eliane Zambon Victorelli Dias', 1, 1, 0, '5b6f7def97fded875fb4f6d7ee8f41e64dd11f23', 0, 0),
(55190, 'Rafaeli Cardozo Modolo Begalli', 1, 1, 0, 'e21e88df5b5ace3da17e681eb66a9e64a29f8fc3', 0, 0),
(55191, 'Jones Artur Gonçalves', 1, 1, 0, '3bdafa18d6bb1a575cf14f5e7c47b5f3f378811b', 0, 0),
(55192, 'Wylds Carlos Giusti', 1, 1, 0, '3fa9fed52ad8e22678b67962b654832499bd198a', 0, 0),
(56433, 'Sérgio Scuotto', 1, 1, 0, '1605ca5a317199f330f270da2bd885fa506123c6', 0, 0),
(57335, 'Rogerio Antonio Alves', 1, 1, 0, 'bd13843806ba390826d2dbdbf89e9d76a58961c7', 0, 0),
(57342, 'Maria Fernanda Grosso Lisboa', 1, 1, 0, '2b9594b84627ea46e63b8f15ec459f54757515f5', 0, 0),
(65639, 'Valeria Scomparim', 1, 1, 0, '141a047b81b8f1f09197e9551b99aee8f1d91b80', 0, 0),
(66989, 'Alexandre Rodrigues de Oliveir', 1, 1, 0, '87b43b55e5b637953ddef6e0aea38a5a966adac4', 0, 0),
(67281, 'Jorge Antonio Luiz', 1, 1, 0, '4dcc1d614cbe57ef1fe31b8e8209057bfeff8584', 0, 0),
(67489, 'Marcio Maestrello', 1, 1, 0, '0bb0ac7a2f41eedc954e55cc6b0567231503821d', 0, 0),
(67612, 'Inacio Henrique Yano', 1, 1, 0, '938471e81aab69953a6a34218f42eb05c158d7ec', 0, 0),
(67807, 'Angela Trimer de Oliveira', 1, 1, 0, '44b1a3fe462db14820720a465203bb6a76c2cd7a', 0, 0),
(68003, 'Valmir Tadeu Fernandes', 1, 1, 0, 'b0b7c4e99731c6069240b69d1b8ea2f3ff31048c', 0, 0),
(68088, 'Andre Luis Egreggio', 1, 1, 0, 'ad9a0073671c4ad07d50b2ba22fd7f84476a5f4d', 0, 0),
(68437, 'Edson Mendes', 1, 1, 0, '99230afc7b0a5ef8e6b7cfe0a73d07b90f1f98ed', 0, 0),
(69448, 'Joclenes Emilio Diehl', 1, 1, 0, '33cba9bedb0f143c313b1e7f1ebe20f4f7aaa7f2', 0, 0),
(69733, 'Moacir José Teixeira', 1, 1, 0, 'b780b8910374de67126913d0fd6e142fac110182', 0, 0),
(69808, 'Daiane Roncato Cardozo', 1, 1, 0, '10812af85fb673e102ed4d1a85cdddccd3b8c13e', 0, 0),
(69935, 'Helder Pestana', 1, 1, 1, '856211b1a13061416c7673fa6469924e78e4fd16', 0, 2),
(70033, 'Adriana Monteiro da Silva', 1, 1, 0, '4cd280da593c63f2d139b0cb783aad805d3e4440', 0, 0),
(70125, 'Tamires Freire Silva', 1, 1, 0, 'ff1b3a60876af9fa68a1de523428953563aecc3e', 0, 0),
(70167, 'Rogério Rodolfo Baptista', 1, 1, 0, '76d2b044e9f105691898e004fd42f89430872292', 0, 0),
(70792, 'Alexandre Ribeiro Arantes', 1, 1, 0, '11c922bae05d5a74a680814d4406037b5109dd67', 0, 0),
(71007, 'Cesar Augusto Della Piazza', 1, 1, 0, 'a3047060c278172fdfe6801d351dcb1b3649c94e', 0, 0),
(71095, 'Renato Labbate', 1, 1, 0, '9767d11c8934c4e1b06ff9e4d9041481db9c32f7', 0, 0),
(71394, 'Valdinette Doria', 1, 1, 0, 'e4de8653731f8b2bd72093e9b6f731de68b314e1', 0, 0),
(71395, 'Luis Fernando Adorno da Silva', 1, 1, 0, '2ed2255e0da9161cb4ebb1a2c669a396c27e461c', 0, 0),
(71505, 'Luciene Novais Mazza', 1, 1, 0, 'c8feeadad035e2c50c0e4af03f526adbc717dec4', 0, 0),
(71508, 'Simone Mendes', 1, 1, 0, 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', 0, 0),
(71522, 'Bernardino de Jesus Sanches', 1, 1, 0, '943ace90cf88fb4b265604007c7606571680d477', 0, 0),
(71567, 'Alex Rodrigo Moises Costa Wand', 1, 1, 0, '750de1db04d85db860bc005878521d367bc672f3', 0, 0),
(71568, 'Simone Mendes da Silva', 1, 2, 1, '779a923d69b2e072747b11975ba86949de167037', 0, 2),
(71569, 'Marcio Rogerio Santos Ferraz', 1, 2, 11, 'a629b969aab6900d13fee2cad214e5d7f4b56371', 0, 2),
(71607, 'Luiz Fernando Fontana Rodrigues Moledo', 1, 1, 0, 'cb0d147440447ecd8c15281811df2b9165367a67', 0, 0),
(72247, 'Sérgio Gustavo Medina', 1, 1, 0, '3c3f87b583ba4a292b9634a36194a8fb24e20c70', 0, 0),
(72475, 'Barbara Regina Lopes Costa', 1, 1, 0, '315ea9f97da2c7678d9b8b0239778f1901db06ac', 0, 0),
(72601, 'Ailton Bueno Scorsoline', 1, 1, 0, '359d875dee25cd44c5cc0448f449f057d7ca1cb8', 0, 0),
(73165, 'Claudinei Portilho Matheus', 1, 1, 0, '716842ce9337e6f261eacde4e6c22d70427165ed', 0, 0),
(73167, 'Jorge Luiz Antonio', 1, 1, 0, 'e42e17e53e24bd25ef85078ebcc2eeafa1d910af', 0, 0),
(73233, 'Maria Eugenia Cauduro Cruz', 1, 1, 0, '8ac9561ec59f09351dc9b4cf712073765c2d572a', 0, 0),
(73463, 'JOSE AUGUSTO DIAS MOME', 1, 1, 10, 'dbc2be0c20a4b24a84fb6a48e648b3166f12e75a', 2, 2);

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
,`nome_docente` varchar(70)
,`nome_aluno` varchar(50)
,`retornar_nome_dupla(ptg.dupla_ptg)` varchar(50)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `listar_vinculotg`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `listar_vinculotg` (
`professor` int(11)
,`aluno` bigint(20)
,`semestre` int(11)
,`dupla_tg` bigint(20)
,`nome_docente` varchar(70)
,`nome_aluno` varchar(50)
,`retornar_nome_dupla(tg.dupla_tg)` varchar(50)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `senha` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `senha`, `tipo`) VALUES
(71569, '7b0451eac3c93870d011cb49ab9d1723b454f614', 3);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `viewDocentePTG`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `viewDocentePTG` (
`matricula` int(11)
,`nome` varchar(70)
,`ptgs` bigint(21)
,`nrHAE` int(11)
,`disponivel` bigint(12)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `viewDocenteTG`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `viewDocenteTG` (
`matricula` int(11)
,`nome` varchar(70)
,`tgs` bigint(21)
,`nrHAE` int(11)
,`disponivel` bigint(12)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vinculoptg`
--

CREATE TABLE `vinculoptg` (
  `id_vinculoPTG` int(11) NOT NULL,
  `professor` int(11) NOT NULL,
  `aluno` bigint(20) NOT NULL,
  `semestre` int(11) NOT NULL,
  `dupla_ptg` bigint(20) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `primeira_nota` decimal(10,2) DEFAULT NULL,
  `link_video` varchar(100) DEFAULT NULL,
  `link_drive` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vinculoptg`
--

INSERT INTO `vinculoptg` (`id_vinculoPTG`, `professor`, `aluno`, `semestre`, `dupla_ptg`, `titulo`, `primeira_nota`, `link_video`, `link_drive`) VALUES
(3, 21856, 1050481813051, 20222, 0, NULL, '0.00', NULL, NULL),
(4, 21856, 1050481823024, 20222, 0, 'IF Comics', '2.10', 'OWE0f_UeB3Q', 'https://fatecspgov-my.sharepoint.com/:f:/g/personal/fabio_rodrigues28_fatec_sp_gov_br/EnMD1i23O6NGov'),
(5, 21856, 1050481913004, 20222, 0, 'Money Manager – Sistema de gestão financeira', '1.80', 'WWWyC07MLi4', 'https://drive.google.com/drive/folders/1XUgkpjeV1SBKl0SIq66yDsGLEJXBLcZT'),
(8, 45129, 1050482013018, 20222, 0, NULL, '0.00', NULL, NULL),
(10, 45129, 1050482113012, 20222, 0, '', '0.00', '', ''),
(11, 45129, 1050482113013, 20222, 1050482113033, NULL, '0.00', NULL, NULL),
(14, 45129, 1050482113040, 20222, 0, NULL, '0.00', NULL, NULL),
(15, 45129, 1050482113042, 20222, 0, NULL, '0.00', NULL, NULL),
(16, 45129, 1050482113046, 20222, 0, NULL, '0.00', NULL, NULL),
(21, 73463, 1050481923050, 20222, 0, 'APLICATIVO PARA REALIZAR O CONTROLE DE ESTOQUE RESIDENCIAL – DESPENSA DIGITAL', '2.40', 'q0HL7nfVy0c', 'https://drive.google.com/drive/folders/15Dmw_7aZkzmEQFxDIJNmMVNWQTRnrTFj?usp=share_link'),
(31, 21856, 1050481923043, 20222, 1050481923015, 'ANÁLISE DE USABILIDADE E ACESSIBILIDADE DE UM SITE DA PREFEITURA DO INTERIOR DO ESTADO DE SÃO PAULO', '3.00', 'Uk46acTBfCs', 'https://drive.google.com/drive/folders/1eS2CDD3bPk9J8kZiXOwCCT_bWT8D63U0'),
(33, 45129, 1050482113021, 20222, 1050481913049, NULL, '0.00', NULL, NULL),
(34, 45129, 1050481923032, 20222, 1050291721002, NULL, '0.00', NULL, NULL),
(35, 45129, 1050482113032, 20222, 1050482113026, NULL, '0.00', NULL, NULL),
(36, 45129, 1050482013023, 20222, 1050482013032, NULL, '0.00', NULL, NULL),
(37, 73463, 1050482013034, 20222, 1050482013019, 'Easy Food', '2.50', 'shK9A3MyCVU', 'https://drive.google.com/drive/folders/1H5ErQSK1UNVUNsDEE9JyceRxuOJp05pi?usp=sharing'),
(38, 45129, 1050482223045, 20222, 0, NULL, NULL, NULL, NULL),
(39, 45129, 1050482113048, 20222, 1050482113018, NULL, NULL, NULL, NULL),
(40, 45129, 1050481923017, 20222, 1050481923029, NULL, NULL, NULL, NULL);

--
-- Acionadores `vinculoptg`
--
DELIMITER $$
CREATE TRIGGER `T_delete_vinculoptg` BEFORE DELETE ON `vinculoptg` FOR EACH ROW BEGIN
	DELETE FROM bancaptg WHERE vinculoptg = OLD.id_vinculoptg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `vinculoptg_Delete` AFTER DELETE ON `vinculoptg` FOR EACH ROW BEGIN
	UPDATE docente SET qtdPTG = qtdPTG - 1
WHERE matricula_docente = OLD.professor;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `vinculoptg_Insert` AFTER INSERT ON `vinculoptg` FOR EACH ROW BEGIN
	UPDATE docente SET qtdPTG = qtdPTG + 1
WHERE matricula_docente = NEW.professor;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vinculotg`
--

CREATE TABLE `vinculotg` (
  `id_vinculoTG` int(11) NOT NULL,
  `professor` int(11) NOT NULL,
  `aluno` bigint(20) NOT NULL,
  `semestre` int(11) NOT NULL,
  `dupla_tg` bigint(20) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `primeira_nota` decimal(10,2) DEFAULT NULL,
  `link_video` varchar(100) DEFAULT NULL,
  `link_drive` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vinculotg`
--

INSERT INTO `vinculotg` (`id_vinculoTG`, `professor`, `aluno`, `semestre`, `dupla_tg`, `titulo`, `primeira_nota`, `link_video`, `link_drive`) VALUES
(1, 18960, 1050482013006, 20222, 0, '', NULL, '', ''),
(2, 18960, 1050482013011, 20222, 1050482013027, 'Dev Start', NULL, 'bD4lcT2oHdE', 'https://drive.google.com/drive/folders/1iUC5SsJCMV0FY_uCx1MYnIvCB9EIp7W0?usp=sharing'),
(3, 21856, 1050482013015, 20222, 1050482023036, NULL, '9.00', NULL, NULL),
(4, 30066, 1050481923024, 20222, 0, '', NULL, '', ''),
(5, 30066, 1050482013008, 20222, 1050482013045, 'SUPHER Pets: SISTEMA DE UNIÃO PARA HEMOCENTROS E RESPONSÁVEIS POR PETS', NULL, 'sc3fbyCzHuU', 'https://drive.google.com/drive/folders/1o6ZJN3nII0XfVsO9TfOWnM8OoEK2kCVG'),
(6, 43634, 1050482023044, 20222, 1050482023034, NULL, '10.00', NULL, NULL),
(7, 45119, 1050481913014, 20222, 0, '', NULL, '', ''),
(8, 45119, 1050482023016, 20222, 1050482113010, NULL, NULL, NULL, NULL),
(9, 45129, 1050481923053, 20222, 1050481923011, '', '0.00', '', ''),
(10, 46484, 1050481923025, 20222, 0, '', NULL, '', ''),
(11, 46484, 1050482023018, 20222, 1050482023006, 'Algoritmo de precificação dinâmica aplicado a um sistema de aluguel de brinquedos', NULL, 'cOGXHWYQf9Q', 'https://fatecspgov-my.sharepoint.com/:f:/g/personal/otavio_faccioli_fatec_sp_gov_br/EiyoTKx3_RJAqwbQ'),
(12, 21856, 1050481813051, 20222, 0, '', '0.00', '', ''),
(13, 51415, 1050481923043, 20222, 0, '', NULL, '', ''),
(14, 55186, 1050481923013, 20222, 0, '', NULL, '', ''),
(15, 55186, 1050482013030, 20222, 1050482013017, 'Murcash - Gerenciador de gastos compartilhados', '10.00', 'jE2WaGRKG5Y', 'https://drive.google.com/drive/folders/1_jmkbOfnMmFlqZfwEbia9-t9dWC18jze'),
(16, 69935, 1050482023023, 20222, 0, '', '7.00', '', ''),
(17, 69935, 1050482023026, 20222, 1050482013037, NULL, NULL, NULL, NULL),
(18, 71568, 1050481913023, 20222, 1050481913051, 'APLICATIVO PARA ENCONTROS ESPORTIVOS', '8.00', '8GTIk6xpDP8', 'https://drive.google.com/drive/folders/1pmLdQS2uZx6WzE0WIfj-XId0FywcQFM2?usp=share_link'),
(19, 71568, 1050482013005, 20222, 0, '', '0.00', '', ''),
(21, 71569, 1050481913048, 20222, 0, 'Fatask: Plataforma para gerenciamento de atividades', '9.00', 'zAhvEtJf2xs', 'https://drive.google.com/drive/folders/1UA8DUCArdgATquN3s8VGtwxFq6FzBcMn'),
(23, 73463, 1050482023005, 20222, 0, '', NULL, '', ''),
(24, 73463, 1050482023021, 20222, 1050482023014, '', NULL, '', ''),
(30, 45129, 1050622013028, 20222, 0, '', '10.00', '', ''),
(31, 71569, 1050481823001, 20222, 0, 'Relatório  Fácil', '9.10', 'I65hl9DcK94', 'https://drive.google.com/drive/folders/1A1zwS6TA_HdCFsvt472sVSIuDP7gZvtj?usp=share_link');

--
-- Acionadores `vinculotg`
--
DELIMITER $$
CREATE TRIGGER `T_delete_vinculotg` BEFORE DELETE ON `vinculotg` FOR EACH ROW BEGIN
	DELETE FROM bancatg WHERE vinculotg = OLD.id_vinculotg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `vinculotg_Delete` AFTER DELETE ON `vinculotg` FOR EACH ROW BEGIN
	UPDATE docente SET qtdTG = qtdTG - 1
WHERE matricula_docente = OLD.professor;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `vinculotg_Insert` AFTER INSERT ON `vinculotg` FOR EACH ROW BEGIN
	UPDATE docente SET qtdTG = qtdTG + 1
WHERE matricula_docente = NEW.professor;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para vista `listar_vinculoptg`
--
DROP TABLE IF EXISTS `listar_vinculoptg`;

CREATE ALGORITHM=UNDEFINED DEFINER=`fatecidc`@`localhost` SQL SECURITY DEFINER VIEW `listar_vinculoptg`  AS SELECT `ptg`.`professor` AS `professor`, `ptg`.`aluno` AS `aluno`, `ptg`.`semestre` AS `semestre`, `ptg`.`dupla_ptg` AS `dupla_ptg`, `d`.`nome_docente` AS `nome_docente`, `a`.`nome_aluno` AS `nome_aluno`, `retornar_nome_dupla`(`ptg`.`dupla_ptg`) AS `retornar_nome_dupla(ptg.dupla_ptg)` FROM ((`vinculoptg` `ptg` join `docente` `d`) join `aluno` `a`) WHERE ((`ptg`.`professor` = `d`.`matricula_docente`) AND (`ptg`.`aluno` = `a`.`ra_aluno`)) ;

-- --------------------------------------------------------

--
-- Estrutura para vista `listar_vinculotg`
--
DROP TABLE IF EXISTS `listar_vinculotg`;

CREATE ALGORITHM=UNDEFINED DEFINER=`fatecidc`@`localhost` SQL SECURITY DEFINER VIEW `listar_vinculotg`  AS SELECT `tg`.`professor` AS `professor`, `tg`.`aluno` AS `aluno`, `tg`.`semestre` AS `semestre`, `tg`.`dupla_tg` AS `dupla_tg`, `d`.`nome_docente` AS `nome_docente`, `a`.`nome_aluno` AS `nome_aluno`, `retornar_nome_dupla`(`tg`.`dupla_tg`) AS `retornar_nome_dupla(tg.dupla_tg)` FROM ((`vinculotg` `tg` join `docente` `d`) join `aluno` `a`) WHERE ((`tg`.`professor` = `d`.`matricula_docente`) AND (`tg`.`aluno` = `a`.`ra_aluno`)) ;

-- --------------------------------------------------------

--
-- Estrutura para vista `viewDocentePTG`
--
DROP TABLE IF EXISTS `viewDocentePTG`;

CREATE ALGORITHM=UNDEFINED DEFINER=`fatecidc`@`localhost` SQL SECURITY DEFINER VIEW `viewDocentePTG`  AS SELECT `d`.`matricula_docente` AS `matricula`, `d`.`nome_docente` AS `nome`, count(`d`.`matricula_docente`) AS `ptgs`, `numeroHAEsPTG`(count(`d`.`matricula_docente`)) AS `nrHAE`, (`d`.`qtdHAE` - `numeroHAEsPTG`(count(`d`.`matricula_docente`))) AS `disponivel` FROM (`docente` `d` join `vinculoptg` `v`) WHERE (`d`.`matricula_docente` = `v`.`professor`) GROUP BY `d`.`matricula_docente` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `viewDocenteTG`
--
DROP TABLE IF EXISTS `viewDocenteTG`;

CREATE ALGORITHM=UNDEFINED DEFINER=`fatecidc`@`localhost` SQL SECURITY DEFINER VIEW `viewDocenteTG`  AS SELECT `d`.`matricula_docente` AS `matricula`, `d`.`nome_docente` AS `nome`, count(`d`.`matricula_docente`) AS `tgs`, `numeroHAEsTG`(count(`d`.`matricula_docente`)) AS `nrHAE`, (`d`.`qtdHAE` - `numeroHAEsTG`(count(`d`.`matricula_docente`))) AS `disponivel` FROM (`docente` `d` join `vinculotg` `v`) WHERE (`d`.`matricula_docente` = `v`.`professor`) GROUP BY `d`.`matricula_docente` ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`ra_aluno`);

--
-- Índices para tabela `assinatura`
--
ALTER TABLE `assinatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricula_docente` (`matricula_docente`);

--
-- Índices para tabela `bancaptg`
--
ALTER TABLE `bancaptg`
  ADD PRIMARY KEY (`codBanca`),
  ADD KEY `vinculoPTG` (`vinculoPTG`),
  ADD KEY `professor` (`professor`);

--
-- Índices para tabela `bancatg`
--
ALTER TABLE `bancatg`
  ADD PRIMARY KEY (`codBanca`),
  ADD KEY `vinculoTG` (`vinculoTG`),
  ADD KEY `professor` (`professor`);

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
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `vinculoptg`
--
ALTER TABLE `vinculoptg`
  ADD PRIMARY KEY (`id_vinculoPTG`),
  ADD KEY `aluno` (`aluno`),
  ADD KEY `dupla_ptg` (`dupla_ptg`),
  ADD KEY `professor` (`professor`);

--
-- Índices para tabela `vinculotg`
--
ALTER TABLE `vinculotg`
  ADD PRIMARY KEY (`id_vinculoTG`),
  ADD KEY `aluno` (`aluno`),
  ADD KEY `dupla_tg` (`dupla_tg`),
  ADD KEY `professor` (`professor`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `assinatura`
--
ALTER TABLE `assinatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `bancaptg`
--
ALTER TABLE `bancaptg`
  MODIFY `codBanca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `bancatg`
--
ALTER TABLE `bancatg`
  MODIFY `codBanca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `vinculoptg`
--
ALTER TABLE `vinculoptg`
  MODIFY `id_vinculoPTG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `vinculotg`
--
ALTER TABLE `vinculotg`
  MODIFY `id_vinculoTG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `assinatura`
--
ALTER TABLE `assinatura`
  ADD CONSTRAINT `assinatura_ibfk_1` FOREIGN KEY (`matricula_docente`) REFERENCES `docente` (`matricula_docente`);

--
-- Limitadores para a tabela `bancaptg`
--
ALTER TABLE `bancaptg`
  ADD CONSTRAINT `bancaptg_ibfk_1` FOREIGN KEY (`vinculoPTG`) REFERENCES `vinculoptg` (`id_vinculoPTG`),
  ADD CONSTRAINT `bancaptg_ibfk_2` FOREIGN KEY (`professor`) REFERENCES `docente` (`matricula_docente`);

--
-- Limitadores para a tabela `bancatg`
--
ALTER TABLE `bancatg`
  ADD CONSTRAINT `bancatg_ibfk_1` FOREIGN KEY (`vinculoTG`) REFERENCES `vinculotg` (`id_vinculoTG`),
  ADD CONSTRAINT `bancatg_ibfk_2` FOREIGN KEY (`professor`) REFERENCES `docente` (`matricula_docente`);

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`matricula_coordenador`) REFERENCES `docente` (`matricula_docente`);

--
-- Limitadores para a tabela `vinculoptg`
--
ALTER TABLE `vinculoptg`
  ADD CONSTRAINT `vinculoptg_ibfk_1` FOREIGN KEY (`professor`) REFERENCES `docente` (`matricula_docente`),
  ADD CONSTRAINT `vinculoptg_ibfk_2` FOREIGN KEY (`aluno`) REFERENCES `aluno` (`ra_aluno`);

--
-- Limitadores para a tabela `vinculotg`
--
ALTER TABLE `vinculotg`
  ADD CONSTRAINT `vinculotg_ibfk_1` FOREIGN KEY (`professor`) REFERENCES `docente` (`matricula_docente`),
  ADD CONSTRAINT `vinculotg_ibfk_2` FOREIGN KEY (`aluno`) REFERENCES `aluno` (`ra_aluno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
