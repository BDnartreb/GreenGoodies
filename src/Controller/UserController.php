<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    private $security;
    private $requestStack;

    public function __construct(RequestStack $requestStack,
    Security $security)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    #[Route('/user/account', name: 'app_account', methods: ['GET'])]
    public function account(UserService $userService): Response
    {
        return $this->render('/user/account.html.twig', [
                'items' => $userService->account(),
                'user' => $this->getUser(),
            ]);         
    }

    // #[Route('/registration', name: 'app_registration')]
    // public function registration(UserService $userService): Response
    // {
    //     return $this->render('connection/registration.html.twig', [
    //         'form' => $userService->registration(),
    //     ]);
    // }

    #[Route('/registration', name: 'app_registration')]
    public function registration(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $em): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRoles(['ROLE_USER']);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('connection/registration.html.twig', [
            'form' => $form, 
        ]);
    }

/**
 * Delete user account all data linked
 * 
 */
    #[Route('/user/account/delete', name: 'app_account_delete')]
    public function accountDelete(UserService $userService): Response
    {
        $userService->accountDelete();
        return $this->redirectToRoute('app_registration');
    }

    // #[Route('/user/account/delete', name: 'app_account_delete')]
    // public function accountDelete(EntityManagerInterface $em): Response
    // {
    //     $user = $this->security->getUser();
    //     $em->remove($user);
    //     $em->flush();
    //     return $this->redirectToRoute('app_registration');
    // }

    #[Route(path: '/user/apiaccess/{api}', name: 'app_apiaccess')]
    public function apiAccess(UserService $userService, int $api) : Response
    {
        $userService->apiAccess($api);
        return $this->redirectToRoute('app_account');
    }

    // #[Route(path: '/user/apiaccess/{api}', name: 'app_apiaccess')]
    // public function apiAccess(
    //     int $api,
    //     EntityManagerInterface $em
    //     ) : Response
    // {
    //     $user = $this->security->getUser();
    //     if ($api == 0){
    //         $user->setRoles(['ROLE_USER']);
    //     } elseif ($api == 1){
    //         $user->setRoles(['ROLE_API']);
    //     }
    //     $em->persist($user);
    //     $em->flush();

    //     return $this->redirectToRoute('app_account');
    // }
}


// #[Route('/user/account', name: 'app_account', methods: ['GET'])]
    // public function account(
    //     OrderRepository $orderRepository,
    //     OrderDetailRepository $orderDetailRepository,
    //     ProductRepository $productRepository): Response
    // {
    //     $userService->account();
    //     $user = $this->security->getUser();
    //     //$user = $this->getUser();
    //     $orders = $orderRepository->findBy(['client' => $user]);
    //     $items = [];
    //     foreach ($orders as $order)
    //     {
    //         $orderId = $order->getId();
    //         $date = $order->getDate();
    //         $date = $date->format('d/m/Y');
    //         $orderDetails = $orderDetailRepository->findBy(['orderId' => $orderId]);
    //         $total = 0;

    //         foreach ($orderDetails as $orderDetail) {
    //             $quantity = $orderDetail->getQuantity();
    //             $productId = $orderDetail->getProductId();
    //             $product = $productRepository->find($productId);
    //             $price = $product->getPrice();
    //             $total += $price * $quantity;
    //         }

    //         $items[] = [
    //             'number' => $orderId,
    //             'date' => $date,
    //             'total' => $total
    //         ];
    //     }

    //     return $this->render('/user/account.html.twig', [
    //             'items' => $items,
    //             'user' => $user,
    //         ]);         
    // }