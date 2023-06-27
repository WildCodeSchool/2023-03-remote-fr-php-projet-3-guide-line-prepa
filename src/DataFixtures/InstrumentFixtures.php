<?php

namespace App\DataFixtures;

use App\Entity\Instrument;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class InstrumentFixtures extends Fixture implements DependentFixtureInterface
{
    public const INSTRUMENTS = [
        0 => ['name' => 'Stratocaster 1958', 'company' => 'Fender',
            'picture' => 'stratocaster-gilmour-black.png', 'category' => 0],
        1 => ['name' => 'Stratocaster Ultra 1980', 'company' => 'Fender',
            'picture' => 'stratocaster-gilmour-white.png', 'category' => 0],
        2 => ['name' => 'Les Paul 1975', 'company' => 'Gibson',
            'picture' => 'gibson-les-paul.png', 'category' => 0],
        3 => ['name' => 'Télécaster 1969', 'company' => 'Fender',
            'picture' => 'telecaster.png', 'category' => 0],
        4 => ['name' => 'Martin NY', 'company' => 'Martin',
            'picture' => 'martin-ny.png', 'category' => 1],
        5 => ['name' => 'Stratocaster série L', 'company' => 'Fender',
            'picture' => 'stratocaster-gilmour-white.png', 'category' => 0],
        6 => ['name' => 'Jaguar', 'company' => 'Fender',
            'picture' => 'fender-curt-kobain-jaguar.png', 'category' => 0],
        7 => ['name' => 'SG', 'company' => 'Gibson',
            'picture' => 'gibson-sg.png', 'category' => 0],
        8 => ['name' => 'Martin D-35', 'company' => 'Martin',
            'picture' => 'gilmour-martin-d-35.png', 'category' => 1],
        9 => ['name' => '335', 'company' => 'Gibson',
            'picture' => 'gibson-335.png', 'category' => 0],
        10 => ['name' => 'Gretsch White Penguin 6134', 'company' => 'Gretsch',
            'picture' => 'fred-gretsch-white-penguin-6134-gilmour.png', 'category' => 0],
        11 => ['name' => 'Martin D-45', 'company' => 'Martin',
            'picture' => '05-GRUHN-D-45.png', 'category' => 1],
    ];

    public const NUM_INSTRUMENTS = 300;

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly SluggerInterface $slugger
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $uploadInstrumentDir = $this->parameterBag->get('instrument_dir');
        if (!is_dir(__DIR__ . '/../../public' . $uploadInstrumentDir)) {
            //créer un dossier de manière récursive
            mkdir(__DIR__ . '/../../public' . $uploadInstrumentDir, recursive: true);
        }
        foreach (self::INSTRUMENTS as $key => $instrumentData) {
            copy(
                __DIR__ . '/data/instruments/' . $instrumentData['picture'],
                __DIR__ . '/../../public' . $uploadInstrumentDir . '/' . $instrumentData['picture']
            );
            $instrument = new Instrument();
            $instrument
                ->setName($instrumentData['name'])
                ->setSlug($this->slugger->slug(strtolower($instrumentData['name'])))
                ->setSummary($faker->text($faker->numberBetween(50, 80)))
                ->setDescription(implode("", array_map(function ($item) {
                    return "<p>" . $item . "</p>";
                }, $faker->paragraphs($faker->numberBetween(6, 12)))))
                ->setReleaseAt($faker->dateTimeBetween('-70 years', '-40 years'))
                ->setCompany($this->getReference('company_' . $instrumentData['company']))
                ->setCategory($this->getReference('category_' . $instrumentData['category']))
                ->setPicture($instrumentData['picture']);
            $this->addReference('instrument_' . $key, $instrument);
            $manager->persist($instrument);
        }

        for ($key = 0; $key < count(CategoryFixtures::CATEGORIES); $key++) {
            for ($i = 0; $i < self::NUM_INSTRUMENTS; $i++) {
                $instrument = new Instrument();
                $name = $faker->sentence(2);
                $instrument
                    ->setName($name)
                    ->setSlug($this->slugger->slug(strtolower($name)))
                    ->setSummary($faker->text($faker->numberBetween(50, 80)))
                    ->setDescription(implode("", array_map(function ($item) {
                        return "<p>" . $item . "</p>";
                    }, $faker->paragraphs($faker->numberBetween(3, 7)))))
                    ->setReleaseAt($faker->dateTimeBetween('-70 years', '-40 years'))
                    ->setCompany($this->getReference(
                        'company_' .
                        CompanyFixtures::COMPANIES[$faker->numberBetween(0, 3)]['name']
                    ))
                    ->setCategory($this->getReference('category_' . $key));
                $manager->persist($instrument);
            }
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          CompanyFixtures::class,
          CategoryFixtures::class
        ];
    }
}
