<?php
session_start();
require_once '../src/db.php';
require_once '../src/functions.php';
redirectIfNotLoggedIn();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $id=intval($_POST['id']);
    $stmt=$mysqli->prepare("INSERT IGNORE INTO user_progress(user_id,devotion_id,status) VALUES(?,?,?)");
    $status='read';
    $stmt->bind_param("iis", $_SESSION['user_id'], $id, $status);
    $stmt->execute();
    echo "read";
}
?>