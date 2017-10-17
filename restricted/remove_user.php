<?php
require "../parameters.php";

if(empty($_POST['_token']) || ($_POST['_token'] != $_SESSION['token'])) {
	header("location: ../index.php?error=invalidCredentials");
	exit;
}

if(!empty($_POST['userId'])) {
	$delete = "delete from user where id = :id";
	$stmt_delete = $database->prepare($delete);
	$stmt_delete->bindParam(':id', base64_decode($_POST['userId']));
	$stmt_delete->execute();
	header("location: admin.php?status=excluirUsuarioSucesso");
	exit;
}

header("location: admin.php?status=excluirUsuarioErro");
exit;

?>