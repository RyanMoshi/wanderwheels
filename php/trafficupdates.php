<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = ($_SESSION['role'] === 'admin');

if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $_POST['location'];
    $traffic_info = $_POST['traffic_info'];

    $stmt = $pdo->prepare("INSERT INTO traffic_updates (location, traffic_info) VALUES (?, ?)");
    if ($stmt->execute([$location, $traffic_info])) {
        $success = 'Traffic update added successfully.';
    } else {
        $error = 'Failed to add traffic update.';
    }
}

$stmt = $pdo->query("SELECT * FROM traffic_updates ORDER BY created_at DESC");
$traffic_updates = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Traffic Updates</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="assets/logo/logolight.png" alt="WanderWheel" class="logo">
        </div>
        <h2>Traffic Updates</h2>
        <?php if ($isAdmin): ?>
            <h3>Add Traffic Update</h3>
            <?php if (isset($success)): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php elseif (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
                
                <label for="traffic_info">Traffic Information:</label>
                <textarea id="traffic_info" name="traffic_info" required></textarea>
                
                <button type="submit">Add Update</button>
            </form>
        <?php endif; ?>
        
        <h3>Recent Updates</h3>
        <ul>
            <?php foreach ($traffic_updates as $update): ?>
                <li>
                    <strong><?php echo htmlspecialchars($update['location']); ?></strong>:
                    <?php echo htmlspecialchars($update['traffic_info']); ?>
                    <em>(<?php echo $update['created_at']; ?>)</em>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
