<?php
require "../parameters.php";
require '../PHPExcel/PHPExcel/IOFactory.php';

if(empty($_POST['_token']) || ($_POST['_token'] != $_SESSION['token'])) {
	header("location: ../index.php?error=invalidCredentials");
	exit;
}

$inputFileName = $_FILES['planilha']['tmp_name'];

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Erro na leitura da planilha "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 

//  Loop through each row of the worksheet in turn
for ($row = 1; $row <= $highestRow; $row++){ 
    $rowData = $sheet->rangeToArray('A' . $row . ':C' . $row, NULL, TRUE, FALSE);
}

switch ($_POST['tipo']) {
	case 'papiros':
		$insert = "insert into papiro (ds, date, type) values (:ds, :date, :type)";
		$update = "update papiro set ds = :ds, date = :date, type = :type where id = :id";
		$select = "select id from papiro where ds = :ds";
	break;
	case 'unciais':
		$insert = "insert into uncial (ds, date, type) values (:ds, :date, :type)";
		$update = "update uncial set ds = :ds, date = :date, type = :type where id = :id";
		$select = "select id from uncial where ds = :ds";
	break;
	case 'minusculos':
		$insert = "insert into minusculo (ds, date, type) values (:ds, :date, :type)";
		$update = "update minusculo set ds = :ds, date = :date, type = :type where id = :id";
		$select = "select id from minusculo where ds = :ds";
	break;
	case 'lecionarios':
		$insert = "insert into lecionario (ds, date, type) values (:ds, :date, :type)";
		$update = "update lecionario set ds = :ds, date = :date, type = :type where id = :id";
		$select = "select id from lecionario where ds = :ds";
	break;
	case 'versoes':
		$insert = "insert into versao (ds, date, type) values (:ds, :date, :type)";
		$update = "update versao set ds = :ds, date = :date, type = :type where id = :id";
		$select = "select id from versao where ds = :ds";
	break;
	case 'pais':
		$insert = "insert into pai (ds, date, type) values (:ds, :date, :type)";
		$update = "update pai set ds = :ds, date = :date, type = :type where id = :id";
		$select = "select id from pai where ds = :ds";
	break;
}

$stmt_insert = $database->prepare($insert);
$stmt_update = $database->prepare($update);
$stmt_select = $database->prepare($select);

foreach($rowData as $row) {
	if(!empty($row[0]) and !empty($row[1]) and !empty($row[2])) {
		$stmt_select->bindParam(':ds', $row[0]);
		$stmt_select->execute();
		$item = $stmt_select->fetchAll();

		if(empty($item)) {
			$stmt_insert->bindParam(':ds', $row[0]);
			$stmt_insert->bindParam(':date', $row[1]);
			$stmt_insert->bindParam(':type', $row[2]);
			$stmt_insert->execute();
		} else {
			$stmt_update->bindParam(':ds', $row[0]);
			$stmt_update->bindParam(':date', $row[1]);
			$stmt_update->bindParam(':type', $row[2]);
			$stmt_update->bindParam(':id', $item[0]->id);
			$stmt_update->execute();
		}
	}
}

header("location: admin.php?status=planilhaSucesso");
exit;

?>