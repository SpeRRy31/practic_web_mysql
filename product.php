<?php
session_start(); // Запускаємо сесію

// Підключення до бази даних
require_once 'vendor/connect.php';

// Перевірка, чи переданий параметр id через URL
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Запит до бази даних для отримання інформації про товар з вказаним id
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $connect->query($sql);

    // Перевірка, чи знайдено товар за вказаним id
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Отримання інформації про товар
        $product_name = $row['name'];
        $product_price = $row['price'];
        $product_desc = $row['description'];
        $product_image = $row['image'];
    } else {
        // Якщо товар не знайдено, вивести повідомлення про помилку
        echo "Product not found.";
    }
} else {
    // Якщо id товару не передано через URL, вивести повідомлення про помилку
    echo "Product ID not provided.";
}

// Перевірка, чи користувач увійшов в систему
if(isset($_SESSION['user_id'])) {
    // Користувач увійшов, отримуємо його ID
    $user_id = $_SESSION['user_id'];

    // Перевірка, чи було натиснуто кнопку "Замовити"
    if(isset($_POST['order'])) {
        // Отримання даних форми замовлення
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        // Додавання замовлення до бази даних
        $sql = "INSERT INTO orders (customer_id, date, status, description) VALUES ('$user_id', NOW(), 'pending', 'Order for product ID: $product_id, Quantity: $quantity')";
        if ($connect->query($sql) === TRUE) {
            // Отримання id новоствореного замовлення
            $order_id = $connect->insert_id;

            // Додавання даних про замовлені товари до таблиці order_products
            $sql_order_product = "INSERT INTO order_products (order_id, product_id, count, price) VALUES ('$order_id', '$product_id', '$quantity', '$product_price')";
            if ($connect->query($sql_order_product) === TRUE) {
                echo "Order placed successfully!";
            } else {
                echo "Error: " . $sql_order_product . "<br>" . $connect->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $connect->error;
        }
    }

} else {
    // Користувач не увійшов, виводимо повідомлення про потребу у реєстрації
    echo "Please log in or register to place an order.";
}

// Закриття з'єднання з базою даних
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product_name; ?></title>
    <!-- Підключення стилів -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="product.css">
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
    <!-- Відображення інформації про товар -->
    <section class="product-section">
        <div class="product-details">
            <div class="info_product">
                <img src="<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>">
                <div class= "prouct-text">
                    <h2><?php echo $product_name; ?></h2>
                    <p><?php echo $product_desc; ?></p>
                    <p style="font-weight: bold;"><?php echo $product_price; ?>$</p>
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="quantity-section">
                            <label for="quantity">Кількість:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1">
                        </div>
                        <input type="submit" name="order" value="Замовити">
                    </form>

                </div>
            </div>
            <!-- Кнопка "Замовити" -->
            
        </div>
    </section>
    <footer>
    <p>&copy; 2024 DottSew</p>
</footer>
</body>
</html>
