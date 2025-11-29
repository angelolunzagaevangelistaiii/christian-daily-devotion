<?php
require_once "auth_check.php";
require_once "../config/config.php";

// Fetch user progress
$sql = "
    SELECT u.name AS user_name, u.email AS user_email,
           d.title AS devotion_title, d.date AS devotion_date,
           up.status, up.created_at
    FROM user_progress up
    JOIN users u ON up.user_id = u.id
    JOIN devotions d ON up.devotion_id = d.id
    ORDER BY up.created_at DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Progress - Admin</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
<div class="container">
    <h2>User Devotion Progress</h2>
    <p><a href="index.php">Back to Dashboard</a> | <a href="logout.php">Logout</a></p>
    
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>User Name</th>
            <th>Email</th>
            <th>Devotion Title</th>
            <th>Devotion Date</th>
            <th>Status</th>
            <th>Marked At</th>
        </tr>
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['user_name']) ?></td>
                <td><?= htmlspecialchars($row['user_email']) ?></td>
                <td><?= htmlspecialchars($row['devotion_title']) ?></td>
                <td><?= $row['devotion_date'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No progress recorded yet.</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
