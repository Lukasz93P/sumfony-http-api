<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Request\Errors;


use Symfony\Component\Form\FormInterface;

class FormErrorsExtractor
{
    public function extractErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if (($childForm instanceof FormInterface) && $childErrors = $this->extractErrors($childForm)) {
                $errors[$childForm->getName()] = $childErrors;
            }
        }

        return $errors;
    }

}