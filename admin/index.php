<?php
require_once "auth_check.php";
require_once "../config/config.php";

// Fetch all devotions
$devotions = $conn->query("SELECT * FROM devotions ORDER BY date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Daily Devotion</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?></h2>
    <p><a href="logout.php">Logout</a></p>
    <h3>Manage Devotions</h3>
    <a href="add_devotion.php"><button>Add New Devotion</button></a>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Title</th>
            <th>Scripture</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $devotions->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['scripture']) ?></td>
            <td><?= $row['date'] ?></td>
            <td>
                <a href="edit_devotion.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete_devotion.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
