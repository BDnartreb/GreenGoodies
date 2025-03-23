<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Symfony\Component\Clock\now;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    private $productRepository;
    private $userRepository;
    private $orderRepository;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, 
    ProductRepository $productRepository,
    UserRepository $userRepository,
    OrderRepository $orderRepository)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function load(ObjectManager $manager): void
    {    
    //USERS AND PRODUCTS
        $users = [
            ['didier.mozart@greengoodies.com', 'ROLE_USER', 'password', 'Didier', 'Mozart'],
            ['api.user@greengoodies.com', 'ROLE_API', 'password', 'Api', 'ApiUser']
        ];

        $products = [

            ['Kit d hygiène recyclable', 'Pour une salle de bain éco-frendly', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_1_Lite', 0, 24.99],
            ['Shot Tropical', 'Fruit frais, pressés à froid', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_2_Lite', 0, 5.50],
            ['Gourde en bois', '50cl, bois d olivier', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_3_Lite', 0, 16.90],
            ['Disque Démaquillants x3', 'Solution efficace pour vous démaquiller en douceur', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_4_Lite', 0, 19.90],
            ['Bougie Lavande & Patchouli', 'Cire naturelle', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_5_Lite', 0, 32.00],
            ['Brosse à dent', 'Bois de hêtre rouge issu de forêts gérées durablement', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_6_Lite', 0, 5.40],
            ['Kit de couverts en bois', 'Revêtement Bio en olivier & sac de transport', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_7_Lite', 0, 12.30],
            ['Nécessaire, déodorant Bio', '50ml déodorant à l eucalyptus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_8_Lite', 0, 8.50],
            ['Savon Bio', 'Thé, Orange & Girofle', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a.', 'Product_9_Lite', 0, 18.90],
        ];

        foreach ($users as $user) {
            $newuser = new User();
            $newuser->setEmail($user[0]);
            $newuser->setRoles([$user[1]]);
            $newuser->setPassword($this->userPasswordHasher->hashPassword($newuser, $user[2]));
            $newuser->setFirstName($user[3]);
            $newuser->setLastName($user[4]);
            $manager->persist($newuser);
        }

        foreach ($products as $product) {
            $newproduct = new Product();
            $newproduct->setName($product[0]);
            $newproduct->setDescriptionShort($product[1]);
            $newproduct->setDescriptionLong($product[2]);
            $newproduct->setImage($product[3]);
            $newproduct->setStock(random_int(1,9));
            $newproduct->setPrice($product[5]);
            $manager->persist($newproduct);
        }
        $manager->flush();

        //ORDERS

        $userList = $this->userRepository->findAll();
         $min = new DateTime('2025-01-01 00:00:00');
         $max = new DateTime('2025-03-22 23:59:59');
        
        for ($i = 0 ; $i < 10; $i++) {
            $neworder = new Order();
            $neworder->setClient($userList[array_rand($userList)]);
            //$neworder->setDate(new \DateTime());
            $neworder->setDate($this->getRandomDateBetween($min, $max));
            $manager->persist($neworder);
            $orders [] = $neworder;
        }
        
        // ORDER_DETAIL
        $productList = $this->productRepository->findAll();

        foreach ($orders as $order) {
            $orderDetail = new OrderDetail();
            $orderDetail->setOrderId($order);
            $orderDetail->setQuantity(random_int(1, 3));
            $orderDetail->setProductId($productList[array_rand($productList)]);
            $manager->persist($orderDetail);
        }

        for ($j=0; $j < 20; $j++){
            $orderDetail = new OrderDetail();
            $orderDetail->setOrderId($orders[array_rand($orders)]);
            $orderDetail->setQuantity(random_int(1, 3));
            $orderDetail->setProductId($productList[array_rand($productList)]);
            $manager->persist($orderDetail);
        }
        $manager->flush();    
    }
    
    private function getRandomDateBetween(DateTime $min, DateTime $max): DateTime
    {
        // Convert dates in timestamps
        $minTimestamp = $min->getTimestamp();
        $maxTimestamp = $max->getTimestamp();
        
        // Create a random timestamp between min and max
        $randomTimestamp = random_int($minTimestamp, $maxTimestamp);
        
        // Return a DateTime object
        return (new DateTime())->setTimestamp($randomTimestamp);
    }
}
