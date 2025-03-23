<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart', methods: ['GET'])]
    public function getCart(CartService $cartService): Response
    {
        return $this->render('/user/cart.html.twig', [
            'items' => $cartService->getCart(),
            'total' => $cartService->getTotal(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, CartService $cartService): Response
    {
        $cartService->add($id);
        return $this->redirectToRoute("app_cart");
    }

    #[Route('/cart/delete', name: 'app_cart_delete')]
    public function delete(SessionInterface $session): Response
    {
        $session->remove('cart');
        return $this->redirectToRoute("app_cart");
    }

    #[Route('/cart/validate', name: 'app_cart_validate')]
    public function order(CartService $cartService): Response
    {
        $cartService->cartToOrder();
        //Flash message
        $this->addFlash('success', 'La commande a bien été validée !');
        return $this->redirectToRoute("app_cart");
    }

     // /**
    //  * Delete a product from cart
    //  */
    // #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    // public function remove($id, CartService $cartService): Response
    // {
    //     $cartService->remove($id);
    //     return $this->redirectToRoute("app_cart");
    // }
}
