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

        $this->loadImages();
        $this->loadProducts();
        // $this->loadBrands();

        $this->manager->flush();
    }

    private function loadImages()
    {
        for($i = 1; $i <15; $i++) {
            $image = (new Image())
                ->setUrl('shoe-'.$i.'.jpg')
                ->setAlt('Shoe'.$i);

            $this->manager->persist($image);
            $this->addReference('image'.$i, $image);
        }
    }

    private function loadProducts(): void
    {
        for ($i = 0; $i < 14; $i++) {
            $product = (new Product())
                ->setName('product '.$i)
                ->setDescription('Produit de description '.$i)
                ->setPrice(mt_rand(10, 100))
                ->setImage($this->getReference('image'.$i));

            $this->manager->persist($product);
        }
    }

}
