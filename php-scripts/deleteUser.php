<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-scripts/main.php';
$main = new Main();
if (isset($_POST["id"])) {
    echo $main->deleteUser($_POST["id"]);
}
