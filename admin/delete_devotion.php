<?php
require_once "auth_check.php";
require_once "../config/config.php";

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM devotions WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: index.php");
exit;
