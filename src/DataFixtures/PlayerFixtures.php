<?php

namespace App\DataFixtures;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlayerFixtures extends Fixture
{
    public const PLAYERS = [
      'spotify',
      'youtube',
      'local'
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PLAYERS as $playerName) {
            $player = new Player();
            $player->setName($playerName);
            $manager->persist($player);
            $this->addReference('player_' . $playerName, $player);
        }
        $manager->flush();
    }
}
