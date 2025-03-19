<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
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
/**
 * Poursupprimer un produit dans le panier
 * appelée depuis le fichier twg avec la route et l'id du produit à supprimer
 */
    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove($id, CartService $cartService): Response
    {
        $cartService->remove($id);
        return $this->redirectToRoute("app_cart");
    }

    #[Route('/cart/validate', name: 'app_cart_validate')]
    public function order(CartService $cartService, EntityManager $em): Response
    {
        $order = $cartService->order();

        $em->persist($order);
        $em->flush();
        return $this->redirectToRoute("app_cart");
    }





}


 /*  #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);
        
        if(!empty($cart[$id])) {
            $cart[$id]++;
         } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);
        dd($session->get('cart'));
        //return $this->redirectToRoute("app_cart");
    }*/

     /*#[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, SessionInterface $session): Response
    {
        //$session = $request->getSession();
        $cart = $session->get('cart', []);
        
        if(!empty($cart[$id])) {
            $cart[$id]++;
         } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);
        //dd($session->get('cart'));
        return $this->redirectToRoute("app_cart");
    }*/

     /*#[Route('/cart', name: 'app_cart', methods: ['GET'])]
    public function getCart(SessionInterface $session, ProductRepository $productRepository): Response
    {
            $cart = $session->get('cart', []);
            $cartWithData = [];
            foreach($cart as $id => $quantity) {
                $cartWithData[] = [
                    'product' => $productRepository->find($id),
                    'quantity' => $quantity
                ];
            }
            dd($cartWithData);

            $total = 0;
            foreach($cartWithData as $item){
                $totalItem = $item['product']->getPrice() * $item['quantity'];
                $total += $totalItem;
            }
    
        return $this->render('/user/cart.html.twig', [
            'items' => $cartWithData,
            'total' => $total,
        ]);
    }*/