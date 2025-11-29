<?php
session_start();
require_once "../config/config.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Get today's date
$today = date('Y-m-d');

// Fetch today's devotion
$stmt = $conn->prepare("SELECT * FROM devotions WHERE date=? LIMIT 1");
$stmt->bind_param("s", $today);
$stmt->execute();
$devotion = $stmt->get_result()->fetch_assoc();

// Check if user already marked it as read
$is_read = false;
if ($devotion) {
    $stmt2 = $conn->prepare("SELECT * FROM user_progress WHERE user_id=? AND devotion_id=? LIMIT 1");
    $stmt2->bind_param("ii", $user_id, $devotion['id']);
    $stmt2->execute();
    $is_read = $stmt2->get_result()->num_rows > 0;
}

// Fetch user progress: total read vs total devotions
$total_read = $conn->query("SELECT COUNT(*) as cnt FROM user_progress WHERE user_id=$user_id")->fetch_assoc()['cnt'];
$total_devotions = $conn->query("SELECT COUNT(*) as cnt FROM devotions")->fetch_assoc()['cnt'];

// Handle marking devotion as read
if (isset($_POST['mark_read']) && $devotion && !$is_read) {
    $stmt3 = $conn->prepare("INSERT INTO user_progress (user_id, devotion_id, status) VALUES (?, ?, 'read')");
    $stmt3->bind_param("ii", $user_id, $devotion['id']);
    $stmt3->execute();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daily Devotion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($user_name) ?></h2>
    <p><a href="logout.php">Logout</a></p>

    <h3>Today's Devotion</h3>
    <?php if ($devotion): ?>
        <h4><?= htmlspecialchars($devotion['title']) ?></h4>
        <p><em><?= htmlspecialchars($devotion['scripture']) ?></em></p>
        <p><?= nl2br(htmlspecialchars($devotion['content'])) ?></p>
        <?php if ($is_read): ?>
            <p><strong>You have marked this devotion as read ✅</strong></p>
        <?php else: ?>
            <form method="POST">
                <button type="submit" name="mark_read">Mark as Read</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <p>No devotion for today.</p>
    <?php endif; ?>

    <h3>Progress</h3>
    <p><?= $total_read ?>/<?= $total_devotions ?> devotions read</p>
</div>
</body>
</html>
