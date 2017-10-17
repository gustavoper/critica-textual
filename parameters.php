<?php
session_start();
session_regenerate_id();
$database = new PDO("mysql:host=localhost;dbname=critica;charset=utf8", "root", "");
$database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>
