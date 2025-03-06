<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('/product/home.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/{id}', name: 'app_product', methods: ['GET'])]
    public function product(Product $product): Response
    {
        return $this->render('/product/product.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/api/products', name: 'api_product', methods: ['GET'])]
    public function getProducts(): JsonResponse
    {
       
    }


    
}
