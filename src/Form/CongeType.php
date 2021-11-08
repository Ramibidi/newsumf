<?php

namespace App\Form;

use App\Entity\Conges;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iduser')
            ->add('startdate')
            ->add('numberdays')

            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'En_COURS',
                    'validée'  => 'VALIDEE',
                    'refusée'  => 'REFUSE',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Statut de la demande',
                'data' => ['EN_COURS']

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conges::class,
        ]);
    }
}
