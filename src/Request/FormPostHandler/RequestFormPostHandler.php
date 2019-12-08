<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Request\FormPostHandler;


use Lukasz93P\SymfonyHttpApi\Request\Errors\FormErrorsExtractor;
use Lukasz93P\SymfonyHttpApi\Request\PostData\PostDataService;
use Lukasz93P\SymfonyHttpApi\Response\Responder\ApiResponderService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestFormPostHandler
{
    private PostDataService $postDataService;

    private ApiResponderService $apiResponder;

    private FormErrorsExtractor $formErrorsExtractor;

    private FormFactoryInterface $formFactory;

    public static function instance(FormFactoryInterface $formFactory): self
    {
        return new self(new PostDataService(), ApiResponderService::instance(), new FormErrorsExtractor(), $formFactory);
    }

    private function __construct(
        PostDataService $postDataService,
        ApiResponderService $apiResponder,
        FormErrorsExtractor $formErrorsExtractor,
        FormFactoryInterface $formFactory
    ) {
        $this->postDataService = $postDataService;
        $this->apiResponder = $apiResponder;
        $this->formErrorsExtractor = $formErrorsExtractor;
        $this->formFactory = $formFactory;
    }

    public function handlePostData(
        string $formTypeClass,
        $formValuableObject,
        Request $request,
        callable $onFormValid,
        callable $onFormInvalid = null
    ): JsonResponse {
        $form = $this->formFactory->create($formTypeClass, $formValuableObject);
        $form->submit($this->postDataService->getPostedData($request));

        if (!$form->isValid()) {
            return $onFormInvalid
                ? $onFormInvalid()
                : $this->apiResponder->sendError($this->formErrorsExtractor->extractErrors($form), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $onFormValid();
    }

}