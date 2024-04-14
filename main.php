
<section id="about-us" class="section">
        <h2>Про нас</h2>
        <p>Компанія DottSew - це виробник вишиття та пошиття високої якості. Ми пропонуємо унікальні вироби ручної роботи, створені з любов'ю і турботою про деталі.</p>
        <p>Наша мета - створити для вас не лише продукти, але й відчуття затишку та комфорту. Завдяки нашим виробам ви зможете виражати свій стиль та індивідуальність.</p>
        <p>Ми прагнемо до постійного удосконалення та розвитку, а також до задоволення потреб наших клієнтів.</p>
</section>

<section id="employees" class="section">
        <h2>Наші робітники</h2>
        <div class="carousel">
            <?php
            // Підключення до бази даних та отримання робітників
            require_once 'vendor/connect.php';
            $sql = "SELECT * FROM employees";
            $result = $connect->query($sql);

            if ($result->num_rows > 0) {
                $employees = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($employees as $employee) {
                    echo "<div class='employee'>";
                    echo "<img src='{$employee['image']}' alt='{$employee['lastname']}'>";
                    echo "<h3>{$employee['firstname']}</h3>";
                    echo "<p>{$employee['post']}</p>";
                    echo "<p>{$employee['email']}</p>";
                    echo "</div>";
                }
            }
            ?>
        </div>
</section>

