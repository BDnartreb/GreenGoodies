<?php

namespace App\Service\User;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService {

    private $security;
    private $orderRepository;
    private $orderDetailRepository;
    private $productRepository;
    private $request;
    private $userPasswordHasher;
    private $em;

    public function __construct(
        Security $security,
        OrderRepository $orderRepository,
        OrderDetailRepository $orderDetailRepository,
        ProductRepository $productRepository,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $em,
        )
    {
        $this->security = $security;
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->em = $em;
    }

    public function account(){

        $user = $this->security->getUser();
        $orders = $this->orderRepository->findBy(['client' => $user]);
        $items = [];
        foreach ($orders as $order)
        {
            $orderId = $order->getId();
            $date = $order->getDate();
            $date = $date->format('d/m/Y');
            $orderDetails = $this->orderDetailRepository->findBy(['orderId' => $orderId]);
            $total = 0;

            foreach ($orderDetails as $orderDetail) {
                $quantity = $orderDetail->getQuantity();
                $productId = $orderDetail->getProductId();
                $product = $this->productRepository->find($productId);
                $price = $product->getPrice();
                $total += $price * $quantity;
            }

            $items[] = [
                'number' => $orderId,
                'date' => $date,
                'total' => $total
            ];
        }
        return $items;

    }

    // public function registration() {
    //     $user = new User();

    //     $form = $this->createForm(RegistrationType::class, $user);
    //     $form->handleRequest($this->request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $plainPassword = $form->get('password')->getData();
    //         $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));
    //         $user->setRoles(['ROLE_USER']);
    //         $this->em->persist($user);
    //         $this->em->flush();

    //         return $this->redirectToRoute('app_login');
    //     }
    //     return $form;
    // }

    public function accountDelete()
    {
        $user = $this->security->getUser();
        $this->em->remove($user);
        $this->em->flush();
    }

    public function apiAccess(int $api)
{
    $user = $this->security->getUser();
    if ($api == 0){
        $user->setRoles(['ROLE_USER']);
    } elseif ($api == 1){
        $user->setRoles(['ROLE_API']);
    }
    $this->em->persist($user);
    $this->em->flush();
}







}