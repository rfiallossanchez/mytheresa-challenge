<?php

declare(strict_types=1);

namespace Challenge\Catalog\Infrastructure\Api\Controller;

use Challenge\Catalog\Application\Search\SearchProductQuery;
use Challenge\Catalog\Application\Search\SearchProductUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SearchProductController extends AbstractController
{
    public function __invoke(
        Request $request,
        ValidatorInterface $validator,
        SearchProductUseCase $searchProductUseCase,
    ): JsonResponse
    {
        $query = new SearchProductQuery();
        $query->category = $request->query->get('category');
        $query->priceLessThan = $request->query->get('priceLessThan');
        $errors = $validator->validate($query);

        if (count($errors) > 0) {
            throw new BadRequestHttpException((string)$errors);
        }

        return new JsonResponse(
            ($searchProductUseCase)($query),
            Response::HTTP_OK
        );
    }
}
