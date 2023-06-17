<?php

namespace App\DataFixtures;

use App\Entity\Sound;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SoundFixtures extends Fixture implements DependentFixtureInterface
{
    public const SOUNDS = [
        ['title' => 'Another brick In The Wall', 'author' => 'Pink Floyd',
            'picture' => 'the-wall.jpeg',
            'file' => '7rPzEczIS574IgPaiPieS3', 'instrument' => 4, 'player' => 'spotify'],
        ['title' => 'Shine on you\'re crazy Diamond', 'author' => 'Pink Floyd',
            'picture' => 'shine-on-your-crazy-diamond.jpeg',
            'file' => '32dnKMni3I3gwUbWp4mi45', 'instrument' => 0, 'player' => 'spotify'],
        ['title' => 'Little Wing', 'author' => 'Jimi Hendrix',
            'picture' => 'little-wing.jpeg',
            'file' => '1Eolhana7nKHYpcYpdVcT5', 'instrument' => 4, 'player' => 'spotify'],
        ['title' => 'Comme as you are', 'author' => 'Nirvana',
            'picture' => 'come-as-you-are.jpeg',
            'file' => '2RsAajgo0g7bMCHxwH3Sk0', 'instrument' => 5, 'player' => 'spotify'],
        ['title' => 'Is it because I\'m black', 'author' => 'Syl Johnson',
            'picture' => 'is-it-because-im-black.jpeg',
            'file' => '7jIUxP1H9SoD6qq8YHjSTV', 'instrument' => 2, 'player' => 'spotify'],
        ['title' => 'I Changed My Mind', 'author' => 'Lyrics Born',
            'picture' => 'i-change-my-mind.jpeg',
            'file' => '05WBwrL0aq96FCwObMm2NB', 'instrument' => 2, 'player' => 'spotify'],
        ['title' => 'Thunderstruck', 'author' => 'AC/DC',
            'picture' => 'thunderstruck.jpeg',
            'file' => '57bgtoPSgt236HzfBOd8kj', 'instrument' => 6, 'player' => 'spotify'],
        ['title' => 'Sunshine Of Your Love', 'author' => 'Cream',
            'picture' => 'sunshine-of-your-love.jpeg',
            'file' => '6FRwDxXsvSasw0y2eDArsz', 'instrument' => 6, 'player' => 'spotify'],
        ['title' => 'Son Of Orange County - Live/1974', 'author' => 'Frank Zappa, The Mothers',
            'picture' => 'son-of-orange-county.jpeg',
            'file' => '3N41Uw9uOsYYcCzQYSECIF', 'instrument' => 6, 'player' => 'spotify'],
        ['title' => 'Up Above My Head', 'author' => 'Tosetta Tharpe',
            'picture' => 'sister-rosetta-tharpe.jpeg',
            'file' => 'JeaBNAXfHfQ', 'instrument' => 6, 'player' => 'youtube'],
        ['title' => 'Johnny B.Goode', 'author' => 'Chuck Berry',
            'picture' => 'johnny-b-goode.jpeg',
            'file' => '2QfiRTz5Yc8DdShCxG1tB2', 'instrument' => 8, 'player' => 'spotify'],
        ['title' => 'The Thrill Is Gone', 'author' => 'B.B. King',
            'picture' => 'the-thrill-is-gone.jpeg',
            'file' => '4NQfrmGs9iQXVQI9IpRhjM', 'instrument' => 8, 'player' => 'spotify'],
        ['title' => 'Room 335', 'author' => 'Larry Carlton/Lee Ritenour',
            'picture' => 'larry-carlton.jpeg',
            'file' => '7G9wvU1oJMQ', 'instrument' => 8, 'player' => 'youtube'],
        ['title' => 'Since I\'ve Been Loving You', 'author' => 'Led Zeppelin',
            'picture' => 'since-i-ve-been-lovin-you.jpeg',
            'file' => '2KLBEOWabSnDyA6PYEtj4Q', 'instrument' => 1, 'player' => 'spotify'],
        ['title' => 'La grange', 'author' => 'ZZ Top',
            'picture' => 'la-grange.jpeg',
            'file' => '0gQic5Bzrm8aPfOUSeEhbR', 'instrument' => 1, 'player' => 'spotify'],
        ['title' => 'Knockin\' On Heaven\'s Door', 'author' => 'Guns N\' Roses',
            'picture' => 'knockin-on-heaven-s-door.jpeg',
            'file' => '4JiEyzf0Md7KEFFGWDDdCr', 'instrument' => 1, 'player' => 'spotify'],
        ['title' => 'Sour Times', 'author' => 'Portishead',
            'picture' => 'sour-times.jpeg',
            'file' => '5IdRnW0NJdKBolaTmMF7Ux', 'instrument' => 9, 'player' => 'spotify'],
        ['title' => 'A Little Less Conversation', 'author' => 'Elvis Presley',
            'picture' => 'a-little-less-conversation.jpeg',
            'file' => '3j4viUIDSuB4xfYYlp3Lpa', 'instrument' => 9, 'player' => 'spotify'],
        ['title' => 'The needle and the damage done', 'author' => 'Neil Young',
            'picture' => 'the-needle-and-the-damage-done.jpeg',
            'file' => '4xyaNLTiyDTpUmpAM7ooLH', 'instrument' => 10, 'player' => 'spotify'],
        ['title' => 'Dogs', 'author' => 'Pink Floyd',
            'picture' => 'dogs.jpeg',
            'file' => '7yWdsy6UHRTun4hkJZJYNq', 'instrument' => 7, 'player' => 'spotify'],
    ];

    public function __construct(
        private ParameterBagInterface $parameterBag
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $soundsDir = __DIR__ . '/../../public' . $this->parameterBag->get('sounds_dir');
        if (!is_dir($soundsDir)) {
            mkdir($soundsDir, recursive: true);
        }
        foreach (self::SOUNDS as $soundArray) {
            $sound = new Sound();
            $sound->setTitle($soundArray['title']);
            $sound->setFile($soundArray['file']);
//            $sound->setArtist($soundArray['author']);
            copy(
                __DIR__ . '/data/sounds/' . $soundArray['picture'],
                $soundsDir . '/' . $soundArray['picture']
            );
            $sound->setPicture($soundArray['picture']);
            $sound->setInstrument($this->getReference('instrument_' . $soundArray['instrument']));
            $sound->setPlayer($this->getReference('player_' . $soundArray['player']));
            $manager->persist($sound);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            InstrumentFixtures::class,
            PlayerFixtures::class
        ];
    }
}
