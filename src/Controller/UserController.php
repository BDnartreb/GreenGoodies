<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegistrationType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class UserController extends AbstractController
{
    #[Route('/user/basket', name: 'app_basket', methods: ['GET'])]
    public function basket(ProductRepository $productRepository): Response
    {
    // A DEVELOPPER
        //$user = $this->getUser();
        //$product = new Product();

        $product = $productRepository->findAll();
        
        return $this->render('/user/basket.html.twig', [
            'products' => $product,
            //'user' => $user,
        ]);
    }

    #[Route('/user/account', name: 'app_account', methods: ['GET'])]
    public function account(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAll();

        return $this->render('/user/account.html.twig', [
            'controller_name' => 'UserController',
            'orders' => $order,
        ]);
    }

    #[Route('/registration', name: 'app_registration')]
    public function registration(Request $request,
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

    #[Route('/login', name: 'app_login', methods: ['GET'])]
    public function login(Request $request,
        AuthenticationUtils $authenticationUtils): Response
    {
        $user = new User();

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);        

        return $this->render('connection/login.html.twig', [
            'form' => $form,
            'last_username' => $lastUsername,
            'error' => $error,
        ]);

        //return $this->redirectToRoute('app_home');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
