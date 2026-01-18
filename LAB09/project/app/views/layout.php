<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sinh viên</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container">
    <header>
        <h1>📘 Hệ thống quản lý sinh viên</h1>
    </header>

    <main>
        <?php
            // load view con
            require __DIR__ . '/students/index.php';
        ?>
    </main>

    <footer>
        <p>Lab09 – PDO – MVC – Ajax | IT3220</p>
    </footer>
</div>

<!-- JS -->
<script src="assets/js/app.js"></script>
</body>
</html>
