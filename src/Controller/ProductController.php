<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(ProductRepository $productRepository): Response
    {
        $product = $productRepository->findAll();

        return $this->render('/product/home.html.twig', [
            'products' => $product,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product')]
    public function product(Product $product): Response
    {
        return $this->render('/product/product.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/api/products', name: 'api_products', methods: ['GET'])]
    public function getProducts(ProductRepository $productRepository,
     SerializerInterface $serializer): JsonResponse
    {
        $productList = $productRepository->findAll();
        $jsonProductList = $serializer->serialize($productList, 'json', ['groups' => 'getProducts']);

        return new JsonResponse($jsonProductList, Response::HTTP_OK, [], true);
    }
    
}
