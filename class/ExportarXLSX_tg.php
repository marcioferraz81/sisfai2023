<!--**
 * @author Cesar Szpak - Celke -   cesar@celke.com.br
 * @pagina desenvolvida usando framework bootstrap,
 * o código é aberto e o uso é free,
 * porém lembre -se de conceder os créditos ao desenvolvedor.
 *-->
 <?php
	include_once('Conectar.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Vínculos PTG</title>
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		$arquivo = 'vinculostg.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="3">Vinculos TG</tr>';
		$html .= '</tr>';
		
		
		$html .= '<tr>';
		$html .= '<td><b>Professor</b></td>';
		$html .= '<td><b>Aluno</b></td>';
		$html .= '<td><b>Dupla</b></td>';
		$html .= '</tr>';
		
		//Selecionar todos os itens da tabela 
		//$result_msg_contatos = "SELECT nome_docente, nome_aluno, dupla_ptg FROM `listar_vinculoptg` ORDER  BY nome_docente";
		//$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);
		
		
				$con = new Conectar();
				//$sql = "SELECT nome_docente, nome_aluno, dupla_ptg FROM `listar_vinculoptg` ORDER  BY nome_docente";
				
				$sql = "SELECT * FROM `listar_vinculotg` ORDER by professor ASC";
				$executar = $con->prepare($sql);
				$executar->execute();
				$data = $executar->fetchAll();
				
		
		foreach ($data as $row)
		{
			$html .= '<tr>';
			$html .= '<td>'.$row["nome_docente"].'</td>';
			$html .= '<td>'.$row["nome_aluno"].'</td>';
			$html .= '<td>'.$row["retornar_nome_dupla(tg.dupla_tg)"].'</td>';
			$html .= '</tr>';
			;
		}

		// Configurações header para forçar o download
	  /*header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");*/
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		//header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit; ?>
	</body>
</html>