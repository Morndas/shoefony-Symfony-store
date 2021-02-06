<?php

namespace App\DataFixtures;

use App\Entity\Store\Image;
use App\Entity\Store\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadProducts();
        // $this->loadBrands();

        $this->manager->flush();
    }

    private function loadProducts(): void
    {
        for ($i = 1; $i <= 14; $i++) {
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

            $this->manager->persist($product);
        }
    }

}
