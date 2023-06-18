<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArtistFixtures extends Fixture
{
    public const ARTISTS = [
        'Pink Floyd',
        'Jimi Hendrix',
        'Nirvana',
        'Syl Johnson',
        'Lyrics Born',
        'AC/DC',
        'Cream',
        'Frank Zappa, The Mothers',
        'Tosetta Tharpe',
        'Chuck Berry',
        'B.B. King',
        'Larry Carlton',
        'Led Zeppelin',
        'ZZ Top',
        'Guns N\' Roses',
        'Portishead',
        'Elvis Presley',
        'Neil Young'
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::ARTISTS as $artistName) {
            $artist = new Artist();
            $artist->setName($artistName);
            $this->addReference($artistName, $artist);
            $manager->persist($artist);
        }
        $manager->flush();
    }
}
