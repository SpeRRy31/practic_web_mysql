<?php
session_start();

// Перевірка, чи користувач увійшов в систему (можливо, за допомогою сесій)
if (!isset($_SESSION['user_id'])) {
    // Якщо користувач не увійшов в систему, перенаправте його на сторінку входу
    header("Location: signin.php");
    exit();
}

// Підключення до бази даних
require_once 'connect.php'; // Впишіть шлях до файлу connect.php

$user_id = $_SESSION['user_id'];

// Запит на видалення облікового запису користувача
$sql = "DELETE FROM customers WHERE id = $user_id";

if (mysqli_query($connect, $sql)) {
    // Якщо видалення пройшло успішно, редирект на сторінку виходу
    header("Location: logout.php");
    exit();
} else {
    // Якщо сталася помилка під час видалення, виведення повідомлення про помилку
    echo "Помилка видалення профілю: " . mysqli_error($connect);
}

// Закриття з'єднання з базою даних
mysqli_close($connect);
?>
