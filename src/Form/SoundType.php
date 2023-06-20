<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Instrument;
use App\Entity\Sound;
use App\Repository\ArtistRepository;
use App\Repository\InstrumentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class SoundType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('imageFile', VichFileType::class)
            ->add('file')
            ->add('instrument', EntityType::class, [
                'class' =>  Instrument::class,
                'choice_label' => 'name',
                'query_builder' => function (InstrumentRepository $instrumentRepository) {
                    return $instrumentRepository->createQueryBuilder('i')
                        ->andWhere('i.picture IS NOT NUll')
                        ->orderBy('i.name', 'ASC');
                },
                'group_by' => function (Instrument $instrument) {
                    return $instrument->getCompany()->getName();
                }
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
                'query_builder' => function (ArtistRepository $artistRepository) {
                    return $artistRepository->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                }
            ])
            ->add('player', null, [
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sound::class,
        ]);
    }
}
