<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Request\PostData;


use Symfony\Component\HttpFoundation\Request;

interface PostDataServiceInterface
{
    public function getPostedData(Request $request): array;
}