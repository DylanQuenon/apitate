<?php

namespace App\DataFixtures;

use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        //tags table
        $tags = ['Shooting', 'Cover', 'Concert', 'Event'];

        //Itirate over tags
        foreach ($tags as $t) {
            $tag = new Tags();
            $tag->setName($t);
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
