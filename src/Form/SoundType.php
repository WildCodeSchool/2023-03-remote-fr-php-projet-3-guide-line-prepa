<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Player;
use App\Entity\Sound;
use App\Repository\InstrumentRepository;
use App\Repository\PlayerRepository;
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
            ->add('file')
            ->add('imageFile', VichFileType::class, [
                'required' => false
            ])
            ->add('instrument', EntityType::class, [
                'class' => Instrument::class,
                'choice_label' => 'name',
                'query_builder' => function (InstrumentRepository $instrumentRepository) {
                    return $instrumentRepository->createQueryBuilder('i')
                        ->andWhere('i.picture IS NOT NULL')
                        ->orderBy('i.name', 'ASC');
                },
                'group_by' => function (Instrument $instrument) {
                    return $instrument->getCompany()->getName();
                }
            ])
            ->add('artist', null, [
                'choice_label' => 'name'
            ])
            ->add('player', EntityType::class, [
                'class' => Player::class,
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
