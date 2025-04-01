<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
    * Display account page
    */
    #[Route('/user/account', name: 'app_account', methods: ['GET'])]
    public function account(): Response
    {
        return $this->render('/user/account.html.twig', [
                'items' => $this->userService->account(),
                'user' => $this->getUser(),
            ]);         
    }

    /**
    * Delete user account and all data linked
    */
    #[Route('/user/account/delete', name: 'app_account_delete')]
    public function accountDelete(Security $security): Response
    {
        $this->userService->accountDelete();
        $security->logout(false); //false for token not required

        return $this->redirectToRoute('app_registration');
    }

    /**
    * Activate or desactivate apiaccess
    */
    #[Route(path: '/user/apiaccess/{api}', name: 'app_apiaccess')]
    public function apiAccess(int $api) : Response
    {
        $this->userService->apiAccess($api);
        return $this->redirectToRoute('app_account');
    }
}