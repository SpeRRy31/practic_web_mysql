<?php
session_start();

// Підключення до бази даних
require_once 'connect.php';

// Перевірка, чи переданий параметр id через URL
if(isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Видалення з таблиці order_products, пов'язаних із замовленням
    $sql_delete_order_products = "DELETE FROM order_products WHERE order_id = $order_id";
    if ($connect->query($sql_delete_order_products) === TRUE) {
        // Видалення з таблиці orders
        $sql_delete_order = "DELETE FROM orders WHERE id = $order_id";
        if ($connect->query($sql_delete_order) === TRUE) {
            // Видалення успішне, перенаправляємо користувача назад до myorder.php
            header("Location: ../index.php?page=myorder");

            exit;
        } else {
            echo "Error deleting record: " . $connect->error;
        }
    } else {
        echo "Error deleting record: " . $connect->error;
    }
} else {
    echo "Order ID not provided.";
}

// Закриття з'єднання з базою даних
$connect->close();
?>
