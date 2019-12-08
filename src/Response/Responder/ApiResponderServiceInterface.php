<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Response\Responder;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

interface ApiResponderServiceInterface
{
    public function setCookie(string $name, string $value, int $expirationInSecond, array $rest = []): self;

    public function setHeader(string $key, string $value): self;

    /**
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendSuccess($data = [], int $statusCode = Response::HTTP_OK): JsonResponse;

    /**
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendError($data = [], int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse;
}