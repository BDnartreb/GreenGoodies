<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function home(ProductRepository $productRepository): Response
    {
        $product = $productRepository->findAll();

        return $this->render('/product/home.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $product,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product', methods: ['GET'])]
    public function product(Product $product): Response
    {
        return $this->render('/product/product.html.twig', [
            'product' => $product,
        ]);
    }

    /*#[Route('/api/products', name: 'api_product', methods: ['GET'])]
    public function getProducts(): JsonResponse
    {
       
    }*/
    
}
