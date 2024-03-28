<?php
require_once('vendor/autoload.php');

use VK\Client\VKApiClient;

// Замените на свой токен доступа и данные для подключения к базе данных
$accessToken = 'vk1.a.w7TWiYxCmJ-BlGwgQS7Zg2iYU3pwYyd-f-gKVxYDjU9hNaw5RlxoEJv9wPaFzbrAeHkZM7mSlZz9dAVCREtjyn_I95xQXXSPt0ubGGUR3qkediiyUw-vF6EXs2TbokQIhdG_xS1w9lg9K1Mq0hzHiqEGbdGLbu7D1xNWmugx8_HTQSynCSbhphuOG_Vp2Xdbtij7sMxL1pLHEnDlpqxcQA';
$databaseHost = 'localhost';
$databaseUser = 'root';
$databasePassword = '';
$databaseName = 'dlyapalati';

// ID группы, посты из которой вы хотите обработать
$groupId = 'club217417311'; // Замените на ID вашей группы

// Подключение к базе данных
$mysqli = new mysqli($databaseHost, $databaseUser, $databasePassword, $databaseName);

if ($mysqli->connect_error) {
    die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
}

// Инициализация VK API
$vk = new VKApiClient();

// Количество постов, которое вы хотите обработать за один запрос
$postCount = 100;

// Начинаем с первого поста
$offset = 0;

$allPosts = [];

do {
    // Получение записей со стены группы с учетом offset
    try {
        $wallPosts = $vk->wall()->get($accessToken, array('owner_id' => $groupId, 'count' => $postCount, 'offset' => $offset));

        // Добавляем посты в массив
        $allPosts = array_merge($allPosts, $wallPosts['items']);

        // Увеличиваем offset для следующего запроса
        $offset += $postCount;
    } catch (Exception $e) {
        echo 'Ошибка при получении данных из VK API: ' . $e->getMessage();
        break; // Прерываем цикл в случае ошибки
    }
} while (!empty($wallPosts['items']));

// Сохраняем посты в базу данных в обратном порядке
foreach (array_reverse($allPosts) as $post) {
    // Извлечение текста и фотографии из поста
    $text = $post['text'];
    $photo = isset($post['attachments'][0]['photo']) ? $post['attachments'][0]['photo']['sizes'][2]['url'] : '';

    // Экранирование данных перед вставкой в базу данных
    $text = $mysqli->real_escape_string($text);
    $photo = $mysqli->real_escape_string($photo);

    // Вставка данных в базу данных
    $query = "INSERT INTO posts (text, photo) VALUES ('$text', '$photo')";
    $result = $mysqli->query($query);

    if (!$result) {
        echo 'Ошибка при добавлении данных в базу данных: ' . $mysqli->error;
        break; // Прерываем цикл в случае ошибки
    }
}

echo 'Все посты успешно добавлены в базу данных.';

// Закрытие соединения с базой данных
$mysqli->close();
?>