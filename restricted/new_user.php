<?php
require "../parameters.php";

if(empty($_POST['_token']) || ($_POST['_token'] != $_SESSION['token'])) {
	header("location: ../index.php?error=invalidCredentials");
	exit;
}

if(!empty($_POST['name']) and !empty($_POST['login']) and !empty($_POST['password'])) {
	$credentials = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	$insert = "insert into user (name, login, password) values (:name, :login, :password)";
	$stmt_insert = $database->prepare($insert);
	$stmt_insert->bindParam(':name', $credentials['name']);
	$stmt_insert->bindParam(':login', $credentials['login']);
	$stmt_insert->bindParam(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
	$stmt_insert->execute();
	header("location: admin.php?status=novoUsuarioSucesso");
	exit;
}

header("location: admin.php?status=novoUsuarioErro");
exit;

?>