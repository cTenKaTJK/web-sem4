<?php
/*
 * Часть 3: Обработка успешных ответов, ошибок HTTP и исключений cURL.
 * Демонстрирует расширенную обработку результатов запросов.
 */

$config = require 'config.php';
require_once 'client/AdvancedApiClient.php';

$client = new AdvancedApiClient($config['base_url'], $config['log_file']);

// Функция для красивого вывода результатов
function printResponse($title, $response) {
    echo "\n=== $title ===\n";
    if (is_array($response)) {
        print_r($response);
    } else {
        echo $response . "\n";
    }
    echo "================\n";
}

try {
    // 1. Демонстрация успешного GET-запроса и парсинга JSON
    printResponse("1. Успешный GET-запрос", $client->get('/posts/1'));

    // 2. Демонстрация успешного POST-запроса
    $postData = [
        'title' => 'Тестовый пост',
        'body' => 'Содержимое поста',
        'userId' => 1
    ];
    printResponse("2. Успешный POST-запрос", $client->post('/posts', $postData));

    // 3. Демонстрация обработки различных HTTP ошибок
    try {
        printResponse("3.1. Попытка доступа к несуществующему ресурсу (404)", 
            $client->get('/posts/999999'));
    } catch (HttpException $e) {
        printResponse("3.1. Ошибка 404", sprintf(
            "HTTP статус: %d\nОтвет: %s",
            $e->getStatusCode(),
            $e->getResponse()
        ));
    }

    try {
        printResponse("3.2. Попытка доступа к защищенному ресурсу (401)", 
            $client->get('/secure-endpoint'));
    } catch (HttpException $e) {
        printResponse("3.2. Ошибка 401", sprintf(
            "HTTP статус: %d\nОтвет: %s",
            $e->getStatusCode(),
            $e->getResponse()
        ));
    }

    // 4. Демонстрация обработки ошибок JSON
    try {
        // Намеренно вызываем ошибку парсинга JSON
        $invalidJsonData = ['invalid' => pack('H*', 'c3')];
        $client->post('/posts', $invalidJsonData);
    } catch (ApiJsonException $e) {
        printResponse("4. Ошибка парсинга JSON", sprintf(
            "Сообщение: %s\nИсходный ответ: %s",
            $e->getMessage(),
            $e->getRawResponse()
        ));
    }

    // 5. Демонстрация ошибок cURL
    try {
        // Создаем новый клиент с неверным URL для демонстрации ошибки cURL
        $invalidClient = new AdvancedApiClient(
            'https://invalid-domain-name-that-does-not-exist.com',
            $config['log_file']
        );
        $invalidClient->get('/test');
    } catch (Exception $e) {
        printResponse("5. Ошибка cURL", $e->getMessage());
    }

} catch (Exception $e) {
    // Общий обработчик для любых других исключений
    printResponse("Неожиданная ошибка", sprintf(
        "Тип исключения: %s\nСообщение: %s",
        get_class($e),
        $e->getMessage()
    ));
}

echo "\nДемонстрация завершена.\n";
