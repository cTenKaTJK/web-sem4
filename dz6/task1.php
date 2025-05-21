<?php
/*
 * Часть 1: Базовые HTTP-запросы (GET, POST, PUT, DELETE).
 * Демонстрирует базовое взаимодействие с JSONPlaceholder API.
 * 
 * API: https://jsonplaceholder.typicode.com
 * Документация: https://jsonplaceholder.typicode.com/guide/
 */

$config = require 'config.php';
require_once 'client/BasicApiClient.php';

// Функция для красивого вывода результатов
function printResponse($title, $response) {
    echo "\n=== $title ===\n";
    if (is_array($response)) {
        if (!empty($response)) {
            foreach ($response as $key => $value) {
                if (is_array($value)) {
                    echo "$key:\n";
                    print_r($value);
                } else {
                    echo "$key: $value\n";
                }
            }
        } else {
            echo "Пустой ответ\n";
        }
    } else {
        echo $response . "\n";
    }
    echo str_repeat('=', strlen($title) + 6) . "\n";
}

$client = new BasicApiClient($config['base_url'], $config['log_file']);

try {
    // 1. GET-запрос: получение существующей записи
    printResponse(
        "1. GET-запрос: получение поста с ID 1",
        $client->get('/posts/1')
    );

    // 2. POST-запрос: создание новой записи
    $newPost = [
        'title' => 'Новый пост',
        'body' => 'Это содержимое нового поста, созданного через API',
        'userId' => 1
    ];
    printResponse(
        "2. POST-запрос: создание нового поста",
        $client->post('/posts', $newPost)
    );

    // 3. PUT-запрос: обновление существующей записи
    $updatedPost = [
        'id' => 1,
        'title' => 'Обновленный заголовок',
        'body' => 'Это обновленное содержимое поста',
        'userId' => 1
    ];
    printResponse(
        "3. PUT-запрос: обновление поста с ID 1",
        $client->put('/posts/1', $updatedPost)
    );

    // 4. DELETE-запрос: удаление записи
    printResponse(
        "4. DELETE-запрос: удаление поста с ID 1",
        $client->delete('/posts/1')
    );

    // 5. Дополнительно: проверка удаления
    echo "\n=== 5. Проверка удаления ===\n";
    try {
        $response = $client->get('/posts/1');
        printResponse("Попытка получить удаленный пост", $response);
    } catch (Exception $e) {
        echo "Ожидаемая ошибка: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    printResponse("Ошибка", sprintf(
        "Тип исключения: %s\nСообщение: %s",
        get_class($e),
        $e->getMessage()
    ));
}

echo "\nДемонстрация базовых запросов завершена.\n";
