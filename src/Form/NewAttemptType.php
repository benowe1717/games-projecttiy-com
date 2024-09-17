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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
class NewAttemptType extends AbstractType
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
                    'label' => 'Character',
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
                'submit',
                SubmitType::class,
                [
                    'label' => 'Start',
                ]
            );
        // $builder
        //     ->add('attemptNumber')
        //     ->add('isCurrent')
        //     ->add('timePlayed')
        //     ->add('causeOfDeath')
        //     ->add('adventureLevel')
        //     ->add('characterId', EntityType::class, [
        //         'class' => Character::class,
        //         'choice_label' => 'id',
        //     ])
        //     ->add('milestones', EntityType::class, [
        //         'class' => Milestone::class,
        //         'choice_label' => 'id',
        //         'multiple' => true,
        //     ])
        // ;
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
