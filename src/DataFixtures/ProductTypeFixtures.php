<?php

namespace App\DataFixtures;

use App\Entity\ProductType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProductTypeFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $productTypes = [
            0 => "shoe"
            , 1 => "tshirt"
        ];

        foreach ($productTypes as $v){
            $productType = new ProductType();
            $productType->setProductTypeName($v);
            $manager->persist($productType);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group3', 'group5'];
    }
}