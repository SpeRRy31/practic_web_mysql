<?php
session_start();

// Перевірка, чи користувач увійшов в систему (можливо, за допомогою сесій)
if (!isset($_SESSION['user_id'])) {
    // Якщо користувач не увійшов в систему, перенаправте його на сторінку входу
    header("Location: signin.php");
    exit(); // Зупиняємо виконання скрипту, щоб уникнути відображення вмісту сторінки редагування профілю для неавторизованих користувачів
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
    <title>Редагування профілю</title>
</head>
<body>

<header>
    <h1>DottSew Fabric</h1>
    <nav></nav>
    <div class="acount-btn">
    <a href="profile.php" class="checked-login-btn">Скасувати</a>
</div>
</header>

<section class="edit-profile-section">
    <form action="vendor/update_profile.php" method="POST" class="edit-profile-form">
        
    <h2>Редагування профілю</h2>
    <div class="form-group">
            <label for="avatar_url">URL аватара:</label>
            <input type="text" id="avatar_url" name="avatar_url" class="edit-input" placeholder="Введіть URL аватара">
        </div>
        <div class="form-group">
            <label for="firstname">Ім'я:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" class="edit-input" required>
        </div>
        <div class="form-group">
            <label for="lastname">Прізвище:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" class="edit-input" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" class="edit-input" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Номер телефону:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $row['phone_number']; ?>" class="edit-input" required>
        </div>
        <div class="form-group">
            <label for="address">Адреса:</label>
            <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" class="edit-input" required>
        </div>
        <div class="form-group">
            <button type="submit" name="update_profile_btn" class="edit-btn">Оновити профіль</button>
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
