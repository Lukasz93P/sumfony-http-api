<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Response\Responder;


use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponderService
{
    private array $cookies = [];

    private array $headers = [];

    public function setCookie(string $name, string $value, int $expirationInSecond, array $rest = []): ApiResponderService
    {
        $this->cookies[] = new Cookie($name, $value, time() + $expirationInSecond, ...$rest);

        return $this;
    }

    public function setHeader(string $key, string $value): ApiResponderService
    {
        $this->headers[] = [$key, $value];

        return $this;
    }

    public function sendSuccess($data = [], int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->prepareResponse($data ? ['data' => $data] : null, $statusCode);
    }

    public function sendError($data = [], int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return $this->prepareResponse($data ? ['error' => $data] : null, $statusCode);
    }

    private function prepareResponse($data, int $statusCode): JsonResponse
    {
        $response = !empty($data) ? new JsonResponse($data) : new JsonResponse();
        $response->setStatusCode($statusCode);
        array_map(
            static function (Cookie $cookie) use ($response) {
                $response->headers->setCookie($cookie);
            },
            $this->cookies
        );

        array_map(
            static function (array $headerData) use ($response) {
                $response->headers->set($headerData[0], $headerData[1]);
            },
            $this->headers
        );


        return $response;
    }

}