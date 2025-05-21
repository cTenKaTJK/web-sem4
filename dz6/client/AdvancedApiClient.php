<?php

 // Класс AdvancedApiClient — расширяет BasicApiClient,
 // добавляя обработку HTTP ошибок и исключений.

require_once __DIR__ . '/BasicApiClient.php';

// Исключение при ошибках HTTP
class HttpException extends Exception
{
    private $statusCode;
    private $response;

    public function __construct(int $statusCode, string $response)
    {
        $this->statusCode = $statusCode;
        $this->response = $response;
        parent::__construct("HTTP error: Status code $statusCode, Response: $response");
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponse(): string
    {
        return $this->response;
    }
}

// Исключение при ошибках JSON
class ApiJsonException extends Exception
{
    private $rawResponse;

    public function __construct(string $message, string $rawResponse)
    {
        $this->rawResponse = $rawResponse;
        parent::__construct("JSON parse error: $message, Raw response: $rawResponse");
    }

    public function getRawResponse(): string
    {
        return $this->rawResponse;
    }
}

class AdvancedApiClient extends BasicApiClient
{
    // Переопределяем метод запроса для обработки статусов и JSON
    // HttpException при ошибках HTTP
    // ApiJsonException при ошибках парсинга JSON
    // Exception при других ошибках
    protected function customRequest(string $method, string $endpoint, ?array $data, array $headers): array
    {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false); // Позволяет получить тело ответа при ошибках
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Проверка SSL сертификата

        if ($data !== null) {
            $jsonData = json_encode($data);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ApiJsonException(json_last_error_msg(), print_r($data, true));
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            $headers[] = 'Content-Type: application/json';
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);

        curl_close($ch);

        $this->logRequest($method, $url, $data, $response, $httpCode, $curlError);

        // Обработка ошибок cURL
        if ($curlError) {
            throw new Exception(sprintf(
                "cURL error (%d): %s",
                $curlErrno,
                $curlError
            ));
        }

        // Детальная обработка HTTP статусов
        if ($httpCode >= 400) {
            switch (true) {
                case $httpCode == 401:
                    throw new HttpException($httpCode, "Unauthorized: Authentication required");
                case $httpCode == 403:
                    throw new HttpException($httpCode, "Forbidden: Access denied");
                case $httpCode == 404:
                    throw new HttpException($httpCode, "Not Found: Resource not found");
                case $httpCode >= 500:
                    throw new HttpException($httpCode, "Server Error: $response");
                default:
                    throw new HttpException($httpCode, $response);
            }
        }

        // Проверка на пустой ответ
        if (empty($response)) {
            return [
                'status' => $httpCode,
                'body' => null
            ];
        }

        // Парсим JSON с подробной обработкой ошибок
        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiJsonException(json_last_error_msg(), $response);
        }

        return [
            'status' => $httpCode,
            'body' => $decoded
        ];
    }
}
