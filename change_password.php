<?php
session_start();

// Перевірка, чи користувач увійшов в систему (можливо, за допомогою сесій)
if (!isset($_SESSION['user_id'])) {
    // Якщо користувач не увійшов в систему, перенаправте його на сторінку входу
    header("Location: signin.php");
    exit(); // Зупиняємо виконання скрипту, щоб уникнути відображення вмісту сторінки для неавторизованих користувачів
}

// Підключення до бази даних
require_once 'vendor/connect.php';

$user_id = $_SESSION['user_id'];

// Отримання даних про користувача з бази даних
$sql = "SELECT * FROM customers WHERE id = $user_id";
$result = mysqli_query($connect, $sql);

// Перевірка, чи отримані дані профілю користувача
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Зміна паролю</title>
</head>
<body>

<header>
    <h1>DottSew Fabric</h1>
    <nav></nav>
    <div class="acount-btn">
    <a href="profile.php" class="checked-login-btn">Скасувати</a>
</div>
</header>

<section class="change-password-section">
    <form action="vendor/update_password.php" method="POST" class="change-password-form">
        <h2 class="change-password-heading">Зміна паролю</h2>
        <div class="form-group">
            <label for="new_password" class="password-label">Новий пароль:</label>
            <input type="password" id="new_password" name="new_password" class="password-input" required>
        </div>
        <div class="form-group">
            <label for="confirm_password" class="password-label">Підтвердіть пароль:</label>
            <input type="password" id="confirm_password" name="confirm_password" class="password-input" required>
        </div>
        <div class="form-group">
            <button type="submit" name="change_password_btn" class="change-password-btn">Змінити пароль</button>
        </div>
    </form>
</section>


<footer>
    <p>&copy; 2024 DottSew</p>
</footer>

</body>
</html>

<?php
} else {
    // Якщо дані профілю користувача не знайдені, виведемо повідомлення про помилку
    echo "Помилка: дані профілю користувача не знайдені";
}
mysqli_close($connect);
?>
