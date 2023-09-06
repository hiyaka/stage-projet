<?php

namespace App\Form;

use App\Entity\Salles;
use App\Entity\Category;
use App\Entity\Demandes;
use Doctrine\ORM\QueryBuilder;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AtriumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'label' => 'Le type de votre demande :',
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $cr): QueryBuilder {
                    return $cr->createQueryBuilder('c')
                        ->where('c.name = :categoryName')
                        ->setParameter('categoryName', 'Atrium');
                },
                'choice_label' => 'name',

            ])
            // ->add('createdAt', DateType::class, [
            //     'label' => 'Date de la demande :',
            //     'placeholder' => [
            //         'year' => 'Année',
            //         'month' => 'Mois',
            //         'day' => 'Jour',
            //     ],
            //     'widget' => 'choice',
            //     'input'  => 'datetime_immutable'
            // ])
            // ->add('user')
            // ->add('salles', EntityType::class, [
            //     'label' => 'La salle :',
            //     'placeholder' => '--Choisissez une salle--',
            //     'class' => Salles::class,
            //     'choice_label' => 'name'
            // ])
            ->add('description', TextareaType::class, [
                'label' => 'Votre demande :',
                'attr' => [
                    // 'class' => 'form-control',
                    'placeholder' => 'Tapez votre demande ici'
                ],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demandes::class,
        ]);
    }
}
