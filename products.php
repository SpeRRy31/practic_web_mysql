<?php
session_start(); // Запускаємо сесію

// Підключення до бази даних
require_once 'vendor/connect.php';

// Запит до бази даних для отримання всіх рядків з таблиці products
$sql = "SELECT * FROM products";
$result = $connect->query($sql);

// Перевірка, чи є результат
if ($result->num_rows > 0) {
    // Початок контейнера
    echo '<div class="products-container">';
    
    // Ітерація по результатам запиту
    while ($row = $result->fetch_assoc()) {
        // Виведення товару у контейнері з посиланням на сторінку товару
        echo '<div class="product">';
        echo '<a href="product.php?id=' . $row['id'] . '" class="product-link">';
        echo '<div class="product-image">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '</div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['price'] . '$</p>';
        echo '</a>';
        echo '</div>';
    }
    

    // Кінець контейнера
    echo '</div>';
} else {
    echo "No products found.";
}

// Закриття з'єднання з базою даних
$connect->close();
?>
