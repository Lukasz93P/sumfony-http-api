<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Request\Errors;


use Symfony\Component\Form\FormInterface;

interface FormErrorsExtractorInterface
{
    public function extractErrors(FormInterface $form): array;
}