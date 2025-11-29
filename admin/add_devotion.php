<?php
require_once "auth_check.php";
require_once "../config/config.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $scripture = trim($_POST['scripture']);
    $content = trim($_POST['content']);
    $date = $_POST['date'];

    if ($title && $scripture && $content && $date) {
        $stmt = $conn->prepare("INSERT INTO devotions (title,scripture,content,date) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss",$title,$scripture,$content,$date);
        if($stmt->execute()){
            header("Location: index.php");
            exit;
        } else {
            $error = "DB error: ".$stmt->error;
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Devotion</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
<div class="container">
    <h2>Add New Devotion</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Scripture:</label><br>
        <input type="text" name="scripture" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" required></textarea><br><br>

        <label>Date:</label><br>
        <input type="date" name="date" required><br><br>

        <button type="submit">Add Devotion</button>
    </form>
    <p><a href="index.php">Back to Dashboard</a></p>
</div>
</body>
</html>
