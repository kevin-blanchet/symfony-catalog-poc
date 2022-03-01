<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $tagList = [
            0 => "street"
            , 1 => "formal"
            , 2 => "colorful"
            , 3 => "fashionable"
            , 4 => "feminine"
            , 5 => "masculine"
            , 6 => "unisex"
            , 7 => "casual"
            , 8 => "sports"
        ];

        foreach ($tagList as $v){
            $tag = new Tag();
            $tag->setTagName($v);
            $manager->persist($tag);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group4', 'group5'];
    }
}