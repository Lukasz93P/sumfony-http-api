<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Request\PostData;


use Symfony\Component\HttpFoundation\Request;

class PostDataService
{
    public function getPostedData(Request $request): array
    {
        $postData = $request->getContent()
            ? json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR)
            : $request->request->all();

        return array_merge($postData, $request->files->all());
    }

}