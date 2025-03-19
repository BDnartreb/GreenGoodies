<?php

namespace App\Service\Cart;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;//depreciated

class CartService {

    private $requestStack;
    private $productRepository;

    public function __construct(RequestStack $requestStack,
        ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    /**
     * Ajoute un produit au panier
     */
    public function add(int $id){
        $session = $this->requestStack->getSession();
        //$session = $this->requestStack->getCurrentRequest();
        $cart = $session->get('cart', []);
        
        if(!empty($cart[$id])) {
            $cart[$id]++;
         } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);
    }

/**
 * Récupère la session, extrait le panier
 * Récupère le détail des produits contenus dans la panier
 * et leur quantité 
 */
    public function getCart() {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        $cartWithData = [];
        foreach($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
       return $cartWithData;
    }
/**
 * Fait le total du panier
 * Appelle la fonction getCart() pour récupérer $cartWithData 
 * contenant le panier avec le détail des produits
 * pour calcul le prix total 
 */
    public function getTotal() : float
    {
        $total = 0;
        foreach($this->getCart() as $item){
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        return $total;
    }

    public function remove(int $id)
    {
        //$session = $this->requestStack->getSession();
        //$cart = $session->get('cart', []);
        $cart = $this->requestStack->getSession()->get('cart', []);
        if(!empty($cart[$id])){
            unset($cart[$id]);
        }
        //$session->set('cart', $cart);
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function order()
    {
        $cart = $this->requestStack->getSession()->get('cart', []);

        $user = new User();
        $user = $this->requestStack->getSession()->get('client');

        $order = new Order();
        $order->setClient($user);
        $order->setDate(new \DateTime());

        foreach($cart as $carts) {
            $order->$cart->addProducts();
        }
        return $order;
    }

}