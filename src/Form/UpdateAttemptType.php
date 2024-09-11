<?php

/**
 * Symfony Form for Attempt Entity
 *
 * PHP version 8.3
 *
 * @category  Controller
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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Symfony Form for Attempt Entity
 *
 * @category  Controller
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
     * Build the form
     *
     * @param FormBuilderInterface $builder The Form Builder
     * @param array                $options Any options needed to make the form work
     *
     * @return void
     **/
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
     * Configure the options for the Form
     *
     * @param OptionsResolver $resolver The Options Resolver
     *
     * @return void
     **/
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Attempt::class,
            ]
        );
    }
}
