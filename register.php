<?php
// Підключення до бази даних
require_once 'vendor/connect.php';

// Обробка даних форми реєстрації
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f_name = $_POST['firstname'];
    $l_name = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    // Перевірка наявності користувача з введеним email або телефонним номером
    $check_query = "SELECT * FROM customers WHERE email='$email' OR phone_number='$phone_number'";
    $check_result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Якщо користувач з такими даними вже існує
        $error = "Користувач з таким email або телефонним номером вже існує";
    } else {
        // Додавання нового користувача до бази даних
        $insert_query = "INSERT INTO customers (email, password, firstname, lastname, phone_number, address) VALUES ('$email', '$password','$f_name', '$l_name', '$phone_number', '$address')";
        if (mysqli_query($connect, $insert_query)) {
            $_SESSION['success'] = "Ви успішно зареєстровані!";
            header("Location: profile.php");
            exit();
        } else {
            $_SESSION['error'] = "Помилка: " . $sql . "<br>" . mysqli_error($connect);
            header("Location: signin.php");
            exit();
        }
        
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
        <div class="register-form">
            <h2>Реєстрація</h2>
            <form action="#" method="post">
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <input type="text" name="firstname" placeholder="Ім'я" required>
                <input type="text" name="lastname" placeholder="Прізвище" required>
                <input type="text" name="phone_number" placeholder="Номер телефону" required>
                <input type="text" name="address" placeholder="Адреса" required>
                <?php
                    // Виведення повідомлення про існування користувача
                    if(isset($error)) {
                        echo '<p class="error-message">' . $error . '</p>';
                    }
                ?>
                <button type="submit">Зареєструватись</button>
                <div class="register-link">
                    <p>Вже є акаунт? <a href="signin.php">Увійти</a></p>
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
