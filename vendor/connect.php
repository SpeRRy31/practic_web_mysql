<?php

    $connect = mysqli_connect('localhost', 'root', '', 'practic_biskupskiy');

 

    if (!$connect) {

        die('Помилка підключення до БД');

    }