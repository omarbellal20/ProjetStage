<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $site= new Site();

        $site->setNom("Site A")->setAdresse("Maarif")->setVille("Casa")->setNumeroTel("0627272727");
        
        $manager->persist($site);
        $manager->flush();
    }
}
