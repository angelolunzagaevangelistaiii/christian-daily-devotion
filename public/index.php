<?php
session_start();
require_once '../src/db.php';
require_once '../src/functions.php';
redirectIfNotLoggedIn();

// Get today's devotion
$today = date('Y-m-d');
$devotion = $mysqli->query("SELECT * FROM devotions WHERE devotion_date='$today'")->fetch_assoc();

// Check if user read today
$read = $mysqli->query("SELECT * FROM user_progress WHERE user_id=".$_SESSION['user_id']." AND devotion_id=".$devotion['id'])->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
<title>Daily Devotion</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
<a href="logout.php">Logout</a>
<hr>
<h2>Today's Devotion</h2>
<h3><?php echo $devotion['title']; ?> (<?php echo $devotion['scripture']; ?>)</h3>
<p><?php echo $devotion['content']; ?></p>

<?php if($read): ?>
<p><strong>Status:</strong> Read ✅</p>
<?php else: ?>
<button id="mark-read" data-id="<?php echo $devotion['id']; ?>">Mark as Read</button>
<?php endif; ?>
</div>
<script src="script.js"></script>
</body>
</html>
