<?php

// Class BasicApiClient
// Класс для выполнения HTTP-запросов с использованием cURL.
// Поддерживает: GET, POST, PUT, DELETE, заголовки, параметры и JSON.
class BasicApiClient
{
    private string $baseUrl;    //Базовый URL для всех запросов
    private string $logFile;    //$logFile Путь к лог-файлу

    public function __construct(string $baseUrl, string $logFile)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->logFile = $logFile;
    }

    // Выполняет GET-запрос
    public function get(string $endpoint): array
    {
        return $this->request('GET', $endpoint);
    }

    // Выполняет POST-запрос
    public function post(string $endpoint, array $data): array
    {
        return $this->request('POST', $endpoint, $data);
    }

    // Выполняет PUT-запрос
    public function put(string $endpoint, array $data): array
    {
        return $this->request('PUT', $endpoint, $data);
    }

    // Выполняет DELETE-запрос
    public function delete(string $endpoint): array
    {
        return $this->request('DELETE', $endpoint);
    }

    // GET-запрос с пользовательскими HTTP-заголовками
    // $headers массив строк заголовков, например ['Accept: application/json']
    public function getWithHeaders(string $endpoint, array $headers): array
    {
        return $this->request('GET', $endpoint, null, $headers);
    }

    // GET-запрос с параметрами в URL
    public function getWithParams(string $endpoint, array $queryParams): array
    {
        $queryString = http_build_query($queryParams);
        return $this->get($endpoint . '?' . $queryString);
    }

    // GET-запрос с заголовками и параметрами
    public function getWithHeadersAndParams(string $endpoint, array $headers, array $params): array
    {
        $url = $endpoint;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return $this->request('GET', $url, null, $headers);
    }

    // POST-запрос с JSON-данными
    // $jsonData - ассоциативный массив, который будет сериализован в JSON
    public function postJson(string $endpoint, array $jsonData, array $headers = []): array
    {
        $headers[] = 'Content-Type: application/json';
        return $this->request('POST', $endpoint, $jsonData, $headers);
    }

    // Метод запроса с полной настройкой (тип, заголовки, тело)
    private function request(string $method, string $endpoint, ?array $data = null, array $headers = []): array
    {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($data !== null) {
            $jsonData = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            if (!in_array('Content-Type: application/json', $headers)) {
                $headers[] = 'Content-Type: application/json';
            }
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        // Логирует всё
        $this->logRequest($method, $url, $data, $response, $httpCode, $error);

        if ($error) {
            throw new Exception("cURL Error: $error");
        }

        return [
            'status' => $httpCode,
            'body' => json_decode($response, true)
        ];
    }

    // Логирует все HTTP-запросы
    private function logRequest(string $method, string $url, ?array $data, string $response, int $httpCode, string $error): void
    {
        $logEntry = sprintf(
            "[%s] %s %s\nData: %s\nStatus: %d\nResponse: %s\nError: %s\n\n",
            date('Y-m-d H:i:s'),
            $method,
            $url,
            json_encode($data, JSON_PRETTY_PRINT),
            $httpCode,
            $response,
            $error ?: 'none'
        );

        file_put_contents($this->logFile, $logEntry, FILE_APPEND);
    }
}
