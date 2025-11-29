<?php
session_start();
require_once "../config/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get today's devotion
$today = date('Y-m-d');
$stmt = $conn->prepare("SELECT * FROM devotions WHERE date=? LIMIT 1");
$stmt->bind_param("s",$today);
$stmt->execute();
$result = $stmt->get_result();
$devotion = $result->fetch_assoc();

// Check if user has read it
$read = false;
if ($devotion) {
    $stmt = $conn->prepare("SELECT status FROM user_progress WHERE user_id=? AND devotion_id=? LIMIT 1");
    $stmt->bind_param("ii",$user_id,$devotion['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $read = ($row['status']=='read');
    }
}

// Mark as read action
if (isset($_GET['mark_read']) && $devotion) {
    if (!$read) {
        $stmt = $conn->prepare("INSERT INTO user_progress (user_id, devotion_id, status) VALUES (?,?,?) ON DUPLICATE KEY UPDATE status='read'");
        $status = 'read';
        $stmt->bind_param("iis",$user_id,$devotion['id'],$status);
        $stmt->execute();
    }
    header("Location: index.php");
    exit;
}

// Total devotions read
$stmt = $conn->prepare("SELECT COUNT(*) AS read_count FROM user_progress WHERE user_id=? AND status='read'");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$res = $stmt->get_result();
$read_count = $res->fetch_assoc()['read_count'] ?? 0;

// Total devotions
$res_total = $conn->query("SELECT COUNT(*) AS total FROM devotions");
$total_devotions = $res_total->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daily Devotion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h2>
    <p><a href="logout.php">Logout</a></p>

    <h3>Today's Devotion</h3>
    <?php if($devotion): ?>
        <h4><?= htmlspecialchars($devotion['title']) ?></h4>
        <p><em><?= htmlspecialchars($devotion['scripture']) ?></em></p>
        <p><?= nl2br(htmlspecialchars($devotion['content'])) ?></p>
        <?php if(!$read): ?>
            <a href="?mark_read=1"><button>Mark as Read</button></a>
        <?php else: ?>
            <p><strong>✅ Already read</strong></p>
        <?php endif; ?>
    <?php else: ?>
        <p>No devotion for today.</p>
    <?php endif; ?>

    <p>Progress: <?= $read_count ?>/<?= $total_devotions ?> devotions read</p>
</div>
</body>
</html>
