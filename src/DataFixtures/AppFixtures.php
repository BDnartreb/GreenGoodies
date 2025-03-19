<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use App\Factory\OrderFactory;
use App\Factory\ProductFactory;
use App\Factory\UserFactory;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Symfony\Component\Clock\now;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    private $productRepository;
    private $userRepository;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher, 
    ProductRepository $productRepository,
    UserRepository $userRepository)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

// methode privée avec tableau products

    public function load(ObjectManager $manager): void
    {      
     /////////////////////////////////////////////////////////////////////////////////////////////   
     //   UserFactory::createMany(3);
     //   ProductFactory::createMany(9);
        //OrderFactory::createMany(6);

        $products = $this->productRepository->findAll();
        $users = $this->userRepository->findAll();

        if (empty($products)) {
            throw new \Exception('Aucun produit n\'a été trouvé.');
        }
        if (empty($users)) {
            throw new \Exception('Aucun user n\'a été trouvé.');
        }

        for ($i = 0; $i < 6; $i++){
            $order = new Order();
            //$order->setClient(UserFactory::random());
            $order->setClient($users[array_rand($users)]);
            $order->setDate(new \DateTime());
            
                for ($j=0; $j < mt_rand(1,3); $j++){
                    $order->addProduct($products[mt_rand(0, count($products) -1)]);                }
            $manager->persist($order);
        }
        $manager->flush();
    }
}
     /////////////////////////////////////////////////////////////////////////////////////////////   
  
     /*

        $user = new User();
        $user->setEmail("didier.mozart@greengoodies.com");
        $user->setFirstName("Didier");
        $user->setLastName("Mozart");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);
        $userList[] = $user;

        $userApi = new User();
        $userApi->setEmail("admin.api@greengoodies.com");
        $userApi->setFirstName("Admin");
        $userApi->setLastName("Api");
        $userApi->setRoles(["ROLE_API"]);
        $userApi->setPassword($this->userPasswordHasher->hashPassword($userApi, "password"));
        $manager->persist($userApi);
        $userList[] = $userApi;

        for ($i=3; $i<10; $i++) {
            $newUser = new User();
            $newUser->setEmail('newuser' . $i . '@greengoodies.com');
            $newUser->setFirstName('Prenom ' . $i);
            $newUser->setLastName('Nom' . $i);
            $newUser->setRoles(["ROLE_USER"]);
            $newUser->setPassword($this->userPasswordHasher->hashPassword($newUser, "password"));
            $manager->persist($newUser);
            
            $userList[] = $newUser;
        }
        $manager->flush();
    }
}
*/
        

        /*for ($i=1; $i<10; $i++) {
            $product = new Product();
            $product->setName('NomProduit n°' . $i);
            $product->setDescriptionShort('Description Courte du Produit n°' . $i);
            $product->setDescriptionLong('Description Longue du Produit n°' . $i);
            $product->setImage('Chemin de l\'image du Produit n°' . $i);
            $product->setQuantity('Quantité : ');
            $product->setPrice('Prix du Produit n°' . $i . ':' . random_int(5, 250) . '€');
            $manager->persist($product);
            
            $productList[] = $product;
        }*/
/*
        for ($i; $i<10; $i) {
            $order = new Order();
            $order->setClient($userList[mt_rand(0, count($userList) -1)]);
            $order->setDate(new \DateTime());
            $order->setValidated(random_int(0,1));

            $orders [] = $order;
        }
*/

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