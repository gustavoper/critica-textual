<?php
require "../parameters.php"; 

if(empty($_POST['login']) || empty($_POST['password'])) {
	header("location: ../index.php?error=invalidCredentials");
	exit;
}

$credentials = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$sql = "select * from user where login = :login";

$stmt = $database->prepare($sql);
$stmt->bindParam(':login', $credentials['login']);
$stmt->execute();
$user = $stmt->fetchAll();

if(!empty($user) and password_verify($credentials['password'], $user[0]->password)) {
	$_SESSION['user'] = $user[0];
	$_SESSION['token'] = md5(time());
	header("location: admin.php");
	exit;
}

header("location: ../index.php?error=invalidCredentials");
exit;

?>