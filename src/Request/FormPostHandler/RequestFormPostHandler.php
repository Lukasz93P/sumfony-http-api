<?php
declare(strict_types=1);

namespace Lukasz93P\SymfonyHttpApi\Request\FormPostHandler;


use Lukasz93P\SymfonyHttpApi\Request\Errors\FormErrorsExtractorInterface;
use Lukasz93P\SymfonyHttpApi\Request\PostData\PostDataServiceInterface;
use Lukasz93P\SymfonyHttpApi\Response\Responder\ApiResponderServiceInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestFormPostHandler implements RequestFormPostHandlerInterface
{
    private PostDataServiceInterface $postDataService;

    private ApiResponderServiceInterface $apiResponder;

    private FormErrorsExtractorInterface $formErrorsExtractor;

    private FormFactoryInterface $formFactory;

    public function __construct(
        PostDataServiceInterface $postDataService,
        ApiResponderServiceInterface $apiResponder,
        FormErrorsExtractorInterface $formErrorsExtractor,
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