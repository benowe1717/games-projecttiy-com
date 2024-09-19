<?php

/**
 * Symfony FormType for Attempt Entity
 *
 * PHP version 8.3
 *
 * @category  Form
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   CVS: $Id:$
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/

namespace App\Form;

use App\Entity\Attempt;
use App\Entity\Character;
use App\Entity\Milestone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Symfony FormType for Attempt Entity
 *
 * PHP version 8.3
 *
 * @category  Form
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class UpdateAttemptType extends AbstractType
{
    /**
     * Build the Form Interface for the Controller to render
     *
     * @param FormBuilderInterface $builder FormBuilderInterface
     * @param array                $options Options for Form Builder
     *
     * @return void
     **/
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'characterId',
                EntityType::class,
                [
                    'class' => Character::class,
                    'choices' => $options['characters'],
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                    'label' => 'Character'
                ]
            )
            ->add(
                'adventureLevel',
                NumberType::class,
                [
                    'label' => 'Adventure Level?',
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Adventure Level cannot be empty!'
                            ]
                        ),
                        new LessThanOrEqual(65),
                        new GreaterThanOrEqual(1),
                    ]
                ]
            )
            ->add(
                'timePlayed',
                NumberType::class,
                [
                    'label' => 'Time Played?',
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Time Played cannot be empty!'
                            ]
                        ),
                        new GreaterThanOrEqual(1),
                    ]
                ]
            )
            ->add(
                'milestones',
                EntityType::class,
                [
                    'class' => Milestone::class,
                    'choice_label' => function (Milestone $milestone): string {
                        $name = $milestone->getName();
                        $desc = $milestone->getDescription();
                        return "{$name} ({$desc})";
                    },
                    'choice_value' => 'id',
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'Expeditions Completed?',
                ]
            )
            ->add(
                'causeOfDeath',
                TextType::class,
                [
                    'label' => 'Cause of death?',
                ]
            )
            ->add(
                'completed',
                ChoiceType::class,
                [
                    'choices' => [
                        'No' => false,
                        'Yes' => true,
                    ],
                    'mapped' => false,
                    'label' => 'Challenge completed?',
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Update'
                ]
            );
    }

    /**
     * Pass the needed Data Classes to the Form Builder
     *
     * @param OptionsResolver $resolver The resolver from Class Objects to Form
     *
     * @return void
     **/
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Attempt::class,
                'characters' => Character::class,
            ]
        );
    }
}
