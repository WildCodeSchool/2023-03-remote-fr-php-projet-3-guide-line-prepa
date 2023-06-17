<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CompanyFixtures extends Fixture
{
    public const COMPANIES = [
      ['name' => 'Fender', 'logo' => 'Fender-Logo-JPG_1211322105-400.png'],
      ['name' => 'Gibson', 'logo' => '2-x-GIBSON-guitare-Poupee-Logo-Autocollant-Vinyle.png'],
      ['name' => 'Gretsch', 'logo' => 'gretsch.png'],
      ['name' => 'Martin', 'logo' => 'martin-logo.png']
    ];

    /**
     * CompanyFixtures constructor.
     */
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::COMPANIES as $val) {
            $company = new Company();
            $company->setName($val['name']);
            $company->setLogo($val['logo']);
            $companyDir = __DIR__ . '/../../public' . $this->parameterBag->get('company_dir');
            if (!is_dir($companyDir)) {
                mkdir($companyDir, recursive: true);
            }
            copy(
                __DIR__ . '/data/company/' . $val['logo'],
                $companyDir . '/' . $val['logo']
            );
            $this->addReference('company_' . $val['name'], $company);
            $manager->persist($company);
        }
        $manager->flush();
    }
}
