<?php

/**
 * Symfony FormType for Character Entity
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

use App\Entity\Character;
use App\Entity\Job;
use App\Entity\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

/**
 * Symfony FormType for Character Entity
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
class NewCharacterType extends AbstractType
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
        $errorMsg = 'Please upload a valid PNG or JPG/JPEG image!';
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Character Name?',
                ]
            )
            ->add(
                'bio',
                TextareaType::class,
                [
                    'label' => 'Bio?',
                ]
            )
            ->add(
                'role',
                EntityType::class,
                [
                    'class' => Role::class,
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                    'label' => 'Role?',
                ]
            )
            ->add(
                'primaryJob',
                EntityType::class,
                [
                    'class' => Job::class,
                    'choices' => $options['primary_jobs'],
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                    'label' => 'Primary Job?',
                ]
            )
            ->add(
                'secondaryJob',
                EntityType::class,
                [
                    'class' => Job::class,
                    'choices' => $options['secondary_jobs'],
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                    'label' => 'Secondary Job?',
                ]
            )
            ->add(
                'fileAttachment',
                FileType::class,
                [
                    'label' => 'Profile Picture?',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => (
                        new File(
                            [
                                'maxSize' => '2048k',
                                'mimeTypes' => (
                                    [
                                        'image/png',
                                        'image/jpeg',
                                    ]
                                ),
                                'mimeTypesMessage' => $errorMsg,
                            ]
                        )
                    ),
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Create',
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
                'data_class' => Character::class,
                'primary_jobs' => Job::class,
                'secondary_jobs' => Job::class,
            ]
        );
    }
}
