<?php

require_once __DIR__ . '/BasicApiClient.php';

// Специализированный клиент для работы с OpenWeatherMap API
// Документация API: https://openweathermap.org/api
class WeatherApiClient extends BasicApiClient
{
    private string $apiKey;
    private string $units;
    private string $language;

    // $apiKey API ключ от OpenWeatherMap
    // $logFile путь к файлу логов
    // $units единицы измерения ('metric' или 'imperial')
    // $language код языка (например, 'ru' для русского)
    public function __construct(string $apiKey, string $logFile, string $units = 'metric', string $language = 'ru')
    {
        parent::__construct('https://api.openweathermap.org/data/2.5', $logFile);
        $this->apiKey = $apiKey;
        $this->units = $units;
        $this->language = $language;
    }

    // Получить текущую погоду по названию города
    public function getCurrentWeatherByCity(string $city): array
    {
        return $this->getWithParams('/weather', [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->language
        ]);
    }

    // Получить текущую погоду по координатам
    public function getCurrentWeatherByCoords(float $lat, float $lon): array
    {
        return $this->getWithParams('/weather', [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->language
        ]);
    }

    // Получить прогноз погоды на 5 дней по названию города
    public function getForecastByCity(string $city): array
    {
        return $this->getWithParams('/forecast', [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->language
        ]);
    }

    // Получить информацию о загрязнении воздуха по координатам
    public function getAirPollution(float $lat, float $lon): array
    {
        return $this->getWithParams('/air_pollution', [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey
        ]);
    }
} 