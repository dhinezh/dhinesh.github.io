<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-scripts/main.php';
$main = new Main();
$res = $main->logout();
if($res) header("Location: ./index.php");
?>