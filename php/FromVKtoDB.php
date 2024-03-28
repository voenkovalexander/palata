<?php
// require_once('vendor/autoload.php');

// use VK\Client\VKApiClient;

// Укажите ваши данные доступа к ВКонтакте
$accessToken = 'vk1.a.w7TWiYxCmJ-BlGwgQS7Zg2iYU3pwYyd-f-gKVxYDjU9hNaw5RlxoEJv9wPaFzbrAeHkZM7mSlZz9dAVCREtjyn_I95xQXXSPt0ubGGUR3qkediiyUw-vF6EXs2TbokQIhdG_xS1w9lg9K1Mq0hzHiqEGbdGLbu7D1xNWmugx8_HTQSynCSbhphuOG_Vp2Xdbtij7sMxL1pLHEnDlpqxcQA';
$confirmationCode = 'bf0e7ae4';

// Укажите данные для подключения к базе данных MySQL
$host = 'localhost'; // Хост
$username = 'root'; // Имя пользователя
$password = ''; // Пароль
$database = 'dlyapalati'; // Имя базы данных

// ID группы, посты из которой вы хотите обработать
$groupId = 'club217417311';

// Получение ID последнего обработанного поста из базы данных
$lastProcessedPostId = 0;

// Подключение к базе данных
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_error) {
    die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
}

// Инициализация VK API
// $vk = new VKApiClient();

// Получаем данные от ВКонтакте
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['type']) && $data['type'] === 'confirmation') {
    // Отправляем код подтверждения обратно VK
    echo $confirmationCode;
    exit;
}

// Обрабатываем полученные данные
if (!empty($data)) {
    // Проверяем тип события
    switch ($data['type']) {
        case 'wall_post_new':

            if(isset($data['object']['attachments'])){
                foreach ($data['object']['attachments'] as $attachment) {
                    if ($attachment['type'] === 'photo') {
                        $photo = $attachment['photo']['sizes'][4]['url'];
                        break; // Берем только первую фотографию, можно изменить логику по вашим требованиям
                    }
                }
            }else{
                $photo = '#';
            }

            // Извлечение текста из поста
            $text = $data['object']['text'];
            $event_id = $data['event_id'];

            // Проверка на дублирование запроса
            $checkEventId = "SELECT * FROM `posts` WHERE `event_id` = '$event_id'";
            $checkResult = $mysqli->query($checkEventId);
            
            if ($checkResult->num_rows > 0) {
                die("Запись с event_id = $event_id уже существует в базе данных.");
            }

            // Экранирование данных перед вставкой в базу данных
            $text = $mysqli->real_escape_string($text);
            $photo = $mysqli->real_escape_string($photo);
            $event_id = $mysqli->real_escape_string($event_id);

            // Сохраняем данные в базу данных
            $query = "INSERT INTO posts (text, photo, event_id) VALUES ('$text', '$photo', '$event_id')";
            $result = $mysqli->query($query);
            if (!$result) {
                die('Ошибка при выполнении запроса: ' . $mysqli->error);
            }

            // Обновление ID последнего обработанного поста
            $lastProcessedPostId = $data['object']['id'];

            echo "$data";
            break;
        default:
        http_response_code(404);
            break;
    }

    // Возвращаем HTTP-код 200 для подтверждения получения данных
    http_response_code(200);
    echo 'OK';
} else {
    http_response_code(400); // Некорректный запрос
    echo 'Bad Request';
}

// Закрытие соединения с базой данных
$mysqli->close();
?>
