<?php
/*
 * Часть 2: Работа с заголовками, параметрами и JSON-данными.
 * Показывает, как передавать кастомные заголовки, параметры и JSON-тело запроса.
 * 
 * Демонстрирует:
 * 1. Отправку кастомных HTTP-заголовков
 * 2. Работу с JSON-данными
 * 3. Использование URL-параметров
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
    // 1. GET-запрос с кастомными заголовками
    $headers = [
        'Accept: application/json',
        'X-Custom-Header: Test Value',
        'X-Debug-Mode: true'
    ];
    printResponse(
        "1. GET-запрос с кастомными заголовками",
        $client->getWithHeaders('/posts/1', $headers)
    );
    echo "Отправленные заголовки:\n";
    print_r($headers);

    // 2. POST-запрос с JSON-данными
    $jsonData = [
        'title' => 'JSON Пост',
        'body' => 'Это пост, отправленный с использованием JSON',
        'userId' => 5,
        'metadata' => [
            'source' => 'API Demo',
            'version' => '1.0'
        ]
    ];
    printResponse(
        "2. POST-запрос с JSON-данными",
        $client->postJson('/posts', $jsonData)
    );
    echo "Отправленные данные:\n";
    print_r($jsonData);

    // 3. GET-запрос с URL-параметрами
    $params = [
        'userId' => 1,
        'sort' => 'desc',
        'limit' => 5
    ];
    printResponse(
        "3. GET-запрос с URL-параметрами",
        $client->getWithParams('/posts', $params)
    );
    echo "URL-параметры:\n";
    print_r($params);

    // 4. Комбинированный запрос (заголовки + параметры)
    $combinedHeaders = [
        'Accept: application/json',
        'X-Custom-Header: Combined Request'
    ];
    $combinedParams = [
        'userId' => 2,
        'limit' => 3
    ];
    printResponse(
        "4. Комбинированный GET-запрос (заголовки + параметры)",
        $client->getWithHeadersAndParams('/posts', $combinedHeaders, $combinedParams)
    );
    echo "Комбинированные параметры:\n";
    echo "Заголовки:\n";
    print_r($combinedHeaders);
    echo "URL-параметры:\n";
    print_r($combinedParams);

} catch (Exception $e) {
    printResponse("Ошибка", sprintf(
        "Тип исключения: %s\nСообщение: %s",
        get_class($e),
        $e->getMessage()
    ));
}

echo "\nДемонстрация работы с заголовками и параметрами завершена.\n";
