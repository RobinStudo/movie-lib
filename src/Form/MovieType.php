<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Person;
use App\Repository\CategoryRepository;
use App\Repository\PersonRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                "label" => "Titre",
            ])
            ->add('description', null, [
                "label" => "Description",
                "attr" => [
                    "rows" => 10,
                ]

            ])
            ->add('poster')
            ->add('releasedAt', DateType::class, [
                "label" => "Créé le",
                "widget" => "single_text",
                "html5" => true,
            ])
            ->add('isBad')
            ->add('category', EntityType::class, [
                "label" => "Catégorie",
                "class" => Category::class,
                "choice_label" => "name",
                "query_builder" => function(CategoryRepository $categoryRepository) {
                    return $categoryRepository->createQueryBuilder("c")->orderBy("c.name", "ASC");
                }
            ])
            ->add('director', EntityType::class, [
                "label" => "Directeur",
                "class" => Person::class,
                "choice_label" => function(Person $person) {
                    return $person->getLastname()." ".$person->getFirstname();
                },
                "query_builder" => function(PersonRepository $personRepository) {
                    return $personRepository->createQueryBuilder("p")->orderBy("p.lastname", "ASC");
                }
            ])
            ->add('actors', EntityType::class, [
                "label" => "Acteurs",
                "class" => Person::class,
                "choice_label" => function(Person $person) {
                    return $person->getLastname()." ".$person->getFirstname();
                },
                "multiple" => true,
                "query_builder" => function(PersonRepository $personRepository) {
                    return $personRepository->createQueryBuilder("p")->orderBy("p.lastname", "ASC");
                }
            ])
            ->add('save', SubmitType::class, [
                "label" => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
