<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegistrationType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class UserController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }



    #[Route('/user/account', name: 'app_account', methods: ['GET'])]
    public function account(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAll();
        $user = $this->getUser();
        dump($user);

        return $this->render('/user/account.html.twig', [
            'controller_name' => 'UserController',
            'orders' => $order,
            'user' => $user,
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
/*
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request,
        AuthenticationUtils $authenticationUtils, 
        UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);

      
        return $this->render('connection/login.html.twig', [
            'form' => $form,
            'last_username' => $lastUsername,
            'error' => $error,
            //'session' => $session,
        ]);

    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }*/

    /*#[Route(path: '/user/apiaccess', name: 'app_apiaccess')]
    public function apiAccess(Request $request,
        EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        $userEmail = $session->get('email');
        dd($session);
        return $this->redirectToRoute('app_registration');

       $user->setRoles(['ROLE_TOTO']);
        $em->persist($user);
        $em->flush();
        //$userRole [] = $user->getRoles();
        
        //if( $currentUserRole = ['ROLE_USER']) {
          //  $user = $this->setRoles(['ROLE_API']);
        }

        if($currentUserRole = ['ROLE_API']) {
            $currentUser->setRoles(['ROLE_USER']);
        }
    }*/
}
