<?php

namespace App\Services\Http\Response;

use App\Exceptions\Http\APIResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class APIResponse
{
    private static $response = [];
    private static $statusCode;
    private static $headers = [];
    private static $_instance;

    private function __construct()
    {
        self::$response = [];
        self::$statusCode = 200;
        self::$headers = [];
    }

    public static function build(): self
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function send(): JsonResponse
    {
        return response()->json(self::$response, self::$statusCode, self::$headers);
    }

    public static function statusCode(string $code): self
    {
        self::$statusCode = $code;

        return self::$_instance;
    }

    public static function headers(array $headers): self
    {
        self::$headers = $headers;

        return self::$_instance;
    }

    public static function status(string $status): self
    {
        $status = strtolower($status);
        $validTypes = ['success', 'error'];

        if (!in_array($status, $validTypes)) {
            throw new APIResponseException('[InvalidTypeError]: Invalid type provided. Please choose from: ' . implode(',', $validTypes));
        }

        self::$response['status'] = $status;

        return self::$_instance;
    }

    public static function message(string $message): self
    {
        self::$response['message'] = $message;

        return self::$_instance;
    }

    public static function data($data): self
    {
        self::$response['data'] = $data;

        return self::$_instance;
    }

    public static function images(array $images): self
    {
        self::$response['images'] = $images;

        return self::$_instance;
    }

    public static function redirectTo(string $url): self
    {
        self::$response['redirectTo'] = $url;

        return self::$_instance;
    }

    public static function messageDisplayDuration(int $microSeconds): self
    {
        self::$response['notificationDisplayTime'] = $microSeconds;

        return self::$_instance;
    }

    public static function clearForm(bool $clear = true): self
    {
        self::$response['clearForm'] = $clear;

        return self::$_instance;
    }

    public static function hideModal(string $modalId): self
    {
        self::$response['hideModal'] = $modalId;

        return self::$_instance;
    }

    public static function showModal(string $modalId): self
    {
        self::$response['showModal'] = $modalId;

        return self::$_instance;
    }

    public static function hideSidebar(string $sidebarId): self
    {
        self::$response['hideSidebar'] = $sidebarId;

        return self::$_instance;
    }

    public static function showSidebar(string $sidebarId): self
    {
        self::$response['showSidebar'] = $sidebarId;

        return self::$_instance;
    }

    public static function hideSection(string $elementId): self
    {
        self::$response['hideSection'] = $elementId;

        return self::$_instance;
    }

    public static function showSection(string $elementId): self
    {
        self::$response['showSection'] = $elementId;

        return self::$_instance;
    }

    public static function refresh(): self
    {
        self::$response['refresh'] = true;

        return self::$_instance;
    }

    public static function html(string $id, string $pathToView): self
    {
        self::$response['html'] = [
            'id' => $id,
            'content' => view($pathToView),
        ];

        return self::$_instance;
    }

    public static function refreshDataTable(string $tableId): self
    {
        self::$response['refreshDataTable'] = $tableId;

        return self::$_instance;
    }

    public static function errors(array $errors): self
    {
        self::$response['errors'] = $errors;

        return self::$_instance;
    }

    public static function sendInternalServerError(\Throwable $th): JsonResponse
    {
        Log::error($th);

        $response = self::build()
            ->status('error')
            ->statusCode(500)
            ->message('Error! Something went wrong.');

        if (!isProductionEnv()) {
            $response = $response
                ->data([
                    'message' => $th->getMessage(),
                    'trace' => $th->getTraceAsString(),
                ]);
        }

        return $response->send();
    }
}
