<?php

namespace App\DataFixtures;

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

        $this->manager->flush();
    }

    private function loadProducts(): void
    {
        for ($i = 0; $i < 14; $i++) {
            $product = (new Product())
                ->setName('product '.$i)
                ->setDescription('Produit de description '.$i)
                ->setPrice(mt_rand(10, 100));

            $this->manager->persist($product);
        }
    }
}
