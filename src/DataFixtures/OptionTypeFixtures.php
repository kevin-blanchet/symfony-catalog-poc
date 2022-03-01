<?php

namespace App\DataFixtures;

use App\Entity\OptionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class OptionTypeFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $optionTypes = [
            0 => "shoe_size"
            , 1 => "eu_size"
        ];

        foreach ($optionTypes as $v){
            $optionType = new OptionType();
            $optionType->setOptionTypeName($v);
            $manager->persist($optionType);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1', 'group2', 'group5'];
    }
}