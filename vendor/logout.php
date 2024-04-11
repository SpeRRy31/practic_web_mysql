<?php
session_start();

// Встановлення `user_id` в сесії на null або видалення всіх даних сесії
$_SESSION['user_id'] = null;

// Перенаправлення користувача на головну сторінку
header("Location: ../index.php");
exit();
?>
