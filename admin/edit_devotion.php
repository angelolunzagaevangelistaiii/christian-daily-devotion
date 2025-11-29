<?php
require_once "auth_check.php";
require_once "../config/config.php";

$id = $_GET['id'] ?? 0;
$error = '';

$stmt = $conn->prepare("SELECT * FROM devotions WHERE id=? LIMIT 1");
$stmt->bind_param("i",$id);
$stmt->execute();
$devotion = $stmt->get_result()->fetch_assoc();

if (!$devotion) {
    die("Devotion not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $scripture = trim($_POST['scripture']);
    $content = trim($_POST['content']);
    $date = $_POST['date'];

    if ($title && $scripture && $content && $date) {
        $stmt = $conn->prepare("UPDATE devotions SET title=?,scripture=?,content=?,date=? WHERE id=?");
        $stmt->bind_param("ssssi",$title,$scripture,$content,$date,$id);
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
    <title>Edit Devotion</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
<div class="container">
    <h2>Edit Devotion</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($devotion['title']) ?>" required><br><br>

        <label>Scripture:</label><br>
        <input type="text" name="scripture" value="<?= htmlspecialchars($devotion['scripture']) ?>" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" required><?= htmlspecialchars($devotion['content']) ?></textarea><br><br>

        <label>Date:</label><br>
        <input type="date" name="date" value="<?= $devotion['date'] ?>" required><br><br>

        <button type="submit">Update Devotion</button>
    </form>
    <p><a href="index.php">Back to Dashboard</a></p>
</div>
</body>
</html>
