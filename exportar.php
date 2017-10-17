<?php

/*
The Type column gives the text type of the manuscripts. It uses the following letters:
A = Alexandrian
B = Byzantine
C = Cæsarean
W = Western
M = Mixed
Sometimes also similiar manuscripts are listed.

In the Contents column the following letters are used:
e: Gospels
a: Acts and the Catholic letters in the minuscules; Acts and the letters in the Lectionaries (that did not include Revelation); Acts in the Old Italian
p: letters of Paul (including Hebrews)
c: Catholic letters
r: Revelation
A eucologia was a liturgical book, with only some readings.
*/

header('Content-Disposition: attachment; filename="critica.xlsx"');

require_once 'PHPExcel/PHPExcel.php';
require "parameters.php";

$objReader = PHPExcel_IOFactory::createReader('Excel2007');

$objPHPExcel = $objReader->load("template.xlsx");

$planilha = $objPHPExcel->getActiveSheet();

$variante = empty($_POST['variante']) ? '' : $_POST['variante'];
$traducao = empty($_POST['traducao']) ? '' : $_POST['traducao'];
$livro = empty($_POST['livro']) ? '' : $_POST['livro'];
$capitulo = empty($_POST['capitulo']) ? '' : $_POST['capitulo']; 
$versiculo = empty($_POST['versiculo']) ? '' : $_POST['versiculo'];

$planilha->setCellValue("L1", "$livro $capitulo:$versiculo");
$planilha->setCellValue("C2", "$traducao");
$planilha->setCellValue("A5", "$variante");

/*MAGIC*/
	$letters = array('A' => 'G',
					 'B' => 'C',
					 'C' => 'M',
					 'W' => 'J',
					 'M' => 'O');

	/*PAPIROS*/
		if(!empty($_POST['papiros']))
		{
			$row = 4;
			$papiros = implode(',', $_POST['papiros']);
			$papiros = $database->query("select concat(replace(ds, 'p', ''), ' (', date, ')') as conteudo, type as coluna from papiro where id in ($papiros)")->fetchAll();

			foreach($papiros as $item)
			{
				if(isset($letters[$item->coluna]))
				{
					$temp = $planilha->getCell($letters[$item->coluna].$row)->getValue();
					$temp = empty($temp) ? '' : $temp . ', ';
					$planilha->setCellValue($letters[$item->coluna].$row, $temp.$item->conteudo);
				}
			}
		}
	/*/PAPIROS*/

	/*UNCIAIS*/
		if(!empty($_POST['unciais']))
		{
			$row = 5;
			$unciais = implode(',', $_POST['unciais']);
			$unciais = $database->query("select concat(ds, ' (', date, ')') as conteudo, type as coluna from uncial where id in ($unciais)")->fetchAll();

			foreach($unciais as $item)
			{
				if(isset($letters[$item->coluna]))
				{
					$temp = $planilha->getCell($letters[$item->coluna].$row)->getValue();
					$temp = empty($temp) ? '' : $temp . ', ';
					$planilha->setCellValue($letters[$item->coluna].$row, $temp.$item->conteudo);
				}
			}
		}
	/*/UNCIAIS*/

	/*MINUSCULOS*/
		if(!empty($_POST['minusculos']))
		{
			$row = 10;
			$minusculos = implode(',', $_POST['minusculos']);
			$minusculos = $database->query("select concat(ds, ' (', date, ')') as conteudo, type as coluna from minusculo where id in ($minusculos)")->fetchAll();

			foreach($minusculos as $item)
			{
				if(isset($letters[$item->coluna]))
				{
					$temp = $planilha->getCell($letters[$item->coluna].$row)->getValue();
					$temp = empty($temp) ? '' : $temp . ', ';
					$planilha->setCellValue($letters[$item->coluna].$row, $temp.$item->conteudo);
				}
			}
		}
	/*/MINUSCULOS*/

	/*LECIONARIO*/
		if(!empty($_POST['lecionarios']))
		{
			$row = 14;
			$lecionarios = implode(',', $_POST['lecionarios']);
			$lecionarios = $database->query("select concat(replace(ds, 'l', ''), ' (', date, ')') as conteudo, type as coluna from lecionario where id in ($lecionarios)")->fetchAll();

			foreach($lecionarios as $item)
			{
				if(isset($letters[$item->coluna]))
				{
					$temp = $planilha->getCell($letters[$item->coluna].$row)->getValue();
					$temp = empty($temp) ? '' : $temp . ', ';
					$planilha->setCellValue($letters[$item->coluna].$row, $temp.$item->conteudo);
				}
			}
		}
	/*/LECIONARIO*/

	/*VERSÃO*/
		if(!empty($_POST['versoes']))
		{
			$row = 15;
			$versoes = implode(',', $_POST['versoes']);
			$versoes = $database->query("select concat(ds, ' (', date, ')') as conteudo, type as coluna from versao where id in ($versoes)")->fetchAll();

			foreach($versoes as $item)
			{
				if(isset($letters[$item->coluna]))
				{
					$temp = $planilha->getCell($letters[$item->coluna].$row)->getValue();
					$temp = empty($temp) ? '' : $temp . ', ';
					$planilha->setCellValue($letters[$item->coluna].$row, $temp.$item->conteudo);
				}
			}
		}
	/*VERSÃO*/

	/*PAIS*/
		if(!empty($_POST['pais']))
		{
			$row = 18;
			$pais = implode(',', $_POST['pais']);
			$pais = $database->query("select concat(ds, ' (', date, ')') as conteudo, type as coluna from pai where id in ($pais)")->fetchAll();

			foreach($pais as $item)
			{
				if(isset($letters[$item->coluna]))
				{
					$temp = $planilha->getCell($letters[$item->coluna].$row)->getValue();
					$temp = empty($temp) ? '' : $temp . ', ';
					$planilha->setCellValue($letters[$item->coluna].$row, $temp.$item->conteudo);
				}
			}
		}
	/*/PAIS*/
/*/MAGIC*/

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('php://output');

//fazer download
?>
