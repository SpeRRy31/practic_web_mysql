<?php
session_start();

// Перевірка, чи користувач увійшов в систему (можливо, за допомогою сесій)
if (!isset($_SESSION['user_id'])) {
    // Якщо користувач не увійшов в систему, перенаправте його на сторінку входу
    header("Location: signin.php");
    exit(); // Зупиняємо виконання скрипту, щоб уникнути виконання коду для неавторизованих користувачів
}

// Перевірка, чи були передані дані з форми
if (isset($_POST['change_password_btn'])) {
    // Підключення до бази даних
    require_once 'connect.php';

    $user_id = $_SESSION['user_id'];
    
    // Отримання нового паролю з форми
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Перевірка, чи паролі співпадають
    if ($new_password === $confirm_password) {
        // Хешування нового паролю
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Оновлення паролю користувача в базі даних
        $update_query = "UPDATE customers SET password = '$hashed_password' WHERE id = $user_id";
        $update_result = mysqli_query($connect, $update_query);

        // Перевірка успішності оновлення
        if ($update_result) {
            // Перенаправлення на сторінку профілю з повідомленням про успішну зміну паролю
            header("Location: ../profile.php?password_changed=true");
            exit();
        } else {
            // Якщо сталася помилка під час оновлення паролю, виведемо повідомлення
            header("Location: ../change_password.php?error=update_failed");
            exit();
        }
    } else {
        // Якщо паролі не співпадають, перенаправлення на сторінку зміни паролю з повідомленням
        header("Location: ../change_password.php?error=password_mismatch");
        exit();
    }
} else {
    // Якщо дані не були передані з форми, перенаправлення на сторінку зміни паролю
    header("Location: ../change_password.php");
    exit();
}
