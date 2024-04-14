<?php
session_start(); // Запускаємо сесію

// Підключення до бази даних
require_once 'vendor/connect.php';

// Перевірка, чи користувач увійшов в систему
if(isset($_SESSION['user_id'])) {
    // Користувач увійшов, отримуємо його ID
    $user_id = $_SESSION['user_id'];

    // Запит до бази даних для отримання замовлень поточного користувача
    $sql = "SELECT orders.id AS order_id, products.name, orders.date, orders.status, order_products.count, order_products.price, products.id AS product_idd
            FROM orders 
            INNER JOIN order_products ON orders.id = order_products.order_id 
            INNER JOIN products ON order_products.product_id = products.id 
            WHERE orders.customer_id = $user_id";
    $result = $connect->query($sql);
    
    // Перевірка, чи є замовлення для цього користувача
    if ($result->num_rows > 0) {
        // Вивід інформації про замовлення
        while ($row = $result->fetch_assoc()) {
            // Вивід інформації про кожне замовлення
            
    $total_price=$row['count'] * $row['price'];
            echo "<div class='order-info'>";
            echo "<p><span class='name-order'><strong> {$row['name']}</strong></span> <span class='order-date'>{$row['date']}</span> <span class='order-status'>{$row['status']}</span> <span class='u-order'>кількість:</span> {$row['count']} <span class='u-order'>ціна:</span> {$total_price}$";
            echo "<div class='order-space'></div>";

            echo "<a class='view-button' href='product.php?id={$row['product_idd']}'>Переглянути</a>";
            echo "<a class='cancel-button' href='vendor/cancel_order.php?id={$row['order_id']}'>Видалити</a></p>";
            
            echo "</div>";
        }
    } else {
        // Якщо замовлень немає, виводимо повідомлення
        echo "Немає замовлень.";
    }
} else {
    // Користувач не увійшов, виводимо повідомлення про потребу у вході
    echo "Будь ласка, увійдіть, щоб переглянути свої замовлення.";
}

// Закриття з'єднання з базою даних
$connect->close();
?>
