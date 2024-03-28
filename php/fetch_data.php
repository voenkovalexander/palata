<?php

$host = 'localhost';
$dbname = 'dlyapalati';
$username = 'root';
$password = '';

try {
    // Подключение к базе данных
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Выполнение запроса к базе данных для извлечения данных
    $statement = $pdo->query('SELECT * FROM posts');
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Установка заголовка для указания типа контента (JSON)
    header('Content-Type: application/json');
    // Вывод данных в формате JSON
    echo json_encode($data);
} catch(PDOException $e) {
    // Обработка ошибок подключения к базе данных
    echo 'Ошибка подключения к базе данных: ' . $e->getMessage();
}
