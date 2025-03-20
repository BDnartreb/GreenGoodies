<?php

namespace App\Service\Cart;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;//depreciated

class CartService {

    private $requestStack;
    private $productRepository;
    private $orderRepository;
    private $em;
    private $security;

    public function __construct(
        RequestStack $requestStack,
        ProductRepository $productRepository,
        OrderRepository $orderRepository,
        EntityManagerInterface $em,
        Security $security)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->em = $em;
        $this->security = $security;
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

    public function cartToOrder()
    {
        $user = $this->security->getUser();

        $order = new Order();
        $order->setClient($user);
        $order->setDate(new \DateTime());
        $this->em->persist($order);
        $this->em->flush();

        $orderId = $order->getId();
        $order = $this->orderRepository->find($orderId);

        $items = $this->requestStack->getSession()->get('cart', []);

        foreach ($items as $product_id => $quantity) {
            $product = $this->productRepository->find($product_id);
            if ($product) {
                $orderDetail = new OrderDetail();
                $orderDetail->setQuantity($quantity);
                $orderDetail->setProductId($product);
                $orderDetail->setOrderId($order);
                $this->em->persist($orderDetail);
            }  
        }
        $this->em->flush();
        $this->requestStack->getSession()->set('cart', []);
        
        
    }
}