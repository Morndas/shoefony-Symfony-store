<?php

namespace App\DataFixtures;

use App\Entity\Store\Brand;
use App\Entity\Store\Color;
use App\Entity\Store\Comment;
use App\Entity\Store\Image;
use App\Entity\Store\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadUsers($this->encoder);
        $this->loadBrands();
        $this->loadColors();
        $this->loadProducts();
        $this->loadComments();

        $this->manager->flush();
    }

    private function loadProducts(): void
    {
        for ($i = 1; $i < 15; $i++) {

            if ($i % 5 === 0) {
                sleep(1);
            }

            $product = (new Product())
                ->setName('product '.$i)
                ->setSlug('product '.$i)
                ->setDescription('Description du produit '.$i)
                ->setDescriptionLongue('Description longue du produit '.$i)
                ->setPrice(mt_rand(10, 100))
            ;

            $image = (new Image())
                ->setUrl(sprintf('img/products/shoe-%d.jpg', $i))
                ->setAlt($product->getName())
            ;

            $product->setImage($image);

            /** @var Brand $brand */
            $brand = $this->getReference(Brand::class.random_int(0,3));
            $product->setBrand($brand);

            /** @var Color $color */
            for($j = 0; $j < 6 ; $j++) {
                if (rand(0,1)) {
                    $color = $this->getReference(Color::class . $j);
                    $product->addColor($color);
                }
            }

            $this->manager->persist($product);
            $this->addReference(Product::class.$i, $product);
        }
    }

    private function loadBrands()
    {
        $brandNames=['Adidas', 'Asics', 'Nike', 'Puma'];

        foreach ($brandNames as $key =>$name){
            $brand = (new Brand())
                ->setName($name);
            $this->manager->persist($brand);
            $this->addReference(Brand::class.$key, $brand);
        }
    }

    private function loadColors()
    {
        $colorNames =['Blanc', 'Noir', 'Rouge', 'Vert', 'Jaune', 'Bleu'];

        foreach ($colorNames as $key =>$name) {
            $color = (new Color())
                ->setName($name);
            $this->manager->persist($color);
            $this->addReference(Color::class.$key, $color);
        }
    }

    private function loadComments() {
        $pseudos = [ 'Morndas', 'ComboBreaker', 'Stonners', 'Shoma', 'Ericdu57', 'Michel38', 'Popol'];
        $messages = [
            'nul/20',
            'eclatax max',
            'tro bi1',
            'chouettuuu',
            'excellentissime.',
            'Très bien pour ma grand mère qui va courir le marathon ce week-end.',
            'je suis une fusée.',
        ];

        for ($i = 1; $i < 15; $i++) {

            /** @var Product $product */
            $product = $this->getReference(Product::class . $i);

            $commentsCount = random_int(0, 15);
            for ($j = 0; $j < $commentsCount; $j++) {

                if ($j % 5 === 0) {
                    sleep(1);
                }

                /** @var User $user */
                $user = $this->getReference(User::class . random_int(0, 6));

                $comment = (new Comment() )
                    ->setPseudo($pseudos[array_rand($pseudos)])
                    ->setUser($user)
                    ->setMessage($messages[array_rand($messages)])
                    ->setProduct($product)
                    ;

                $this->manager->persist($comment);
            }
        }
    }

    private function loadUsers(UserPasswordEncoderInterface $encoder) {
        $usernames = [ 'Seb', 'Michel', 'Bob', 'Chantal', 'Zöe', 'Loïc', 'Paul'];
        $passwords = ['blbla45', 'zoulougaga-78','zbzbz85', 'ijsdhjikvbhkj757', 'husdghhds45', 'fhfhsdfojh456', 'dsbjsbdhj4'];

        for ($i = 0; $i < 7; $i++) {
            $user = new User();
            $password = $passwords[$i];
            $encodedPassword = $encoder->encodePassword($user, $password);

            $user
                ->setUsername($usernames[$i])
                ->setPassword($encodedPassword)
                ;

            $this->manager->persist($user);
            $this->addReference(User::class.$i, $user);
        }
    }

}
