<?php

namespace App\DataFixtures;

use App\Entity\Instrument;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class InstrumentFixtures extends Fixture
{
    public const INSTRUMENTS = [
        ['name' => 'Grumphy the rocker',
            'picture' => 'grumphy-6295203a6fef7.jpg'],
        ['name' => 'Stratocaster 1958',
            'picture' => 'stratocaster-gilmour-black.jpg'],
        ['name' => 'Les Paul 1975',
            'picture' => 'gibson-les-paul.jpeg',],
        ['name' => 'Télécaster 1969',
            'picture' => 'telecaster.jpeg',],
        ['name' => 'Martin NY',
            'picture' => 'martin-ny.jpeg',],
        ['name' => 'Stratocaster série L',
            'picture' => 'stratocaster-gilmour-white.jpg',],
        ['name' => 'Jaguar',
            'picture' => 'fender-curt-kobain-jaguar.jpeg',],
        ['name' => 'SG', 'company' => 'Gibson',
            'picture' => 'gibson-sg.jpeg',],
        ['name' => 'Martin D-35',
            'picture' => 'gilmour-martin-d-35.jpg',],
        ['name' => '335',
            'picture' => 'gibson-335.jpeg',],
        ['name' => 'Gretsch White Penguin 6134',
            'picture' => 'fred-gretsch-white-penguin-6134-gilmour.jpg',],
        ['name' => 'Martin D-45',
            'picture' => '05-GRUHN-D-45.jpeg',],
    ];

    public const NUM_INSTRUMENTS = 300;

    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $uploadInstrumentDir = $this->parameterBag->get('upload_instrument_dir');
        if (!is_dir(__DIR__ . '/../../public/' . $uploadInstrumentDir)) {
            //créer un dossier de manière récursive
            mkdir(__DIR__ . '/../../public/' . $uploadInstrumentDir, recursive: true);
        }
        foreach (self::INSTRUMENTS as $instrumentData) {
            copy(
                __DIR__ . '/data/instruments/' . $instrumentData['picture'],
                __DIR__ . '/../../public/' . $uploadInstrumentDir . '/' . $instrumentData['picture']
            );
            $instrument = new Instrument();
            $instrument
                ->setName($instrumentData['name'])
                ->setPicture($instrumentData['picture']);
            $manager->persist($instrument);
        }

        for ($i = 0; $i < self::NUM_INSTRUMENTS; $i++) {
            $instrument = new Instrument();
            $instrument
                ->setName('Instrument ' . $i);
            $manager->persist($instrument);
        }

        $manager->flush();
    }
}
