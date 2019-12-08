<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Request\FormPostHandler;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface RequestFormPostHandlerInterface
{
    public function handlePostData(
        string $formTypeClass,
        $formValuableObject,
        Request $request,
        callable $onFormValid,
        callable $onFormInvalid = null
    ): JsonResponse;
}