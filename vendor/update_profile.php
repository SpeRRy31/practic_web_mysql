<?php
session_start();

// Перевірка, чи користувач увійшов в систему (можливо, за допомогою сесій)
if (!isset($_SESSION['user_id'])) {
    // Якщо користувач не увійшов в систему, перенаправте його на сторінку входу
    header("Location: signin.php");
    exit(); // Зупиняємо виконання скрипту, щоб уникнути виконання коду для неавторизованих користувачів
}

// Підключення до бази даних та обробка даних користувача
require_once 'connect.php';

// Отримання інформації з форми редагування профілю
$user_id = $_SESSION['user_id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];

// Опціонально: перевірка, чи було введено URL аватара
if(isset($_POST['avatar_url'])) {
    $avatar_url = $_POST['avatar_url'];
    // Опціонально: виконання додаткових дій з URL аватара, наприклад, збереження його у базі даних
    $sql = "UPDATE customers SET avatar='$avatar_url' WHERE id=$user_id";

    if (mysqli_query($connect, $sql)) {
        // Якщо оновлення успішне, перенаправлення на сторінку профілю
        header("Location: ../profile.php");
    } else {
        // Якщо виникла помилка при оновленні, виведення повідомлення про помилку
        echo "Помилка при оновленні профілю: " . mysqli_error($connect);
    }
}

// Оновлення даних профілю користувача у базі даних
$sql = "UPDATE customers SET firstname='$firstname', lastname='$lastname', email='$email', phone_number='$phone_number', address='$address' WHERE id=$user_id";

if (mysqli_query($connect, $sql)) {
    // Якщо оновлення успішне, перенаправлення на сторінку профілю
    header("Location: ../profile.php");
} else {
    // Якщо виникла помилка при оновленні, виведення повідомлення про помилку
    echo "Помилка при оновленні профілю: " . mysqli_error($connect);
}

// Закриття підключення до бази даних
mysqli_close($connect);
?>
