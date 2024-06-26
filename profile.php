<?php
session_start();

// Перевірка, чи користувач увійшов в систему (можливо, за допомогою сесій)
if (!isset($_SESSION['user_id'])) {
    // Якщо користувач не увійшов в систему, перенаправте його на сторінку входу
    header("Location: signin.php");
    exit(); // Зупиняємо виконання скрипту, щоб уникнути відображення вмісту сторінки профілю для неавторизованих користувачів
}

// Підключення до бази даних та обробка даних користувача
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
    <title>Профіль користувача</title>
</head>
<body>

<header>

<h1>DottSew Fabric</h1>

<nav>

</nav>

<div class="acount-btn">
    <a href="index.php" class="checked-login-btn">Повернутись</a>
</div>

</header>

<section class="profile-section">
        <h2>Інформація профілю користувача</h2>
    <div class="profile-info">
        <div  class="profile-info-image">
            <?php if (!empty($row['avatar'])): ?>
                <img src="<?php echo $row['avatar']; ?>" alt="Аватар користувача" class="profile-avatar">
            <?php else: ?>
                <img src="img/avt.png" alt="Базовий аватар" class="profile-avatar">
            <?php endif; ?>
        </div>

        <div  class="profile-info-text">
            <p>Ім'я: <?php echo $row['firstname']; ?></p>
            <p>Прізвище: <?php echo $row['lastname']; ?></p>
            <p>Email: <?php echo $row['email']; ?></p>
            <p>Номер телефону: <?php echo $row['phone_number']; ?></p>
            <p>Адреса: <?php echo $row['address']; ?></p>
        </div>
    </div>
    <div class="profile-btn">
        <a href="edit_profile.php" class="edit-profile-btn">Редагувати</a>
        <a href="change_password.php" class="change-password-btn">Змінити пароль</a>
    </div>
    <div class="profile-btn">
        <a href="vendor/logout.php" class="logout-btn">Вийти</a>
        <a href="#" class="delete-profile-btn" onclick="confirmDelete()">Видалити</a>
    </div>
</section>


<footer>
    <p>&copy; 2024 DottSew</p>
</footer>
<script>
    function confirmDelete() {
        if (confirm("Ви впевнені, що хочете видалити свій профіль?")) {
            window.location.href = "vendor/delete_profile.php";
        }
    }
</script>

</body>
</html>

<?php
} else {
    // Якщо дані профілю користувача не знайдені, виведемо повідомлення про помилку
    echo "Помилка: дані профілю користувача не знайдені";
}
mysqli_close($connect);
?>
