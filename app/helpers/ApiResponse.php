<?php
// app/helpers/ApiResponse.php

class ApiResponse
{
    /**
     * Send a JSON success response.
     *
     * @param mixed       $data    Payload (array, DTO, etc.)
     * @param string      $message Human-readable message
     * @param int         $status  HTTP status code
     */
    public static function success($data = null, string $message = 'OK', int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send a JSON error response.
     */
    public static function error(string $message = 'Error', int $status = 400, $errors = null): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        $body = [
            'success' => false,
            'message' => $message,
        ];
        if ($errors !== null) {
            $body['errors'] = $errors;
        }
        echo json_encode($body, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send a paginated success response.
     */
    public static function paginated(array $data, array $pagination, string $message = 'OK'): void
    {
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success'    => true,
            'message'    => $message,
            'data'       => $data,
            'pagination' => $pagination,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // ── DTO Serializers ──────────────────────────────────────

    /**
     * Convert a single DTO to an array including its id.
     */
    public static function dto(object $dto): array
    {
        return ['id' => $dto->id] + $dto->toArray();
    }

    /**
     * Convert an array of DTOs to arrays including ids.
     *
     * @param object[] $dtos
     * @return array[]
     */
    public static function dtoList(array $dtos): array
    {
        return array_map([self::class, 'dto'], $dtos);
    }

    // ── Helpers ──────────────────────────────────────────────

    /**
     * Read JSON body from the request (for PUT/PATCH/POST with JSON).
     */
    public static function jsonBody(): array
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    /**
     * Get request body from either JSON or form data.
     */
    public static function body(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (stripos($contentType, 'application/json') !== false) {
            return self::jsonBody();
        }

        // For form-encoded (POST) or multipart
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $_POST;
        }

        // For PUT/PATCH with form data, parse php://input
        parse_str(file_get_contents('php://input'), $data);
        return $data;
    }
}
