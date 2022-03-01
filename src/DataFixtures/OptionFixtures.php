<?php

namespace App\DataFixtures;

use App\Entity\Option;
use App\Repository\OptionTypeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OptionFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private $optionTypeRepository;

    public function __construct(OptionTypeRepository $optionTypeRepository)
    {
        $this->optionTypeRepository = $optionTypeRepository;
    }

    public function load(ObjectManager $manager)
    {
        $optionTypes = [
            "shoe_size" => $this->optionTypeRepository->findOneBy(["optionTypeName" => "shoe_size"])
            , "eu_size" => $this->optionTypeRepository->findOneBy(["optionTypeName" => "eu_size"])
        ];

        $shoeSizeOptions = [
            0 => "38"
            , 1 => "39"
            , 2 => "40"
            , 3 => "41"
            , 4 => "42"
            , 5 => "43"
            , 6 => "44"
            , 7 => "45"
            , 8 => "46"
        ];
        $euSizeOptions = [
            0 => "XS"
            , 1 => "S"
            , 2 => "M"
            , 3 => "L"
            , 4 => "XL"
        ];

        foreach ($shoeSizeOptions as $k => $v){
            $option = new Option();
            $option->setOptionName($v);
            $option->setOptionType($optionTypes["shoe_size"]);
            $option->setAsort($k);
            $manager->persist($option);
        }

        foreach ($euSizeOptions as $k => $v){
            $option = new Option();
            $option->setOptionName($v);
            $option->setOptionType($optionTypes["eu_size"]);
            $option->setAsort($k);
            $manager->persist($option);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OptionTypeFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['group2', 'group5'];
    }
}