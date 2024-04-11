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
        <a href="#" class="nav-link" data-page="main.php">Головна</a>
        <a href="#" class="nav-link" data-page="products.php">Товари</a>
        <a href="#" class="nav-link" data-page="myorder.php">Мої замовлення</a>
        <a href="#" class="nav-link" data-page="contact.php">Контакти</a>
    </nav>
    <?php
    session_start();

    // Перевірка, чи користувач увійшов в систему (можливо, за допомогою сесій)
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
        // Якщо користувач не увійшов в систему, відображення кнопки "Увійти"
    ?>
        <div class="acount-btn">
            <a href="signin.php">Увійти</a>
        </div>
    <?php
    } else {
        // Якщо користувач увійшов в систему, відображення кнопки "Профіль"
    ?>
        <div class="acount-btn">
            <a href="profile.php">Профіль</a>
        </div>
    <?php
}
?>
</header>

<section id="content">
    <!-- Вміст буде вставлено тут через Ajax -->
</section>

<footer>
    <p>&copy; 2024 DottSew</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // AJAX-запит при завантаженні сторінки для вставки вмісту з main.php
    $.ajax({
        url: 'main.php',
        type: 'GET',
        success: function(response) {
            $('#content').html(response); // Вставка вмісту сторінки main.php в секцію
        },
        error: function(xhr, status, error) {
            console.error(status, error); // Обробка помилок, якщо вони виникнуть
        }
    });

    // Обробник кліків на посиланнях навігаційного меню
    $('.nav-link').click(function(event) {
        event.preventDefault(); // Зупинка стандартної дії посилання
        
        // Отримання URL-адреси сторінки з атрибута data-page
        var page = $(this).data('page');
        
        // Ajax-запит для завантаження сторінки та вставки її в секцію
        $.ajax({
            url: page,
            type: 'GET',
            success: function(response) {
                $('#content').html(response); // Вставка вмісту сторінки в секцію
            },
            error: function(xhr, status, error) {
                console.error(status, error); // Обробка помилок, якщо вони виникнуть
            }
        });
    });
});

</script>

</body>
</html>
