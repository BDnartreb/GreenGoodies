<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
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

    #[Route('/user/account', name: 'app_account', methods: ['GET'])]
    public function account(UserService $userService): Response
    {
        return $this->render('/user/account.html.twig', [
                'items' => $userService->account(),
                'user' => $this->getUser(),
            ]);         
    }

    /**
    * Delete user account and all data linked
    */
    #[Route('/user/account/delete', name: 'app_account_delete')]
    public function accountDelete(UserService $userService, Request $request, SessionInterface $session): Response
    {
        $userService->accountDelete();
        $session = $request->getSession();
        
        $session->invalidate();

        return $this->redirectToRoute('app_registration');
    }

    /**
    * Activate or desactivate apiaccess
    */
    #[Route(path: '/user/apiaccess/{api}', name: 'app_apiaccess')]
    public function apiAccess(UserService $userService, int $api) : Response
    {
        $userService->apiAccess($api);
        return $this->redirectToRoute('app_account');
    }
}