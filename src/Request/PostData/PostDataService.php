<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Request\PostData;


use Symfony\Component\HttpFoundation\Request;

class PostDataService
{
    public function getPostedData(Request $request): array
    {
        $jsonData = json_decode($request->getContent() ?? '[]', true, 512, JSON_THROW_ON_ERROR) ?? [];

        return array_merge($jsonData, $request->files->all());
    }

}