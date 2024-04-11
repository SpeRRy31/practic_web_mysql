<?php
session_start(); // Запускаємо сесію

// Підключення до бази даних
require_once 'vendor/connect.php';

// Обробка даних форми авторизації
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['username'];
    $password = $_POST['password'];

    // Запит до бази даних для перевірки наявності користувача з введеним email та паролем
    $query = "SELECT * FROM customers WHERE email='$email' AND password='$password'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) { // Якщо користувач існує
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id']; // Зберігаємо id користувача в сесії
        header("Location: profile.php"); // Перенаправляємо на сторінку профілю
        exit();
    } else { // Якщо користувача не знайдено
        $error = "Неправильний email або пароль";
    }

    mysqli_close($connect);
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>DottSew</title>
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

<section>

    <div class="container">
        <div class="login-form">
            <h2>Авторизація</h2>
            <?php if(isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>
            <form action="#" method="post">
                <input type="text" name="username" placeholder="Ваш email" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Увійти</button>
                <div class="register-link">
                    <p>Немає акаунту? <a href="register.php">Зареєструватись</a></p>
                </div>                
            </form>
        </div>
    </div>
        
</section>

<footer>
    <p>&copy; 2024 DottSew</p>
</footer>

</body>
</html>
