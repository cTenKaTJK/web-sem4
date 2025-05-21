<?php
/*
 * Часть 4: Практическое применение API клиента
 * Демонстрирует работу с реальным API (OpenWeatherMap) с использованием
 * аутентификации и обработки различных типов данных.
 */

$config = require 'config.php';
require_once 'client/WeatherApiClient.php';

// Функция для проверки наличия всех необходимых полей в ответе
function validateWeatherData(array $data): bool {
    $required_fields = [
        'body' => [
            'name',
            'main' => ['temp', 'humidity'],
            'wind' => ['speed'],
            'clouds' => ['all'],
            'weather' => [0 => ['description']]
        ]
    ];

    foreach ($required_fields as $key => $value) {
        if (!isset($data[$key])) {
            return false;
        }
        if (is_array($value)) {
            foreach ($value as $subkey => $subvalue) {
                if (is_array($subvalue)) {
                    if (!isset($data[$key][$subkey]) || !is_array($data[$key][$subkey])) {
                        return false;
                    }
                    foreach ($subvalue as $subsubkey => $subsubvalue) {
                        if (!isset($data[$key][$subkey][$subsubkey])) {
                            return false;
                        }
                    }
                } else {
                    if (!isset($data[$key][$subkey])) {
                        return false;
                    }
                }
            }
        }
    }
    return true;
}

// Функция для красивого вывода погодных данных
function formatWeatherData(array $data): string
{
    if (!validateWeatherData($data)) {
        print_r($data);
        return "Ошибка: Неверный формат данных в ответе API\n" .
               "Проверьте правильность API ключа и доступность сервиса.\n";
    }

    $weather = $data['body'];
    return sprintf(
        "🌍 Погода в городе %s:\n" .
        "🌡️ Температура: %.1f°C\n" .
        "💧 Влажность: %d%%\n" .
        "🌪️ Ветер: %.1f м/с\n" .
        "☁️ Облачность: %d%%\n" .
        "🎯 Описание: %s\n",
        $weather['name'],
        $weather['main']['temp'],
        $weather['main']['humidity'],
        $weather['wind']['speed'],
        $weather['clouds']['all'],
        $weather['weather'][0]['description']
    );
}

// Функция для форматирования прогноза погоды
function formatForecast(array $data): string
{
    if (!isset($data['body']['list']) || !is_array($data['body']['list'])) {
        return "Ошибка: Неверный формат данных прогноза\n" .
               "Проверьте правильность API ключа и доступность сервиса.\n";
    }

    $result = "📅 Прогноз погоды на 5 дней:\n\n";
    $currentDate = '';

    foreach ($data['body']['list'] as $item) {
        if (!isset($item['dt'], $item['main']['temp'], $item['weather'][0]['description'])) {
            continue; // Пропускаем некорректные данные
        }

        $date = date('Y-m-d', $item['dt']);
        $time = date('H:i', $item['dt']);

        if ($date !== $currentDate) {
            $currentDate = $date;
            $result .= "\n📆 " . date('d.m.Y', $item['dt']) . ":\n";
        }

        $result .= sprintf(
            "🕐 %s: %.1f°C, %s\n",
            $time,
            $item['main']['temp'],
            $item['weather'][0]['description']
        );
    }

    return $result ?: "Ошибка: Нет данных для отображения прогноза\n";
}

// Функция для форматирования данных о загрязнении воздуха
function formatAirPollution(array $data): string
{
    if (!isset($data['body']['list'][0]['main']['aqi'])) {
        return "Ошибка: Неверный формат данных о загрязнении воздуха\n" .
               "Проверьте правильность API ключа и доступность сервиса.\n";
    }

    $aqi = $data['body']['list'][0]['main']['aqi'];
    $quality = match($aqi) {
        1 => "Отличное 😊",
        2 => "Хорошее 🙂",
        3 => "Умеренное 😐",
        4 => "Плохое 😷",
        5 => "Очень плохое 🤢",
        default => "Неизвестно ❓"
    };

    return sprintf(
        "🌫️ Качество воздуха:\n" .
        "Индекс: %d\n" .
        "Оценка: %s\n",
        $aqi,
        $quality
    );
}

try {
    // Проверяем наличие API ключа
    if (empty($config['weather_api_key']) || $config['weather_api_key'] === 'YOUR_API_KEY_HERE') {
        throw new Exception(
            "API ключ не настроен!\n" .
            "Пожалуйста, получите ключ на https://openweathermap.org/api\n" .
            "и добавьте его в файл config.php"
        );
    }

    // Создаем клиент для работы с API погоды
    $weatherClient = new WeatherApiClient(
        $config['weather_api_key'],
        $config['log_file'],
        'metric',
        'ru'
    );

    // 1. Получаем текущую погоду в Калининграде
    echo "=== Текущая погода в Калининграде ===\n";
    try {
        $weather = $weatherClient->getCurrentWeatherByCity('Kaliningrad');
        echo "\n" . formatWeatherData($weather);
    } catch (Exception $e) {
        echo "Ошибка получения погоды: " . $e->getMessage() . "\n";
    }

    // 2. Получаем прогноз погоды для Калининграда
    echo "\n=== Прогноз погоды для Калининграда ===\n";
    try {
        $forecast = $weatherClient->getForecastByCity('Kaliningrad');
        echo formatForecast($forecast);
    } catch (Exception $e) {
        echo "Ошибка получения прогноза: " . $e->getMessage() . "\n";
    }

    // 3. Получаем данные о загрязнении воздуха в Калининграде
    echo "\n=== Загрязнение воздуха в Калининграде ===\n";
    try {
        $pollution = $weatherClient->getAirPollution(54.7065, 20.5109);
        echo formatAirPollution($pollution);
    } catch (Exception $e) {
        echo "Ошибка получения данных о загрязнении: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "\nКритическая ошибка: " . $e->getMessage() . "\n";
}

echo "\nДемонстрация завершена.\n"; 