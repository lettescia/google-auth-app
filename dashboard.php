<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body text-center">
            <img src="<?= $user['profile_pic'] ?>" class="rounded-circle mb-3" width="120">
            <h3><?= $user['name'] ?></h3>
            <p><?= $user['email'] ?></p>
            <a href="logout.php" class="btn btn-dark">Logout</a>
        </div>
    </div>
</div>

</body>
</html>
