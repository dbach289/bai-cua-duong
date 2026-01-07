<?php
session_start();

// Bảo vệ trang: nếu chưa đăng nhập -> về login
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Xin chào <?php echo htmlspecialchars($userName); ?></h2>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>


