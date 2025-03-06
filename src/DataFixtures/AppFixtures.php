<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {        
        $user = new User();
        $user->setEmail("didier.mozart@greengoodies.com");
        $user->setFirstName("Didier");
        $user->setLastName("Mozart");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);
        $listUser[] = $user;

        $userApi = new User();
        $userApi->setEmail("joe.api@greengoodies.com");
        $userApi->setFirstName("Joe");
        $userApi->setLastName("Api");
        $userApi->setRoles(["ROLE_API"]);
        $userApi->setPassword($this->userPasswordHasher->hashPassword($userApi, "password"));
        $manager->persist($userApi);
        $listUser[] = $userApi;

        for ($i=3; $i<10; $i++) {
            $newUser = new User();
            $newUser->setFirstName('Prenom ' . $i);
            $newUser->setLastName('Nom' . $i);
            $newUser->setRoles(["ROLE_USER"]);
            $newUser->setPassword($this->userPasswordHasher->hashPassword($newUser, "password"));
            $manager->persist($newUser);
            
            $listUser[] = $newUser;
        }

        /*Objectif créer une commande avec des produits et un client associé
        for ($i=0; $i<10; $i++) {
            $order = new Order();
            $order->setDate();
            $order->setProduct();
            $order->setValidated();
            $order->setClient();

            'archived' => self::faker()->boolean(),

        }
        */
        /*for ($i = 0; $i < 20; $i++) {
            $book = new Book;
            $book->setTitle('Livre ' . $i);
            $book->setCoverText('Quatrième de couverture numéro : ' . $i);
            //relation author/book with random id from array listAuthor 
            $book->setAuthor($listAuthor[array_rand($listAuthor)]);
            $manager->persist($book);
        }*/

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
