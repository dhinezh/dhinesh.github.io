<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-scripts/main.php';
$main = new Main();
if (isset($_POST["id"]) && isset($_POST["vehicleType"])) {
    echo $main->deleteEntryFromTables($_POST["id"], $_POST["vehicleType"]);
}
